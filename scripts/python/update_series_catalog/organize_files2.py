__author__ = 'Jiri'

import os
import requests
import shutil
from findtools.find_files import (find_files, Match)


def move_files(base_dir):
    print base_dir
    i = 0
    files = os.listdir(base_dir)
    for f in files:
        i += 1
        rem = i % 100
        if rem == 0:
            print i

        oldname = base_dir + '\\' + f
        huc = f[:8]
        hucdir = "C:\huc8" + '\\' + huc
        newname = hucdir + '\\' + f
        if not os.path.exists(newname):
            shutil.copy(oldname, newname)
            #print oldname


#make the HUC directories
huc_dir = "C:\huc8"
url = 'http://worldwater.byu.edu/app/index.php/climate/services/api/GetSitesJSON'
r = requests.get(url)
sites = r.json()

for site in sites:
    huc = site['SiteCode']
    huc_pattern = Match(filetype='f', name=huc + '*')
    hucdir = os.path.join("C:\huc8", huc)
    print hucdir
    if not os.path.exists(hucdir):
        os.makedirs(hucdir)
        print hucdir

move_files("E:\New Climate Data\Seperated Files\FutureFive")
move_files("E:\New Climate Data\Seperated Files\FutureOne")
move_files("E:\New Climate Data\Seperated Files\FutureSix")
move_files("E:\New Climate Data\Seperated Files\FutureThree")
move_files("E:\New Climate Data\Seperated Files\FutureTwo")
move_files("E:\New Climate Data\Seperated Files\HistoricalOne")
move_files("E:\New Climate Data\Seperated Files\HistoricalTwo")

