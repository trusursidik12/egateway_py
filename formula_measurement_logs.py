import subprocess
import time

counter = 0

while True:
    counter = counter + 1
    subprocess.Popen("php gui\spark command:formula_measurement_logs", shell=False)
    if(counter >= 5):
        subprocess.Popen("php gui\spark command:sentdata", shell=False)
        counter = 0
    time.sleep(6)
