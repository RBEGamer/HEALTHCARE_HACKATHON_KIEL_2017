#!bin/sh

cd ~

sudo -H pip install qibuild --user

PATH=$PATH:$HOME/.local/bin
PATH=$PATH:$HOME/Library/Python/2.7/bin

echo -e "please choose your generator and ide for mac 3 and 4"

qibuild config --wizard

wget https://community-static.aldebaran.com/resources/2.1.4.13/sdk-c%2B%2B/naoqi-sdk-2.1.4.13-mac64.tar.gz ./naoqi_cpp.tar.gz

tar -xvf ./naoqi_cpp
rm naoqi_cpp.tar.gz
mkdir naoqi_sdk_cpp
cd naoqi_sdk_cpp
qibuild init
cd ..
cp -R ./naoqi_cpp ./naoqi_sdk_cpp
rm -R ./naoqi_sdk_cpp

cd ~/naoqi_sdk/naoqi_cpp/doc/dev/cpp/examples/
#create toolchain with name naoqi_main_toolchain
qitoolchain create naoqi_main_toolchain ~/naoqi_sdk/naoqi_cpp/toolchain.xml
qibuild add-config naoqi_main_toolchain -t naoqi_main_toolchain --default


#IMPORTANT FOR MAC USERS


# this command habe to be in the ~/naoqi_sdk/naoqi_cpp/doc/dev/cpp/examples/ path
#export DYLD_LIBRARY_PATH=${DYLD_LIBRARY_PATH}:~/naoqi_sdk/naoqi_cpp/doc/dev/cpp/examples/core/sayhelloworld/build-naoqi_main_toolchain/sdk/lib
export DYLD_LIBRARY_PATH=${DYLD_LIBRARY_PATH}:sayhelloworld/build-naoqi_main_toolchain/sdk/lib

#TRY EXAMPLE
cd ./core/sayhelloworld
qibuild configure
qibuild make
