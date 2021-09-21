from mysql.connector.constants import ClientFlag
import sys
import subprocess
import mysql.connector
import time

try:
    mydb = mysql.connector.connect(host="localhost", user="root", passwd="root", database="egateway")
    mycursor = mydb.cursor()
    print("[V] DB CONNECTED")
except Exception as e:
    print("[X]  DB Not Connected " + e)
    sys.exit()

mycursor.execute("SELECT main_path,mysql_path FROM configurations WHERE id='1'")
rec = mycursor.fetchall()

print("Restore database " + sys.argv[1])

subprocess.Popen(str(rec[0][1]) + "mysql -u root -proot egateway < " + str(rec[0][0]) + "gui/public/dist/upload/" + sys.argv[1], shell=True)

time.sleep(5)