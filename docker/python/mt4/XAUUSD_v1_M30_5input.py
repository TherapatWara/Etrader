import zmq
import mysql.connector
import csv
import numpy as np
import pandas as pd
from sklearn.preprocessing import MinMaxScaler
from tensorflow.keras.models import load_model
import pickle
# ฟังก์ชันสำหรับเขียนข้อมูลลงใน MySQL
def write_to_mysql(account_number, account_balance, account_equity):
    # เชื่อมต่อ MySQL
    connection = mysql.connector.connect(
        host="db",
        user="root",
        password="ttt",
        database="ai"
    )
    cursor = connection.cursor()

    # เขียนข้อมูลลงในฐานข้อมูล
    sql = "INSERT INTO profit (profit_id, portnumber, profit_date, equity, balance) VALUES (NULL, %s, NOW(), %s, %s)"
    val = (account_number, account_equity, account_balance)
    cursor.execute(sql, val)
    connection.commit()
    
    print("Data written to MySQL successfully.")


def write_to_history(price, account_number, ticket):
    # เชื่อมต่อ MySQL
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="bot01"
    )
    cursor = connection.cursor()

    # เขียนข้อมูลลงในฐานข้อมูล
    sql = "INSERT INTO history (his_id, date, money, stats, portnumber,ticket) VALUES (NULL, NOW(), %s, 0, %s , %s)"
    val = (price, account_number,ticket)
    cursor.execute(sql, val)
    connection.commit()
    
    print("Data written to MySQL successfully.")

model = load_model("XAUUSD_v1_M30_5input.h5")
with open('model.pkl', 'wb') as model_file:
    pickle.dump(model, model_file)
with open('model.pkl', 'rb') as model_file:
    loaded_model = pickle.load(model_file)    


def main():
    # สร้าง Socket ประเภท REP (Reply) เพื่อรอรับข้อมูล
    context = zmq.Context()
    socket = context.socket(zmq.REP)
    socket.bind("tcp://*:5555")
    print("Waiting for incoming messages...")
    
    while True:
        # รับข้อมูลจาก MQL4
        message = socket.recv_string()
        print(f"Received message: {message}")


        # แยกข้อมูลจากข้อความ
        parts = message.split('|')
        if parts[0].strip() == "profit":
            account_number = parts[1].strip().split(':')[1].strip()
            account_balance = float(parts[2].strip().split(':')[1].strip())
            account_equity = float(parts[3].strip().split(':')[1].strip())
            write_to_mysql(account_number, account_balance, account_equity)
            socket.send_string("test")
        elif parts[0].strip() == "history":
            info = parts[1].strip().split(',')
            symbol = info[0].strip()
            id = info[1].strip()
            profit = float(info[2].replace(',', '.').strip())  # แทนที่ ',' เป็น '.' และแปลงเป็น float
            com = float(info[3].replace(',', '.').strip())  # แทนที่ ',' เป็น '.' และแปลงเป็น float
            status = int(info[4].strip())
            port = info[5].strip()
            equity = info[6].strip()
            balance = info[7].strip()

            print("Symbol:", symbol)
            print("ID:", id)
            print("Profit:", profit)
            print("Com:", com)
            print("Status:", status)

            write_to_history(symbol, id, profit, com, status, port, equity, balance)
            socket.send_string("succ history")
        elif parts[0].strip() == "data":
            data_rows = parts[0:]
            #print(data_rows)
            with open("data.csv", "w", newline='') as csvfile:
                writer = csv.writer(csvfile)
                
                # Write header row
                # writer.writerow(['Time', 'Close'])
                
                for row in data_rows:
                    # Remove the "data|" prefix
                    row = row.strip().replace("data|", "")
                    # Split each row into columns
                    row = row.replace("data", "")
                    columns = row.split(',')
                    # Write only time and close price to CSV
                    writer.writerow(columns)
            #print("CSV file created successfully.")
            input_data = pd.read_csv("data.csv")
            input_data = np.array(input_data)
            input_data = np.reshape(input_data, (1, 5))
            #print(input_data)
            result = loaded_model.predict(input_data)
            #print(result)
            result1 = str(result)
            #print(result1)
            result2 = result1.strip('[]')
            #print(result2)
            socket.send_string(result2)

        elif parts[0].strip() == "predict":
            csv_file = 'predict.csv'
            data_rows = parts[0:]
            print(data_rows)
            price = float(parts[1].strip().split(':')[1].strip())
            time = parts[2].strip().replace(':', ' ')
            with open(csv_file, mode='a', newline='') as file:
                writer = csv.writer(file)
                # เขียนค่าลงในไฟล์ CSV
                writer.writerow([time, price])  # ปรับเพื่อให้ข้อมูลในแถวเป็นลิสต์เดียว
            socket.send_string("save")

if __name__ == "__main__":
    main()
