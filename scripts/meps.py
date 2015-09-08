# download all current mps from EP -> json
# and all ins and outs

import json
import requests
#import xml.etree.ElementTree as ET
import csv
import xmltodict

countries = {}
with open("member_states.csv") as fin:
    csvd = csv.DictReader(fin)
    for row in csvd:
        countries[row['name']] = row

attrs = {
    'fullName': 'name',
    'country': 'country',
    'politicalGroup': 'political_group',
    'id': 'id',
    'nationalPoliticalGroup': 'party'
}

url = "http://www.europarl.europa.eu/meps/en/xml.html?query=full&filter=all"
r = requests.get(url)

data = []

obj = xmltodict.parse(r.text)
for mep in obj['meps']['mep']:
    it = {}
    for k in attrs:
        it[attrs[k]] = mep[k]
    it['weight'] = 1
    it['country_code'] = countries[it['country']]['code']
    data.append(it)

ins = []
url = "http://www.europarl.europa.eu/meps/en/xml.html?query=inout&type=in"
r = requests.get(url)
obj = xmltodict.parse(r.text)
for mep in obj['meps']['mep']:
    it = {}
    for k in attrs:
        it[attrs[k]] = mep[k]
    it['weight'] = 0.5
    it['country_code'] = countries[it['country']]['code']
    ins.append(it)

outs = []
url = "http://www.europarl.europa.eu/meps/en/xml.html?query=inout&type=out"
r = requests.get(url)
obj = xmltodict.parse(r.text)
for mep in obj['meps']['mep']:
    it = {}
    for k in attrs:
        it[attrs[k]] = mep[k]
    it['weight'] = 0.5
    it['country_code'] = countries[it['country']]['code']
    outs.append(it)

with open("meps_current.json","w") as fout:
    json.dump(data,fout)          
with open("meps_ins.json","w") as fout:
    json.dump(ins,fout) 
with open("meps_outs.json","w") as fout:
    json.dump(outs,fout)
 
 
    
files = ["meps_current","meps_outs","meps_ins"]
ms = []
for f in files:
    with open(f + ".json") as fin:
        ms = ms + json.load(fin)
meps = {}
for m in ms:
    meps[m['id']] = m

with open("meps.json","w") as fout:
    json.dump(meps,fout)
