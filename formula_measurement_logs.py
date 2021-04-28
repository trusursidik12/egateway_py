import subprocess
import time

while True:
    subprocess.Popen("php gui\spark command:formula_measurement_logs", shell=False)
    subprocess.Popen("php gui\spark command:sentdata", shell=False)
    time.sleep(1)
