from __future__ import print_function
import sys
from labjack import ljm
from mysql.connector.constants import ClientFlag
import mysql.connector
import time
import datetime

AIN = [0.0,0.0,0.0,0.0]

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
        for x in [0,1,2,3]:
            AIN[x] = ljm.eReadName(labjack, "AIN" + str(x))
        
    except Exception as e: 
        for x in [0,1,2,3]:
            AIN[x] = 0
    
    for x in [0,1,2,3]:
        try:
            mycursor.execute("DELETE FROM labjack_value_histories WHERE xtimestamp < ('" + datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S") + "' - INTERVAL 2 HOUR)")
        
            mycursor.execute("SELECT id FROM labjack_values WHERE labjack_id = '"+ str(sys.argv[1]) +"' AND ain_id = '" + str(x) + "'")
            labjack_value_id = mycursor.fetchone()[0]
            
            mycursor.execute("INSERT INTO labjack_value_histories (labjack_value_id,data) VALUES ('" + str(labjack_value_id) + "','" + str(AIN[x]) + "')")
            mydb.commit()
            
            mycursor.execute("SELECT data FROM labjack_value_histories WHERE labjack_value_id = '" + str(labjack_value_id) + "' ORDER BY id DESC LIMIT 10")
            labjack_value_histories = mycursor.fetchall()
            total = 0.0
            average = 0.0
            count = 0
            for labjack_value_history in labjack_value_histories:
                total = total + labjack_value_history[0];
                count = count + 1
            average = (total + AIN[x]) / (count + 1)
            
            mycursor.execute("UPDATE labjack_values SET data = '" + str(average) + "' WHERE id = '" + str(labjack_value_id) + "'")
            mydb.commit()
        except Exception as e:
            mycursor.execute("INSERT INTO labjack_values (labjack_id,ain_id,data) VALUES ('" + str(sys.argv[1]) + "','" + str(x) + "','" + str(AIN[x]) + "')")
            mydb.commit()
            
    time.sleep(1) 