#!/bin/sh

g++ -std=c++11 -lopencv_core -lopencv_highgui -lopencv_imgcodecs -lopencv_imgproc -lopencv_objdetect -lopencv_video -lopencv_videoio -lavcodec -lavformat -lavutil -lswscale  Heartbeat.cpp FFmpegDecoder.cpp FFmpegEncoder.cpp opencv.cpp RPPG.cpp Baseline.cpp PracticalSocket.cpp -o Heartbeat

./Heartbeat
