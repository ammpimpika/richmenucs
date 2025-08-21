# ใช้ base image ที่มี Apache และ PHP
FROM php:8.1-apache

# ติดตั้ง extensions ที่จำเป็น
RUN docker-php-ext-install mysqli pdo pdo_mysql

# copy ไฟล์ทั้งหมดของโปรเจกต์ไปยัง Web Root ของ Apache
COPY . /var/www/html/

# expose port ที่ Apache ใช้ (ปกติคือ 80)
EXPOSE 80

# ตั้งค่าให้ Apache เป็น daemon
CMD ["apache2-foreground"]