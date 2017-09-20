#!bin/sh
echo -e "please setup the target_path variable in the script. the path has to be the absolute path"
target_path=/Users/marcelochsendorf/naoqi


cd ~
wget pynaoqi-python2.7-2.1.4.13-mac64.tar
tar -xzf pynaoqi-python2.7-2.1.4.13-mac64.tar -C $target_path
export PYTHONPATH=${PYTHONPATH}:$target_path
export DYLD_LIBRARY_PATH=${DYLD_LIBRARY_PATH}:$target_path


all_libs="$target_path/*.dylib $target_path/*.so"
boost_libs=$target_path/libboost*.dylib
for lib in $all_libs; do
  echo "Treating $lib"
  for boost_lib in $boost_libs; do
    echo "Changing boost lib $boost_lib"
    install_name_tool -change $(basename $boost_lib) $boost_lib $lib
  done
done

echo -e "all finished please check install with import qi and import naoqi"
