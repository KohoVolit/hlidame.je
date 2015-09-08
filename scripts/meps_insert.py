# insert and update meps

import json
import slugify
import requests
import settings

with open("meps.json") as f:
    meps = json.load(f)

url = "http://api.hlidame.je/rest/hlidame/people/"
headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
auth = (settings.auth[0], settings.auth[1])

for k in meps:
    mep = meps[k]
    data = {
            "group_code":slugify.slugify(mep['political_group']),
            "party_code":slugify.slugify(mep['party']),
            "country_code":mep['country_code'],
            "weight":mep['weight'],
            "name": mep['name']
        }
    r = requests.get(url + mep['id'],headers=headers)
    if r.status_code == 200:
        p = requests.put(url + mep['id'],headers=headers,auth=auth,data=json.dumps(data))
    else:
        if r.status_code == 404:
            data['id'] = mep['id']
            q = requests.post(url,headers=headers,auth=auth,data=json.dumps(data))
        else:
            print(r.text)
            print(mep['id'])
    
    


