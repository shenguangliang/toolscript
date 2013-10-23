#!/bin/sh

echo "count..."

PROVISIONING_PROFILE=`cat RenrenOfficial-iOS-Concept.xcodeproj/project.pbxproj | grep "PROVISIONING_PROFILE = \"\";" | wc -l`
if [ $PROVISIONING_PROFILE == 6 ]; then
  echo "PROVISIONING_PROFILE'S COUNT : "$PROVISIONING_PROFILE
else
  echo "PROVISIONING_PROFILE'S COUNT Failure"
  exit -1;
fi

PROVISIONING_PROFILE_SDK=`cat RenrenOfficial-iOS-Concept.xcodeproj/project.pbxproj | grep "PROVISIONING_PROFILE\[sdk=iphoneos\*\]\" = \"\";" | wc -l`
if [ $PROVISIONING_PROFILE_SDK == 6 ]; then
  echo "PROVISIONING_PROFILE_SDK'S COUNT : "$PROVISIONING_PROFILE_SDK
else
  echo "PROVISIONING_PROFILE_SDK'S COUNT Failure"
  exit -1;
fi

CODE_SIGN_IDENTITY=`cat  RenrenOfficial-iOS-Concept.xcodeproj/project.pbxproj | grep "CODE_SIGN_IDENTITY = \"iPhone Distribution: Beijing Qianxiang Wangjing Tech Dev. Limited\";" | wc -l`
if [ $CODE_SIGN_IDENTITY == 1 ]; then
  echo "CODE_SIGN_IDENTITY'S COUNT : "$CODE_SIGN_IDENTITY
else
  echo "CODE_SIGN_IDENTITY'S COUNT Failure"
  exit -1;
fi

CODE_SIGN_IDENTITY_SDK=`cat  RenrenOfficial-iOS-Concept.xcodeproj/project.pbxproj | grep "\"CODE_SIGN_IDENTITY\[sdk=iphoneos\*\]\" = \"iPhone Distribution: Beijing Qianxiang Wangjing Tech Dev. Limited\";" |wc -l`

if [ $CODE_SIGN_IDENTITY_SDK == 1 ]; then
  echo "CODE_SIGN_IDENTITY_SDK'S COUNT : "$CODE_SIGN_IDENTITY_SDK
else
  echo "CODE_SIGN_IDENTITY_SDK'S COUNT Failure"
  exit -1;
fi



