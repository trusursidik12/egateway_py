import subprocess
import time

subprocess.Popen("php gui\spark command:formula_measurement_logs", shell=True)
print("php gui\spark command:formula_measurement_logs")
time.sleep(2)
# subprocess.Popen("php gui\spark command:sentdata", shell=True)
# print("php gui\spark command:sentdata")
# time.sleep(2)
subprocess.Popen("php gui\spark command:measurement_averaging", shell=True)
print("php gui\spark command:measurement_averaging")
time.sleep(2)
subprocess.Popen("php gui\spark command:measurement_das_log", shell=True)
print("php gui\spark command:measurement_das_log")
time.sleep(2)

# counter = 0
# while True:
    # counter = counter + 1
    # subprocess.Popen("php gui\spark command:formula_measurement_logs", shell=False)
    # if(counter >= 60):
        # subprocess.Popen("php gui\spark command:sentdata", shell=False)
        # subprocess.Popen("php gui\spark command:measurement_averaging", shell=False)
        # subprocess.Popen("php gui\spark command:measurement_das_log", shell=False)
        # counter = 0
    # time.sleep(1)
