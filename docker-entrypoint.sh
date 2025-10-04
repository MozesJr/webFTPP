#!/bin/bash

# Pastikan semua file di /var/www/html dimiliki oleh www-data untuk menghindari masalah permissions saat Vite menulis file
chown -R www-data:www-data /var/www/html

# Jalankan Vite Dev Server sebagai www-data di latar belakang
# Perintah ini akan tetap aktif dan menulis assets
su www-data -c "npm run dev &"

# Jalankan Apache di latar depan (foreground) sebagai proses utama
exec apache2-foreground
