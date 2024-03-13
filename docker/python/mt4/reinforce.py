from datetime import datetime
import MetaTrader5 as mt5
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
import random

# เชื่อมต่อกับ MetaTrader 5
if not mt5.initialize():
    print("initialize() failed, error code =", mt5.last_error())
    quit()

# กำหนดค่าการเชื่อมต่อ
symbol = "EURUSD"  # สกุลเงินที่ต้องการดูข้อมูล
timeframe = mt5.TIMEFRAME_M1  # ช่วงเวลาของข้อมูล (4 ชั่วโมง)
date_from = datetime(2022, 1, 1)  # วันที่เริ่มต้น
date_to = datetime(2024, 1, 10)  # วันที่สิ้นสุด

# ตั้งค่าพารามิเตอร์สำหรับการเทรน
alpha = 0.01  # อัตราการเรียนรู้
gamma = 0.99  # ค่าส่วนลดของรางวัล
epsilon = 1.0  # ค่าเริ่มต้นของความสุ่มในการเลือกแอ็คชัน
epsilon_min = 0.01  # ค่าสุดท้ายของความสุ่มในการเลือกแอ็คชัน
epsilon_decay = 0.995  # อัตราการลดของความสุ่มในการเลือกแอ็คชัน

bars = 1000  # Number of bars to download

rates = mt5.copy_rates_from_pos(symbol, timeframe, 0, bars)

data = pd.DataFrame(rates)
data['time'] = pd.to_datetime(data['time'], unit='s')

exp1 = data['close'].ewm(span=12, adjust=False).mean()
exp2 = data['close'].ewm(span=26, adjust=False).mean()
macd = exp1 - exp2
signal_line = macd.ewm(span=9, adjust=False).mean()

data['MACD'] = macd
data['Signal_Line'] = signal_line

# สร้าง Q-table
num_states = 4  # จำนวนของสถานะ (open, high, low, close)
num_actions = 2  # จำนวนของแอ็คชัน (Buy, Sell)
q_table = np.zeros((num_states, num_actions))

# สร้างฟังก์ชันสำหรับการเลือกราคาปิด
def choose_action(state):
    if np.random.rand() <= epsilon:
        return random.randrange(num_actions)  # สุ่มเลือกแอ็คชัน
    else:
        return np.argmax(q_table[state, :])  # เลือกแอ็คชันที่ให้ค่า Q-value สูงสุด

# คำนวณค่า Q-value ด้วย Q-learning algorithm
def update_q_value(state, action, reward, next_state):
    max_q_next = np.max(q_table[next_state, :])
    q_table[state, action] = q_table[state, action] + alpha * (reward + gamma * max_q_next - q_table[state, action])

# เริ่มการเรียนรู้แบบเรียลไทม์
while True:
    # รับข้อมูลการซื้อขายจาก MetaTrader 5
    rates = mt5.copy_rates_from(symbol, timeframe, datetime.now(), 1)
    if rates is not None and len(rates) > 0:
        # แปลงข้อมูลเป็น DataFrame
        df = pd.DataFrame(rates)
        df['time'] = pd.to_datetime(df['time'], unit='s')
        df = df.set_index('time')

        # เริ่มการทำ preprocessing ข้อมูล
        scaler = MinMaxScaler()
        scaled_data = scaler.fit_transform(df[['open', 'high', 'low', 'close']])

        # เริ่มการเทรน
        state = 0  # ใช้ข้อมูลราคาปิดตอนแรกเป็นสถานะเริ่มต้น
        total_reward = 0

        for time_step in range(1, len(scaled_data)):
            action = choose_action(state)
            next_state = time_step

            # คำนวณราคาปิดถัดไป
            next_close_price = df.iloc[time_step]['close']
            current_close_price = df.iloc[state]['close']
            reward = next_close_price - current_close_price

            # ปรับปรุง Q-value โดยใช้ Q-learning algorithm
            update_q_value(state, action, reward, next_state)

            total_reward += reward

            # แสดงข้อมูล state, action, reward
            print("State:", state, "Action:", action, "Reward:", reward)

            state = next_state  # อัพเดทสถานะ

        # ลดค่าของ epsilon เพื่อลดการสุ่มในการเลือกแอ็คชัน
        if epsilon > epsilon_min:
            epsilon *= epsilon_decay

        print("Total Reward:", total_reward)
        print("Epsilon:", epsilon)
        print("Q-table:")
        print(q_table)

# หยุดการเชื่อมต่อ MetaTrader 5
mt5.shutdown()
