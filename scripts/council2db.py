# insert council data into pgsql using api

import csv
import requests
import json
import settings

headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
url = settings.url + "council/"
auth = (settings.auth[0], settings.auth[1])

ccs = ['cz','pl','hu','sk']

for cc in ccs:
    i = 1
    items = []
    with open(cc + ".csv") as f:
        csvr = csv.reader(f)
        for r in csvr:
            item = {
                "number": int(r[0]),
                "configuration": r[1],
                "start_date": r[2],
                "end_date": r[3],
                "person": r[4],
                "ministry": r[5],
                "office": r[6],
                "party": r[7],
                "minister_present": int(r[8]),
                "prime_minister": r[9],
                "country_code": cc
            }
            items.append(item)
            i += 1
#            print(i, r[0])
            try:
                insert = json.dumps(item)
                req = requests.post(url,data=insert,auth=auth,headers=headers)
                if req.status_code != 200:
                    print(i, r[0], r[4])
            except:
                print(cc, i)

