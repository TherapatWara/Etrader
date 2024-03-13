import pandas as pd
import numpy as np
import pickle
import os.path
import zmq
from sklearn.preprocessing import MinMaxScaler
from tensorflow.keras.models import load_model
import csv
from io import StringIO


port = "5555"

# สร้าง context
context = zmq.Context()

# สร้าง socket เป็น REP (reply)
socket = context.socket(zmq.REP)
socket.bind("tcp://*:%s" % port)

print("Server is ready")

# รับข้อมูลและส่งข้อมูลกลับ
while True:
    # รับข้อมูลจาก client
    message = socket.recv_string()
    print("Received request: ", message)





    model = load_model("./model_v1_h4_3input.h5")
    with open('model.pkl', 'wb') as model_file:
        pickle.dump(model, model_file)
    with open('model.pkl', 'rb') as model_file:
        loaded_model = pickle.load(model_file)
    print("CSV file created successfully.")

    for row in range(3):
        data_rows = message
        row_str = str(data_rows)
        columns = row_str.split(',')
    # Transpose the data
    transposed_values = [columns]
    
    #print("rrr : " , transposed_values)
    with open("data.csv", "w", newline='') as csvfile:
        writer = csv.writer(csvfile)
        writer.writerows(zip(*transposed_values))

    input_data = pd.read_csv("data.csv")
    input_data = np.array(input_data)
    print(input_data)
    input_data = np.reshape(input_data, (1, 3))
    print(input_data)
    result = loaded_model.predict(input_data)
    print(result)
    result1 = str(result)
    result2 = result1.strip('[]')
    print(result2)
    socket.send_string(result2)






calculatePrice(None)


