import os

def include(filename):
    if os.path.exists(filename): 
        exec(open(filename).read())

include('groups.py')
include('meps.py')
include('meps_insert.py')
include('activities.py')
include('activities_insert.py')
