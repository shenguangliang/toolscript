#! /usr/bin/env python
import sys
import os
import getopt

def getContent():
  filename = "RRSpring_InHouse.plist" 
  print "\nsource filename:[" , filename,"]"
  f = open(filename,'r')
  s = f.read()
  f.close()
  return s

def replaceContent():
  s = getContent()
  
  appurl = "RenRen APP URL"
  version = "0.0"
  largeImage = "RenRen Large Image"
  smallImage = "Input RenRen Small Image"
  subTitle = "Input RenRen SubTitle"
  title = "Input RenRen Title"
  targetPlist = "app.plist"

  try:
    opts,args = getopt.getopt(sys.argv[1:],"u:v:d:")
    if len(opts) < 3:
        print("the mount of params must great equal than 3")
        sys.exit(1)
    for op,value in opts:
        if op == "-u":
            appurl = value
        elif op == "-v":
            version = value
        elif op == "-d":
            targetPlist = value
  except getopt.GetoptError:
    print("params are not defined well!")
    sys.exit(1)

  print "\n"
  print "Replace content:"
  print "RenRen APP URL ---> ",appurl
  print "RenRen APP Version ---> ",version
  print "RenRen Large Image ---> ",largeImage 
  print "RenRen Small Image ---> ", smallImage
  print "RenRen SubTitle ---> ", subTitle 
  print "RenRen Title ---> ", title
  print "RenRen TargetPlist", targetPlist

  s = s.replace("${RenRen_APP_URL}",appurl)
  s = s.replace("${RenRen_Version}",version)
  s = s.replace("${RenRen_Large_Image}",largeImage)
  s = s.replace("${RenRen_Small_Image}",smallImage)
  s = s.replace("${RenRen_SubTitle}",subTitle)
  s = s.replace("${RenRen_Title}",title)
  
  f = file(targetPlist,'w')
  f.write(s)
  f.close()
  print "\ntarget FileName: [TargetFile]" 


if __name__ == '__main__':
  replaceContent()  

