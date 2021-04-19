from __future__ import print_function
import sys
from labjack import ljm
from mysql.connector.constants import ClientFlag
import mysql.connector
import time

AIN = [0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0]

try:
    mydb = mysql.connector.connect(host="localhost",user="root",passwd="root",database="egateway")
    mycursor = mydb.cursor()
    mycursor.execute("SELECT labjack_code FROM labjacks WHERE id = '"+ sys.argv[1] +"'")
    labjack_code = mycursor.fetchone()[0]
    labjack = ljm.openS("ANY", "ANY", labjack_code)
    print("[V] Labjack " + labjack_code + " CONNECTED")
except Exception as e:
    print("[X]  Labjack " + e)

while True:
    try:
        labjack = ljm.openS("ANY", "ANY", labjack_code)
        for x in [0,1,2,3,4,5,6,7]:
            AIN[x] = ljm.eReadName(labjack, "AIN" + str(x))
        
    except Exception as e: 
        for x in [0,1,2,3,4,5,6,7]:
            AIN[x] = 0
    
    for x in [0,1,2,3,4,5,6,7]:
        try:
            mycursor.execute("SELECT id FROM labjack_values WHERE labjack_id = '"+ str(sys.argv[1]) +"' AND ain_id = '" + str(x) + "'")
            labjack_value_id = mycursor.fetchone()[0]
            mycursor.execute("UPDATE labjack_values SET data = '" + str(AIN[x]) + "' WHERE id = '" + str(labjack_value_id) + "'")
            mydb.commit()
        except Exception as e:
            mycursor.execute("INSERT INTO labjack_values (labjack_id,ain_id,data) VALUES ('" + str(sys.argv[1]) + "','" + str(x) + "','" + str(AIN[x]) + "')")
            mydb.commit()
            
    time.sleep(1) 