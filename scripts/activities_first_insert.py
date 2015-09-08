# insert activities into pgsql using api

import json
import slugify
import requests

files = ["meps_outs","meps_ins","meps_current"]
ms = []
for f in files:
    with open(f + ".json") as fin:
        ms = ms + json.load(fin)

meps = {}
for m in ms:
    meps[m['id']] = m

with open("activities.json") as fin:
    data = json.load(fin)

def d2d(date):
    d = date.split('-')
    return d[2] + '-' + d[1] + '-' + d[0]

url = "http://api.hlidame.je/rest/hlidame/activities/"
headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
auth = (settings.auth[0], settings.auth[1])

i = 0
for k in data:
    print(i,k)
    for a in data[k]:
        act = data[k][a]
        items = []
        for it in act:
            item = {
                "activity_code": a,
                "activity_title": it['title'],
                "date": d2d(it['date']),
                "person_id": k,
                "person_group_code": slugify.slugify(meps[k]['political_group']),
                "person_party_code": slugify.slugify(meps[k]['party']),
                "person_country_code": meps[k]['country_code'],
                "detail": json.dumps(it)
            }
            items.append(item)
        try:
            insert = json.dumps(items)
            requests.post(url,data=insert,auth=auth,headers=headers)
        except:
            print(k,a)
    i += 1
            


