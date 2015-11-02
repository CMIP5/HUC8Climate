#############################################################################
# Python Script
# Started: Oct 30 2015
# Edited:  Oct 30 2015			
# Created by: Stephen Duncan
# Purpose:			
#	This script will open files that contain the Climate data downloaded
#	from the B.o.R. portal that will sort through the data, assign the
#	16 other values to each DataValue and create the table for that
#	particular method.						
#############################################################################
##################
# Import Modules #
##################
import os
import csv
import datetime
####################
# Global Variables #
####################
# *.csv folders and file variables
RawContentFolder = "I:\\New Climate Data\\Raw Data\\"
ODMFinalFolder = "I:\\New Climate Data\\Seperated Files\\"
FoldersList = ['FutureTwo','HistoricalOne','HistoricalTwo'] #'FutureFive','FutureFour','FutureOne','FutureSix','FutureThree',
Columns = 2107 #So actually there are 2106 HUC8 Codes
MyLocalTime = ''
MyDataValue = 1.1
############
# The Code #
############
# First, figure out the list of files in the Folderlist
for Folder in FoldersList:
    CSVlist = os.listdir(RawContentFolder + Folder) #This is the file list
    # Second, loop through the files to extract data
    for RawData in CSVlist:
        # Open the csv file(s)
        openRawData1 = open(RawContentFolder + Folder + "\\" + RawData,'r')
        # Read the csv files
        readingData1 = csv.reader(openRawData1)
        # Determine csvMaxRow. This changes from file to file.
        csvMaxRow = len(list(readingData1))
        openRawData1.close()
        # Reopen File to read and parse data
        openRawData = open(RawContentFolder + Folder + "\\" + RawData,'r')
        readingData = csv.reader(openRawData)
        #Extract Plain Method Name
        methodLine = readingData.next()
        myMethodString = methodLine[0]
        myMethodString = myMethodString.replace("# ","")
        myMethodString = myMethodString.replace(" ","")
        try: # larger try
            # Make the HUC8 Code list
            HUC_code = readingData.next()
            # Skip the Units/Variable Row
            UnitsVariable = readingData.next()
            # Now making an array of list, so that we don't have to open and close the file a bunch of times.
            # Hopefully, we can then loop through the lists and create CSV files that way.
            DataList = []
            for row in range(3,csvMaxRow):
                newrow = readingData.next()
                DataList.append(newrow)
            # Now that we have the array of values for the file, we can loop through each column and figure
            # out each HUC8 Code and filename
            # Strategy is to identify each column of the old sheet, then loop through the DataList list to
            # Create Each individual file.
            for myColumn in range(1,Columns):
                # Identify HUC code
                HUCname = HUC_code[myColumn]
                # Name of File
                FileName = ODMFinalFolder+ Folder + "\\" + HUCname + "-" + myMethodString + ".csv"
                # Create unique file for HUC and Method
                openFileData = open(FileName,'wb')
                writingFileData = csv.writer(openFileData)
                for MonthRow in DataList:
                    try: # smaller try
                        DataValueList = [MonthRow[0],MonthRow[myColumn]]
                        writingFileData.writerow(DataValueList)
                    except: # smaller except
                        print "error with: " + Folder + "\\" + myMethodString + ".csv"
                        print "error with column"
                    # End of Try/Except for DataValueList
                # After we are done with each column in the dataset, we close and create a new Huc and Method file
                openFileData.close()
            # Close the Raw file after writing all other files
            openRawData.close()
        except: # larger except
            print "error with: " + Folder + "\\" + myMethodString + ".csv"
            print "problem with dataset"
        # End of Try/Except for dataset
    # End of "for RawData in CSVlist:" loop
# End of "for Folder in FoldersList:" loop
# End of Code
