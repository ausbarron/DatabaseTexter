#!/usr/bin/python3

# Note: For the from variable. This number may change but will be hard coded for demonstration.

from twilio.rest import Client ##imports API for twilio
from myconfig import *
import pymysql ##imports module for mysql database manipulation

account_sid = account_id ##account id for twilio
auth_token = token_id ##account token for twilio
client = Client(account_sid, auth_token) ##client object declaration

db = pymysql.connect("localhost", "testuser", "test123", "persons") ##database connection established with sample user

cursor = db.cursor() ##cursor object declaration

sql = "SELECT * FROM testcase \
    WHERE ZIP_CODE = '%s'" % ('60401') ##sql query for finding a desired zipcode to text to
##try will attempt to execute the sql query, except will print an error if it cannot.
try:
    cursor.execute(sql) ##executes the sql query 'sql'

    results = cursor.fetchall() ##fetches all results from sql query

    #for in that parses each entry from results and assigns them to variables
    for row in results:
        idenNum = row[0]
        fullName = row[1]
        phoneNum = row[2]
        zip_code = row[3]

        ##client will create a new text message containing a predesignated message
        ##and send that message to the given phonenumber from the twilio bot.
        message = client.messages \
                  .create(
                      body='This is A Test Please Disregard <3',
                      from_='+12058393105',
                      to=phoneNum
                      )
        print(message.sid)
        
except:
    print("error: unable to fetch data")

db.close()


