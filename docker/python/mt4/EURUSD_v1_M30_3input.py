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
'''
def read_to_user(account_number):
    # เชื่อมต่อ MySQL
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="bot02"
    )
    cursor = connection.cursor()

    # คำสั่ง SQL เพื่อดึงข้อมูล portnumber จากตาราง infouser
    sql = "SELECT portnumber FROM infouser"
    cursor.execute(sql)

    # ดึงข้อมูลทั้งหมด
    portnumbers = cursor.fetchall()
    result_list = [row[0] for row in portnumbers]
    # แสดงผลลัพธ์
    for result_list in portnumbers:
        if(str(result_list[0]) == str(account_number)):
            return 1
    print("Data written to MySQL successfully.")
    
'''

def write_to_history(symbol, id, profit, com, status, port, equity, balance):
    # เชื่อมต่อ MySQL
    connection = mysql.connector.connect(
        host="db",
        user="root",
        password="ttt",
        database="ai"
    )
    cursor = connection.cursor()
    symbol = str(symbol)
    print(symbol , ":" , id, ":" ,profit, ":" , com, ":" ,status)
    # เขียนข้อมูลลงในฐานข้อมูล
    sql = "INSERT INTO history (his_no, his_time, his_symbol, his_orderid, his_profit, his_commit, his_status, cus_port, his_equity, his_balance) VALUES (NULL, NULL, %s, %s, %s, %s, %s, %s, %s, %s)"
    val = (symbol, id, profit, com, status, port, equity, balance)


    cursor.execute(sql, val)
    connection.commit()
    
    print("Data written to MySQL successfully.")

def check_payment(user):
    connection = mysql.connector.connect(
        host="db",
        user="root",
        password="ttt",
        database="ai"
    )
    cursor = connection.cursor()

    # คำสั่ง SQL เพื่อดึงข้อมูล portnumber จากตาราง infouser
    sql = "SELECT his_equity FROM history WHERE his_no IN (SELECT MIN(his_no) FROM history WHERE cus_port = %s AND his_status = 0 UNION ALL SELECT MAX(his_no) FROM history WHERE cus_port = %s AND his_status = 0 )"
    val  = (user,user)
    cursor.execute(sql, val)
    results = cursor.fetchall()
    temp = []
    for row in results:
        temp.append(row[0])
    #print(temp[0])
    #print(temp[1])
    #print(temp[1]-temp[0])
    willpay = temp[1]-temp[0]
    print(willpay)
    if(willpay > 5):
        return 1
    else:
        return 0

def check_user(user):
    # เชื่อมต่อ MySQL
    connection = mysql.connector.connect(
        host="db",
        user="root",
        password="ttt",
        database="ai"
    )
    cursor = connection.cursor()


    # คำสั่ง SQL เพื่อดึงข้อมูล portnumber จากตาราง infouser
    sql = "SELECT cus_port FROM customer"
    cursor.execute(sql)

    # ดึงข้อมูลทั้งหมด
    portnumbers = cursor.fetchall()
    result_list = [row[0] for row in portnumbers]
    # แสดงผลลัพธ์
    for result_list in portnumbers:
        if(str(result_list[0]) == str(user)):
            return 1


model = load_model("EURUSD_v1_M30_3input.h5")
with open('model.pkl', 'wb') as model_file:
    pickle.dump(model, model_file)
with open('model.pkl', 'rb') as model_file:
    loaded_model = pickle.load(model_file)    


def main():
    # สร้าง Socket ประเภท REP (Reply) เพื่อรอรับข้อมูล
    context = zmq.Context()
    socket = context.socket(zmq.REP)
    socket.bind("tcp://*:5557")
    print("Waiting for incoming messages...")
    
    while True:
        # รับข้อมูลจาก MQL4
        message = socket.recv_string()
        print(f"Received message: {message}")


        # แยกข้อมูลจากข้อความ
        parts = message.split('|')
        if parts[0].strip() == "check":
            account_number = parts[1].strip().split(':')[1].strip()
            if(read_to_user(account_number)==1):
                socket.send_string("1")
            else:
                socket.send_string("0")
        elif parts[0].strip() == "profit":
            read_to_user()
            account_number = parts[1].strip().split(':')[1].strip()
            account_balance = float(parts[2].strip().split(':')[1].strip())
            account_equity = float(parts[3].strip().split(':')[1].strip())
            write_to_mysql(account_number, account_balance, account_equity)
            socket.send_string("test")
        elif parts[0].strip() == "login":
            info = parts[1].strip().split(',')
            user = info[0].strip()
            check_user(user)
            if(check_user(user)==1):
                socket.send_string("1")
            else:
                socket.send_string("0")
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
        elif parts[0].strip() == "payment":
            info = parts[1].strip().split(',')
            user = info[0].strip()
            x = check_payment(user)
            x1 = str(x)
            socket.send_string(x1)

            
        elif parts[0].strip() == "data":
            data_rows = parts[0:]
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
            input_data = np.reshape(input_data, (1, 3))
            #print(input_data)
            result = loaded_model.predict(input_data)
            #print(result)
            result1 = str(result)
            result2 = result1.strip('[]')
            print(result2)
            socket.send_string(result2)

if __name__ == "__main__":
    main()
