from mysql.connector.constants import ClientFlag
from datetime import datetime
import subprocess
import mysql.connector
import time
import pathlib

try:
    mydb = mysql.connector.connect(host="localhost", user="root", passwd="root", database="egateway")
    mycursor = mydb.cursor()
    print("[V] DB CONNECTED")
except Exception as e:
    print("[X]  DB Not Connected " + e)
    sys.exit()

mycursor.execute("SELECT main_path,mysql_path FROM configurations WHERE id='1'")
rec = mycursor.fetchall()

now = datetime.now()
dt_string = now.strftime("%Y%m%d_%H%M%S")

print("Backup database backup_"+dt_string+".sql")

subprocess.Popen(str(rec[0][1]) + "mysqldump -u root -proot egateway > " + str(rec[0][0]) + "gui/public/dist/upload/backups/egateway_backup_" + dt_string + ".sql", shell=True)

time.sleep(5)