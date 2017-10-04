import sys
import os

sys.path.append(os.path.dirname(os.path.expanduser('~/MFRC522-python/MFRC522.py')))

patientennotiz_server = 'http://18.194.182.2/patientennotiz'
terminal_uuid = "1137"
bc_reader_sys_file = '/dev/hidraw0'

import RPi.GPIO as GPIO
import MFRC522
import signal
import requests
import os
import sys
import select
import time
import serial


hid = {4: 'a', 5: 'b', 6: 'c', 7: 'd', 8: 'e', 9: 'f', 10: 'g', 11: 'h', 12: 'i', 13: 'j', 14: 'k', 15: 'l', 16: 'm',
       17: 'n', 18: 'o', 19: 'p', 20: 'q', 21: 'r', 22: 's', 23: 't', 24: 'u', 25: 'v', 26: 'w', 27: 'x', 28: 'y',
       29: 'z', 30: '1', 31: '2', 32: '3', 33: '4', 34: '5', 35: '6', 36: '7', 37: '8', 38: '9', 39: '0', 44: ' ',
       45: '-', 46: '=', 47: '[', 48: ']', 49: '\\', 51: ';', 52: '\'', 53: '~', 54: ',', 55: '.', 56: '/'}

hid2 = {4: 'A', 5: 'B', 6: 'C', 7: 'D', 8: 'E', 9: 'F', 10: 'G', 11: 'H', 12: 'I', 13: 'J', 14: 'K', 15: 'L', 16: 'M',
        17: 'N', 18: 'O', 19: 'P', 20: 'Q', 21: 'R', 22: 'S', 23: 'T', 24: 'U', 25: 'V', 26: 'W', 27: 'X', 28: 'Y',
        29: 'Z', 30: '!', 31: '@', 32: '#', 33: '$', 34: '%', 35: '^', 36: '&', 37: '*', 38: '(', 39: ')', 44: ' ',
        45: '_', 46: '+', 47: '{', 48: '}', 49: '|', 51: ':', 52: '"', 53: '~', 54: '<', 55: '>', 56: '?'}

fp = open('/dev/hidraw0', 'rb')

read_barcode = ""
shift = False


def clean_up(signal, frame):
    print "Ctrl+C captured, ending read."
    continue_reading = False
    GPIO.cleanup()
    fp.close();



# Hook the SIGINT
signal.signal(signal.SIGINT, clean_up)


MIFAREReader = MFRC522.MFRC522()




comb_uid = ''


while 42:
    buffer = fp.read(8)
    for c in buffer:
        if ord(c) > 0:
            if int(ord(c)) == 40: #40 = Carrage return code
                print 'read_barcode_data: '+ read_barcode
                r = requests.get(
                    patientennotiz_server + "/login_patient_terminal.php?termid=" + terminal_uuid + "&empid=" + comb_uid + "&bcdata=" + read_barcode)
                if r.status_code == 200:
                    print r.text
                else:
                    print "login patient failed"
                read_barcode = ''
                continue
            if shift:
                if int(ord(c)) == 2:
                    shift = True
                else:
                    read_barcode += hid2[int(ord(c))]
                    shift = False
            else:
                if int(ord(c)) == 2:
                    shift = True
                else:
                    read_barcode += hid[int(ord(c))]

    (status, TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    # If a card is found
    if status == MIFAREReader.MI_OK:
        print "Card detected"
        (status, uid) = MIFAREReader.MFRC522_Anticoll()
        if status == MIFAREReader.MI_OK:
            comb_uid = str(uid[0]) + str(uid[1]) + str(uid[2]) + str(uid[3])
            print 'cardholder_UID ' + comb_uid
            key = [0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF]
            MIFAREReader.MFRC522_SelectTag(uid)
            status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)
            access_ok = 0
            if status == MIFAREReader.MI_OK:
                MIFAREReader.MFRC522_Read(8)
                MIFAREReader.MFRC522_StopCrypto1()
                access_ok = 1
            else:
                print "Authentication error"

            if int(comb_uid) > 0 and access_ok and comb_uid.isdigit():
                print "ok"
                r = requests.get(
                    patientennotiz_server + "/login_employee.php?termid=" + terminal_uuid + "&empid=" + comb_uid)
                if r.status_code == 200:
                    print r.text
                else:
                    print "login failed"
                    comb_uid = ''
