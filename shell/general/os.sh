CURRENT_OS=${DEFAULT_CURRENT_OS}
CURRENT_OS_FLAVOR=${DEFAULT_CURRENT_OS_FLAVOR}
CURRENT_OS_FLAVOR_VERSION=${DEFAULT_CURRENT_OS_FLAVOR_VERSION}
CURRENT_OS_FLAVOR_BIT=${DEFAULT_CURRENT_OS_FLAVOR_BIT}

##
#
##
get_current_os () {
  set_current_os
  echo "${CURRENT_OS}"
}

##
#
##
get_current_os_flavor () {
  set_current_os
  echo "${CURRENT_OS_FLAVOR}"
}

##
#
##
get_current_os_flavor_version () {
  set_current_os
  echo "${CURRENT_OS_FLAVOR_VERSION}"
}

##
#
##
get_current_os_flavor_bit () {
  set_current_os
  echo "${CURRENT_OS_FLAVOR_BIT}"
}

##
#
##
set_current_os () {
  if [ "$(isMacOS)" = 0 ]; then

      # Mac OS X platform
      #########################################################
      CURRENT_OS="mac"
      CURRENT_OS_FLAVOR=""
      CURRENT_OS_FLAVOR_VERSION=""
      CURRENT_OS_FLAVOR_BIT="64"

  elif [ "$(isLinuxOS)" = 11 ]; then
      # GNU/Linux platform
      #########################################################
      CURRENT_OS="linux"
      CURRENT_OS_FLAVOR="ubuntu"
      CURRENT_OS_FLAVOR_VERSION="22.04"
      CURRENT_OS_FLAVOR_BIT="64"

  elif [ "$(isWinNT32OS)" = 0 ]; then

      # Do something under 32 bits Windows NT platform
      #########################################################
      CURRENT_OS="windows"
      CURRENT_OS_FLAVOR="NT"
      CURRENT_OS_FLAVOR_VERSION=""
      CURRENT_OS_FLAVOR_BIT="32"

  elif [ "$(isWinNT64OS)" = 0 ]; then

      # Do something under 64 bits Windows NT platform
      #########################################################
      CURRENT_OS="windows"
      CURRENT_OS_FLAVOR="NT"
      CURRENT_OS_FLAVOR_VERSION=""
      CURRENT_OS_FLAVOR_BIT="64"

  fi
}

isMacOS() {
    if [ "$(uname)" = "Darwin" ];
    then
      echo 0
    else
      echo 1
    fi
}

isLinuxOS() {
    is_linux_system=$(uname -s | cut -c 1-5)
    if [ "${is_linux_system}" = "Linux" ];
    then
      echo 0
    else
      echo 1
    fi
}

isWinNT32OS() {
    is_win32_system=$(uname -s | cut -c 1-10)
    if [ "${is_win32_system}" = "MINGW32_NT" ];
    then
      echo 0
    else
      echo 1
    fi
}

isWinNT64OS() {
    is_win64_system=$(uname -s | cut -c 1-10)
    if [ "${is_win64_system}" = "MINGW64_NT" ];
    then
      echo 0
    else
      echo 1
    fi
}