import mysql.connector

connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="ai"
    )
cursor = connection.cursor()

    # คำสั่ง SQL เพื่อดึงข้อมูล portnumber จากตาราง infouser
sql = "SELECT his_equity FROM history WHERE his_no IN (SELECT MIN(his_no) FROM history WHERE cus_port = %s AND his_status = 0 UNION ALL SELECT MAX(his_no) FROM history WHERE cus_port = %s AND his_status = 0 )"
val  = (70286040,70286040)
cursor.execute(sql, val)
results = cursor.fetchall()
temp = []
for row in results:
    temp.append(row[0])
print(temp[0])
print(temp[1])
print(temp[1]-temp[0])