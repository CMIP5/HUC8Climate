__author__ = 'Jiri'

import os
import requests
import shutil
from findtools.find_files import (find_files, Match)




base_dir = "C:\climate"

#get list of HUC's
dir1 = 'FutureFive'
dir2 = 'FutureFour'
dir3 = 'FutureOne'
dir4 = 'FutureSix'
dir5 = 'FutureThree'
dir6 = 'FutureTwo'
dir7 = 'HistoricalOne'
dir8 = 'HistoricalTwo' \

url = 'http://worldwater.byu.edu/app/index.php/climate/services/api/GetSitesJSON'
r = requests.get(url)
sites = r.json()

for site in sites:
    huc = site['SiteCode']
    huc_pattern = Match(filetype='f', name=huc + '*')
    hucdir = os.path.join("C:\huc", huc)
    print hucdir
    if not os.path.exists(hucdir):
        os.makedirs(hucdir)

    huc_files = find_files(path=base_dir, match=huc_pattern)
    for f in huc_files:
        newbasename = os.path.basename(f)
        newhucname = os.path.join(hucdir, newbasename)
        shutil.move(f, newhucname)
