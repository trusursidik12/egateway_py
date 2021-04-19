from mysql.connector.constants import ClientFlag
from PyQt5 import QtWebEngineWidgets, QtWidgets, QtCore
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
    subprocess.Popen("python labjack_reader.py " + str(row[0]), shell=True)

time.sleep(5)

class WebEnginePage(QtWebEngineWidgets.QWebEnginePage):
    def __init__(self, *args, **kwargs):
        QtWebEngineWidgets.QWebEnginePage.__init__(self, *args, **kwargs)
        self.profile().downloadRequested.connect(self.on_downloadRequested)

    @QtCore.pyqtSlot(QtWebEngineWidgets.QWebEngineDownloadItem)
    def on_downloadRequested(self, download):
        old_path = download.path()
        suffix = QtCore.QFileInfo(old_path).suffix()
        path, _ = QtWidgets.QFileDialog.getSaveFileName(self.view(), "Save File", old_path, "*."+suffix)
        if path:
            download.setPath(path)
            download.accept()
            
if __name__ == '__main__':
    import sys
    app = QtWidgets.QApplication(sys.argv)
    view = QtWebEngineWidgets.QWebEngineView()
    page = WebEnginePage(view)
    view.setPage(page)
    view.load(QtCore.QUrl("http://localhost:8080/"))
    view.showFullScreen()
    # view.show()
    sys.exit(app.exec_())

