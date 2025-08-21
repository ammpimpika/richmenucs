# เลือก Node version
FROM node:20

# ตั้ง working directory ใน container
WORKDIR /app

# COPY เฉพาะไฟล์ package ก่อน เพื่อให้ Docker cache ได้
COPY package.json package-lock.json ./

# ติดตั้ง dependencies
RUN npm ci

# COPY โค้ดทั้งหมดเข้า container
COPY . .

# คำสั่งรันแอป
CMD ["node", "index.js"]
