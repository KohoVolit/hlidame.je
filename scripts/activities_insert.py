# insert activities into pgsql using api

import json
import slugify
import requests
import settings
from hashlib import md5

headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
# get groups:
url0 = settings.url + "groups/"
r = requests.get(url0,headers=headers)
    # reorder for easier access
groups = {}
for g in r.json()['record']:
    groups[g['name']] = g


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

url = settings.url + "activities/"
auth = (settings.auth[0], settings.auth[1])

i = 0
for k in data:
    print(i,k)
    for a in data[k]:
        # see this bug: https://github.com/dreamfactorysoftware/dsp-core/issues/103
        
        where = "activity_code='" + a + "' AND " + "person_id='" + k + "'"
        params = {'filter':where}
        r = requests.get(url,headers=headers,params=params)
        dbdata = []
        dbdetail = []
        if r.status_code == 200:
            for row in r.json()['record']:
                dbdata.append(row['id'])
                dbdetail.append(json.loads(row['detail']))
            print(a,'dbdata:',len(dbdata))
        else:
            print(r.status_code,k,a)
        act = data[k][a]
        items = []
        for it in act:
            item = {
                "activity_code": a,
                "activity_title": it['title'],
                "date": d2d(it['date']),
                "person_id": k,
                "person_group_code": groups[(meps[k]['political_group'])]['code'],
                "person_party_code": slugify.slugify(meps[k]['party']),
                "person_country_code": meps[k]['country_code'],
                "detail": json.dumps(it)
            }
            try:
                dbid = dbdata[dbdetail.index(it)]
#                url1 = url + str(dbid)
#                print(item['date'],item['activity_title'])
#                requests.put(url1,data=json.dumps(item),auth=auth,headers=headers)
            except:
                items.append(item)
#        if len(items)>0 or len(dbdata)>0:
#            raise(Exception)
        try:
            insert = json.dumps(items)
            requests.post(url,data=insert,auth=auth,headers=headers)
            print('items:',len(items))
        except:
            print(k,a)
    i += 1
            


