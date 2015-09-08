# downloads all activities

import requests
import json


files = ["meps_outs","meps_ins","meps_current"]
ms = []
for f in files:
    with open(f + ".json") as fin:
        ms = ms + json.load(fin)

meps = {}
for m in ms:
    meps[m['id']] = m

activities = ['REPORT', 'REPORT-SHADOW', 'COMPARL', 'COMPARL-SHADOW', 'QP', 'WDECL', 'MOTION', 'CRE']

data = {}
i = 0
problems = []
for k in meps:
    data[k] = {}
    print(i,k)
    for a in activities:
        data[k][a] = []
        next = True
        index = 0
        while next:
            url = "http://www.europarl.europa.eu/meps/en/" + k + "/see_more.html?leg=8&index=" + str(index) + "&type=" + a
            try:
                r = requests.get(url)
            except:
                r.status_code = "Max retries exceeded ... problem"
                problems.append({'mep_id':k,'activity_code':a,'url':url})
            if r.status_code == 200:
                page = r.json()
                for d in page['documentList']:
                    data[k][a].append(d)
            else:
                print ("download with code " + str(r.status_code) + " " + url)
            if page['nextIndex'] > 0:
                index = page['nextIndex']
            else:
                next = False
    i += 1

with open("activities.json","w") as fout:
    json.dump(data,fout) 
