import datetime
import os

import cv2
import face_recognition
import mysql.connector
import numpy as np

from form import *

mydb = mysql.connector.connect(host="localhost", user="root", password="root", database="project")
cur = mydb.cursor()

known_face_encodings = []
known_face_names = []
known_id = []


def load():
    app.setOverrideCursor(QtCore.Qt.CursorShape.WaitCursor)
    ui.pushButton_2.setStyleSheet("background-color:red;border-radius:15px;")
    global known_id, known_face_encodings, known_face_names
    for x in os.listdir("StudentImages"):
        temp_img = face_recognition.load_image_file("StudentImages\\" + x)
        temp_face_encoding = face_recognition.face_encodings(temp_img)[0]
        known_face_encodings.append(temp_face_encoding)
        cur.execute("select name from studentnames where stdid = " + str(x[0:len(x) - 4]))
        t = str(cur.fetchone()[0])
        known_id.append(x[0:len(x) - 4])
        known_face_names.append(t)
        print(x[0:len(x) - 4])

    ui.pushButton_2.setStyleSheet("background-color:green;border-radius:15px;")
    app.restoreOverrideCursor()


def fun():
    global known_id, known_face_encodings, known_face_names
    print(known_face_encodings,known_id,known_face_names)
    dt = datetime.datetime.now()
    video_capture = cv2.VideoCapture(1)

    print("done loading")
    face_locations = []
    face_encodings = []
    face_names = []
    process_this_frame = True

    trav = 0
    while trav <= 3:
        ret, frame = video_capture.read()
        if process_this_frame:
            small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
            print(frame)
            rgb_small_frame = small_frame[:, :, ::-1]
            face_locations = face_recognition.face_locations(rgb_small_frame)
            face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)
            face_names = []
            face_id = []
            for face_encoding in face_encodings:
                matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
                name = "Unknown"
                face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
                best_match_index = np.argmin(face_distances)
                if matches[best_match_index]:
                    name = known_face_names[best_match_index]
                    face_id.append(known_id[best_match_index])
                    trav = trav + 1
                face_names.append(name)

        process_this_frame = not process_this_frame
        for (top, right, bottom, left), name in zip(face_locations, face_names):
            top *= 4
            right *= 4
            bottom *= 4
            left *= 4
            cv2.rectangle(frame, (left, top), (right, bottom), (0, 0, 255), 2)
            cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (0, 0, 255), cv2.FILLED)
            font = cv2.FONT_HERSHEY_DUPLEX
            cv2.putText(frame, name, (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)
        cv2.imshow('Video', frame)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
    video_capture.release()
    cv2.destroyAllWindows()
    print(face_names[0], dt.strftime("%Y-%m-%d %H:%M:%S"))
    if (face_names[0] != "Unknown" and len(face_id) != 0):
        n = "insert into logindetails values(" + face_id[0] + ",\"" + face_names[0] + "\"," + "\"" + dt.strftime(
            '%Y-%m-%d %H:%M:%S') + "\");"
        cur.execute(str(n))
        mydb.commit()


app = QtWidgets.QApplication(sys.argv)
MainWindow = QtWidgets.QMainWindow()
ui = Ui_MainWindow()
ui.setupUi(MainWindow)
ui.pushButton_2.clicked.connect(load)
ui.pushButton.clicked.connect(fun)
MainWindow.show()

sys.exit(app.exec())