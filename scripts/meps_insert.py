# insert and update meps

import json
import slugify
import requests
import settings

with open("meps.json") as f:
    meps = json.load(f)

headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
# get groups:
url0 = settings.url + "groups/"
r = requests.get(url0,headers=headers)
    # reorder for easier access
groups = {}
for g in r.json()['record']:
    groups[g['name']] = g

# people
url = settings.url + "people/"
auth = (settings.auth[0], settings.auth[1])

for k in meps:
    mep = meps[k]
    data = {
            "group_code":groups[(mep['political_group'])]['code'],
            "party_code":slugify.slugify(mep['party']).lower(),
            "country_code":mep['country_code'],
            "weight":mep['weight'],
            "name": mep['name']
        }
    r = requests.get(url + mep['id'],headers=headers)
    print(mep['id'])
    if r.status_code == 200:
        p = requests.put(url + mep['id'],headers=headers,auth=auth,data=json.dumps(data))
    else:
        if r.status_code == 404:
            data['id'] = mep['id']
            q = requests.post(url,headers=headers,auth=auth,data=json.dumps(data))
        else:
            print(r.text)
            print(mep['id'])
    
    


