import re
import sys
if len(sys.argv) != 2:
    print "Usage: " + sys.argv[0] + "<filename>"
    quit()

fileName =  sys.argv[1]

try:
    fileIn = open(fileName,"r")
except:
    print "Cannot open " + fileName
    quit()

match = re.search("(.+)(\.\w+)$$", fileName)
fileNameOut = match.group(1) + ".out"

fileOut = open(fileNameOut,"w")
for line in fileIn:
    match = re.match("Section: (\d+) \d+ / (\d+) (.+)", line)
    out = "[  ] {} - {} ({})\n".format(match.group(1), match.group(3), match.group(2))
    fileOut.write(out)

print "Result written to: " + fileNameOut
fileIn.close()
fileOut.close()