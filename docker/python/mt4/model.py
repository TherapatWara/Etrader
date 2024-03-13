# ชื่อไฟล์ .txt ที่ต้องการอ่าน
file_name = 'data.txt'

# เปิดไฟล์ .txt ในโหมดอ่าน ('r' mode)
with open(file_name, 'r') as file:
    # อ่านเนื้อหาของไฟล์
    data = file.read()


# พิมพ์เนื้อหาที่อ่านได้
print(data)
print(len(data))
