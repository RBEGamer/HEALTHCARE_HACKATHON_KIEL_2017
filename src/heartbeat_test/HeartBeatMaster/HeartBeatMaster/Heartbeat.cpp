//
//  Heartbeat.cpp
//  Heartbeat
//
//  Created by Philipp Rouast on 4/06/2016.
//  Copyright © 2016 Philipp Roüast. All rights reserved.
//

#include "Heartbeat.hpp"

#include <opencv2/imgcodecs.hpp>
#include <opencv2/videoio/videoio.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
#include "opencv.hpp"
#include "FFmpegDecoder.hpp"
#include "FFmpegEncoder.hpp"
#include "Baseline.hpp"


#include "PracticalSocket.h" // For UDPSocket and SocketException
#include <iostream>          // For cout and cerr
#include <cstdlib>           // For atoi()
#define BUF_LEN 65540 // Larger than maximum UDP packet size
#include "config.h"



#define DEFAULT_ALGORITHM "g"
#define DEFAULT_RESCAN_FREQUENCY 1
#define DEFAULT_SAMPLING_FREQUENCY 1
#define DEFAULT_MIN_SIGNAL_SIZE 5
#define DEFAULT_MAX_SIGNAL_SIZE 5
#define DEFAULT_DOWNSAMPLE 1 // x means only every xth frame is used

using namespace cv;

Heartbeat::Heartbeat(int argc_, char * argv_[], bool switches_on_) {
    argc = argc_;
    argv.resize(argc);
    copy(argv_, argv_ + argc, argv.begin());
    switches_on = switches_on_;
    // map the switches to the actual
    // arguments if necessary
    if (switches_on) {
        vector<string>::iterator it1, it2;
        it1 = argv.begin();
        it2 = it1 + 1;
        while (true) {
            if (it1 == argv.end()) break;
            if (it2 == argv.end()) break;
            if ((*it1)[0] == '-')
                switch_map[*it1] = *(it2);

            it1++;
            it2++;
        }
    }
}

string Heartbeat::get_arg(int i) {

    if (i >= 0 && i < argc)
        return argv[i];

    return "";
}

string Heartbeat::get_arg(string s) {

    if (!switches_on) return "";

    if (switch_map.find(s) != switch_map.end())
        return switch_map[s];

    return "";
}

bool to_bool(string s) {
    bool result;
    transform(s.begin(), s.end(), s.begin(), ::tolower);
    istringstream is(s);
    is >> boolalpha >> result;
    return result;
}

rPPGAlgorithm to_algorithm(string s) {
    rPPGAlgorithm result;
    if (s == "g") result = g;
    else if (s == "pca") result = pca;
    else if (s == "xminay") result = xminay;
    else {
        std::cout << "Please specify valid algorithm (g, pca, xminay)!" << std::endl;
        exit(0);
    }
    return result;
}

int main(int argc, char * argv[]) {

    Heartbeat cmd_line(argc, argv, true);

    string input = cmd_line.get_arg("-i"); // Filepath for offline mode

    string algorithmString = cmd_line.get_arg("-a");
    rPPGAlgorithm  algorithm = to_algorithm(DEFAULT_ALGORITHM);
    string rescanFrequencyString = cmd_line.get_arg("-r");
    double rescanFrequency = DEFAULT_RESCAN_FREQUENCY;
    string samplingFrequencyString = cmd_line.get_arg("-f").c_str();
    double samplingFrequency = DEFAULT_SAMPLING_FREQUENCY;
    string maxSignalSizeString = cmd_line.get_arg("-max");
    int maxSignalSize = DEFAULT_MAX_SIGNAL_SIZE;
    string minSignalSizeString = cmd_line.get_arg("-min");
    int  minSignalSize = DEFAULT_MIN_SIGNAL_SIZE;


    // visualize baseline setting
    string baseline_input = cmd_line.get_arg("-baseline");

    if (minSignalSize > maxSignalSize) {
        std::cout << "Max signal size must be greater or equal min signal size!" << std::endl;
        exit(0);
    }


    string guiString = cmd_line.get_arg("-gui");
    bool  gui = true;
    string logString = cmd_line.get_arg("-log");
    bool log = false;
    int downsample = DEFAULT_DOWNSAMPLE;
    string downsampleString = cmd_line.get_arg("-ds");


    const string CLASSIFIER_PATH = "haarcascade_frontalface_alt.xml";

    std::ifstream test(CLASSIFIER_PATH);
    if (!test) {
        std::cout << "Face classifier xml not found!" << std::endl;
        exit(0);
    }




    unsigned short servPort = 4242; // First arg:  local port
    namedWindow("recv", CV_WINDOW_NORMAL);

    try {
        UDPSocket sock(servPort);

        char buffer[BUF_LEN]; // Buffer for echo string
        int recvMsgSize; // Size of received message
        string sourceAddress; // Address of datagram source
        unsigned short sourcePort; // Port of datagram source

        clock_t last_cycle = clock();


        //VideoCapture cap(0);
        //if (!cap.isOpened()) {
        //    return -1;
        //}

        // Configure logfile path
        std::ostringstream filepath;
        filepath << "Live_ffmpeg";
        const string LOG_PATH = filepath.str();

        const int WIDTH  = 1024;//cap.get(CV_CAP_PROP_FRAME_WIDTH);
        const int HEIGHT = 576;//cap.get(CV_CAP_PROP_FRAME_HEIGHT);
        const double FPS = 30;//cap.get(CV_CAP_PROP_FPS);
        const long MSEC = 0;//cap.get(CV_CAP_PROP_POS_MSEC);
        const double TIME_BASE = 0.001;
        cout << "SIZE: " << WIDTH << "x" << HEIGHT << endl;
        cout << "FPS: " << FPS << endl;
        cout << "MSEC: " << MSEC << endl;

        std::ostringstream title;
        title << "rPPG online - " << WIDTH << "x" << HEIGHT << " -a " << algorithm << " -r " << rescanFrequency << " -f " << samplingFrequency << " -min " << minSignalSize << " -max " << maxSignalSize << " -ds " << downsample;

        RPPG rppg = RPPG();
        rppg.load(algorithm,
                  WIDTH, HEIGHT, TIME_BASE, downsample,
                  samplingFrequency, rescanFrequency,
                  minSignalSize, maxSignalSize,
                  LOG_PATH, CLASSIFIER_PATH,
                  log, gui);

        Mat frameRGB;
        Mat frameRGB_resized;
        int i = 0;

        // Main loop
        while (true) {

          do {
              recvMsgSize = sock.recvFrom(buffer, BUF_LEN, sourceAddress, sourcePort);
          } while (recvMsgSize > sizeof(int));
          int total_pack = ((int * ) buffer)[0];

          cout << "expecting length of packs:" << total_pack << endl;
          char * longbuf = new char[PACK_SIZE * total_pack];
          for (int i = 0; i < total_pack; i++) {
              recvMsgSize = sock.recvFrom(buffer, BUF_LEN, sourceAddress, sourcePort);
              if (recvMsgSize != PACK_SIZE) {
                  cerr << "Received unexpected size pack:" << recvMsgSize << endl;
                  continue;
              }
              memcpy( & longbuf[i * PACK_SIZE], buffer, PACK_SIZE);
          }

          cout << "Received packet from " << sourceAddress << ":" << sourcePort << endl;

          Mat rawData = Mat(1, PACK_SIZE * total_pack, CV_8UC1, longbuf);
          /*Mat*/ frameRGB = imdecode(rawData, CV_LOAD_IMAGE_COLOR);
          if (frameRGB.size().width == 0) {
              cerr << "decode failure!" << endl;
              continue;
          }
          imshow("recv", frameRGB);
          free(longbuf);



          //  cap.read(frameRGB);

            if (i % downsample == 0) {

                int64_t time = (cv::getTickCount()*1000.0)/cv::getTickFrequency();

                // Generate grayframe
                Mat frameGray;
                resize(frameRGB,frameRGB_resized,Size(WIDTH,HEIGHT));
                cv::cvtColor(frameRGB_resized, frameGray, CV_BGR2GRAY);
                cv::equalizeHist(frameGray, frameGray);

                if (frameRGB.empty()) {
                    while (waitKey() != 27) {}
                    break;
                }

                rppg.processFrame(frameRGB_resized, frameGray, time);


                    imshow(title.str(), frameRGB_resized);


            } else {

                cout << "SKIPPING FRAME TO DOWNSAMPLE!" << endl;
            }

            if (waitKey(30) == 27) {
                break;
            }

            i++;
        }

      }catch (SocketException & e) {
          cerr << e.what() << endl;
          exit(1);
      }

    return 0;
}
