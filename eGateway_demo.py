from mysql.connector.constants import ClientFlag
import subprocess
import sys
import mysql.connector
import time

try:
    mydb = mysql.connector.connect(
        host="localhost", user="root", passwd="root", database="egateway")
    mycursor = mydb.cursor()
    print("[V] DB CONNECTED")
except Exception as e:
    print("[X]  DB Not Connected " + e)
    sys.exit()

mycursor.execute("TRUNCATE labjack_values")
mycursor.execute("TRUNCATE labjack_value_histories")

subprocess.Popen("php gui\spark serve", shell=True)
time.sleep(1)

mycursor.execute("SELECT id FROM labjacks ORDER BY id")
rec = mycursor.fetchall()
for row in rec:
    subprocess.Popen("python labjack_demo.py " + str(row[0]), shell=True)
    time.sleep(1)


subprocess.Popen("php gui\spark command:formula_measurement_logs", shell=True)
print("php gui\spark command:formula_measurement_logs")
time.sleep(1)
subprocess.Popen("php gui\spark command:sentdata", shell=True)
print("php gui\spark command:sentdata")
time.sleep(1)
subprocess.Popen("php gui\spark command:sispeksend", shell=True)
print("php gui\spark command:sispeksend")
time.sleep(1)
subprocess.Popen("php gui\spark command:measurement_averaging", shell=True)
print("php gui\spark command:measurement_averaging")
time.sleep(1)
subprocess.Popen("php gui\spark command:measurement_das_log", shell=True)
print("php gui\spark command:measurement_das_log")


time.sleep(1)
subprocess.Popen("python gui_start.py", shell=True)
