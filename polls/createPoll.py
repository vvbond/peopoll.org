#!/usr/bin/env python2.7

# -*- coding: utf-8 -*-
"""
Created on Tue Jul  1 00:45:03 2014

@author: vbond
"""
import json
import MySQLdb as mdb
import sys

# Check the number of arguments:
try:
    script, hostname, pollFile = sys.argv
except:
    print "Specify the script json file."
    sys.exit(1)

user = 'vbond'
pswd = 'trempel007'
dbname = 'golosovalka'
# hostname = 'localhost'
# hostname = '134.34.70.162'

#pollFile = 'poll1.json';
# pollFile = 'euroTrading.json'


# Main
# Load poll data:
polljson = open(pollFile)
polldata = json.load(polljson)

# Connect to the data base:
print "Connecting to the database"
try:
    dbcon = mdb.connect(hostname, user, pswd, dbname)
except:
    print "Connection failed."
    sys.exit(2)

print "Insert poll data to the database."
with dbcon:
    cur = dbcon.cursor(mdb.cursors.DictCursor)
    cur.execute("""INSERT INTO polls(name, active, dtexpire)
                   VALUES(%s,%s,%s)""",
                (polldata['name'], polldata['active'], polldata['dtexpire']))
# Find the last poll id:
    cur.execute('select last_insert_id()')
    row = cur.fetchone()
    pid = row['last_insert_id()']
    # Insert questions and answers:
    for (ix, q) in enumerate(polldata['questions']):
        cur.execute("""INSERT INTO questions(pid,qnum,qtxt,qtype)
                       VALUES(%s,%s,%s,%s)""",
                    (pid, ix+1, q['qtxt'], q['qtype']))
        for (aix, a) in enumerate(q['answers']):
            cur.execute("""INSERT INTO answers(pid,qnum,anum,atxt,votes)
                           VALUES(%s,%s,%s,%s,0)""",
                        (pid, ix+1, aix+1, a))
print "Done!"
