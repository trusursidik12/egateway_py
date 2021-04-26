from mysql.connector.constants import ClientFlag
import subprocess
import sys
import mysql.connector
import time

try:
    mydb = mysql.connector.connect(host="localhost",user="root",passwd="root",database="egateway")
    mycursor = mydb.cursor()
    print("[V] DB CONNECTED")
except Exception as e:
    print("[X]  DB Not Connected " + e)
    sys.exit()

subprocess.Popen("php gui\spark serve", shell=True)
time.sleep(1)

mycursor.execute("SELECT id FROM labjacks ORDER BY id")
rec = mycursor.fetchall()
for row in rec: 
    subprocess.Popen("python labjack_reader_avg.py " + str(row[0]), shell=True)
    time.sleep(2)

time.sleep(5)
subprocess.Popen("python formula_measurement_logs.py", shell=True)

time.sleep(2)
subprocess.Popen("python gui_start.py", shell=True)