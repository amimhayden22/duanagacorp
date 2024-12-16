## Kebutuhan Aplikasi

- PHP >= 8.1
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Laragon or XAMPP
- Visual Studio Code

## Instalasi

1. clone repo melalui terminal dengan cara `git clone https://github.com/amimhayden22/duanagacorp.git`
2. `cd duanagacorp` untuk masuk ke dalam folder project ini
3. install semua dependesi yang dibutuhkan, dengan perintah `composer install` di terminal
4. kemudian buat database mysql dengan nama `duanagacorp` bisa melalui phpmyadmin di xampp/laragon.
5. selanjutnya, ketik `cp .env.example .env` di terminal
6. kemudian buka `.env` lalu isi semua pengaturan yang diperlukan seperti pengaturan database
7. jalankan perintah `php artisan migrate --seed` dan untuk menjalankan website ini ketik `php artisan serve` di terminal
8. kemudian buka browser dan ketik url berikut: `http://127.0.0.1:8000`

## Catatan

Untuk membuka halaman admin silakan buka url `http://127.0.0.1:8000/admin/login`. Anda dapat login menggunakan akun berikut:

**Akun Admin**
> Email: **admin@duanagacorp.co.id** <br>
> Password: **password**

**Akun User**
> Email: **user@duanagacorp.co.id** <br>
> Password: **password**


Created By: [Gus Khamim](https://guskhamim.com).
