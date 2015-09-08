# insert and update groups

import json
import slugify
import requests
import csv
import settings

g2g = {
    'Europe of Freedom and Direct Democracy Group':"group_icon_efd",
    'Group of the Alliance of Liberals and Democrats for Europe':'group_icon_aldeadle',
    'Non-attached Members':'group_icon_ni',
    'European Conservatives and Reformists Group':'group_icon_ecr',
    'Group of the Progressive Alliance of Socialists and Democrats in the European Parliament':'group_icon_sd',
    'Group of the Greens/European Free Alliance':'group_icon_greensefa',
    'Europe of Nations and Freedom Group':'group_icon_enf',
    'Confederal Group of the European United Left - Nordic Green Left':'group_icon_guengl',
    "Group of the European People's Party (Christian Democrats)":'group_icon_epp'
}

with open("meps.json") as f:
    meps = json.load(f)


headers = {'X-DreamFactory-Application-Name':'hlidame','Content-Type':'application/json'}
auth = (settings.auth[0], settings.auth[1])

# countries
url = settings.url + "countries/"
countries = {}
with open("member_states.csv") as fin:
    csvd = csv.DictReader(fin)
    for row in csvd:
        countries[row['name']] = row

for k in countries:
    c =countries[k]
    data = {
        'code': c['code'],
        'name': c['another_name:original_name'],
        'picture': "http://www.europarl.europa.eu/ep_framework/img/flag/flag_icon_" + c['code'] + ".gif",
        'name_en': c['name']
    }
    r = requests.get(url + c['code'],headers=headers)
    if r.status_code == 200:
        p = requests.put(url + c['code'],headers=headers,auth=auth,data=json.dumps(data))
    else:
        if r.status_code == 404:
            q = requests.post(url,headers=headers,auth=auth,data=json.dumps(data))
        else:
            print(r.text)
            print(c['code'])

# groups
url = settings.url + "groups/"
groups = {}
for k in meps:
    groups[meps[k]['political_group']] = meps[k]['political_group']

for k in groups:
    g = groups[k]
    data = {
        'code': slugify.slugify(g),
        'name': g,
        'picture': 'http://www.europarl.europa.eu/ep_framework/img/group/' + g2g[g] + ".gif"
    }
    r = requests.get(url + c['code'],headers=headers)
    if r.status_code == 200:
        p = requests.put(url + c['code'],headers=headers,auth=auth,data=json.dumps(data))
    else:
        if r.status_code == 404:
            q = requests.post(url,headers=headers,auth=auth,data=json.dumps(data))
        else:
            print(r.text)
            print(c['code'])

# parties
url = settings.url + "parties/"
groups = {}
for k in meps:
    groups[meps[k]['party']] = meps[k]['party']

for k in groups:
    g = groups[k]
    data = {
        'code': slugify.slugify(g),
        'name': g
    }
    r = requests.get(url + c['code'],headers=headers)
    if r.status_code == 200:
        p = requests.put(url + c['code'],headers=headers,auth=auth,data=json.dumps(data))
    else:
        if r.status_code == 404:
            q = requests.post(url,headers=headers,auth=auth,data=json.dumps(data))
        else:
            print(r.text)
            print(c['code'])
