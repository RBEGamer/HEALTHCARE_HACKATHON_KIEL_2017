#!/usr/bin/env python
# -*- coding: utf8 -*-

import RPi.GPIO as GPIO
import MFRC522
import signal
import requests
import os
import sys
import select
import time
import serial

continue_reading = True

patientennotiz_server = 'http://18.194.182.2/patientennotiz'
terminal_uuid = "1137"


ser = serial.Serial(
    port='/dev/tty1', ################# SERIAL BARCODE SCANNER ############
    baudrate=9600,        # change to 9600 baud see script.ino
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)
ser.isOpen()


# Capture SIGINT for cleanup when the script is aborted
def clean_up(signal, frame):
    ser.close()
    global continue_reading
    print "Ctrl+C captured, ending read."
    continue_reading = False
    GPIO.cleanup()



# Hook the SIGINT
signal.signal(signal.SIGINT, clean_up)

line = []
MIFAREReader = MFRC522.MFRC522()
comb_uid = ''
stdin_fd = sys.stdin.fileno()

while continue_reading:

    # Scan for cards
    (status, TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    # If a card is found
    if status == MIFAREReader.MI_OK:
        print "Card detected"
        (status, uid) = MIFAREReader.MFRC522_Anticoll()
        if status == MIFAREReader.MI_OK:
            comb_uid =  str(uid[0]) + str(uid[1]) + str(uid[2])  + str(uid[3])
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
                r = requests.get(patientennotiz_server +  "/login_employee.php?termid=" + terminal_uuid + "&empid=" + comb_uid)
                if r.status_code == 200:
                    print r.text
                else:
                    print "login failed"
                    comb_uid = ''




    for c in ser.read():
        line.append(c)
        if c == '\n':
            print("Line: " + line)
            r = requests.get(patientennotiz_server +  "/login_patient_terminal.php?termid=" + terminal_uuid + "&empid=" + comb_uid +"&bcdata="+line)
            if r.status_code == 200:
                print r.text
            else:
                print "login patient failed"
            line = []

