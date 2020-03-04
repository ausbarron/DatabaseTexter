#!/usr/bin/python3

# Note: For the from variable. This number may change but will be hard coded for demonstration.

from twilio.rest import Client
import pymysql

account_sid = 'AC9a765b751eb35584336004c8fc5382b8'
auth_token = 'f700b386f779cbe2a39b505987939226'
client = Client(account_sid, auth_token)

db = pymysql.connect("localhost", "testuser", "test123", "persons")

cursor = db.cursor()

sql = "SELECT * FROM testcase \
    WHERE ZIP_CODE = '%s'" % ('60401')

try:
    cursor.execute(sql)

    results = cursor.fetchall()
    for row in results:
        idenNum = row[0]
        fullName = row[1]
        phoneNum = row[2]
        zip_code = row[3]

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


