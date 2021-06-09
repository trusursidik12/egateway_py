from mysql.connector.constants import ClientFlag
from PyQt5 import QtWebEngineWidgets, QtWidgets, QtCore
import sys
import mysql.connector
import subprocess
import time

try:
    mydb = mysql.connector.connect(host="localhost",user="root",passwd="root",database="egateway")
    mycursor = mydb.cursor()
    print("[V] GUI DB CONNECTED")
except Exception as e:
    print("[X] GUI DB Not Connected " + e)
    sys.exit()

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
    # sys.exit(app.exec_())
    app.exec_()
    mycursor.execute("TRUNCATE system_checks")
    time.sleep(2)
    subprocess.Popen("taskkill /IM \"php.exe\" /F", shell=False)
    time.sleep(2)
    subprocess.Popen("taskkill /IM \"python.exe\" /F", shell=False)