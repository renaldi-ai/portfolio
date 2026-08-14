# Panduan Perbaikan Send Email - Portfolio Website

## 🔧 Masalah yang Diperbaiki

### 1. **Error setFrom() Gmail**
**Masalah:** 
```php
$mail->setFrom($email, $name); // ❌ ERROR - Gmail tidak izinkan
```
Gmail tidak mengizinkan Anda menggunakan email arbitrary sebagai sender ketika menggunakan SMTP mereka.

**Solusi:**
```php
$mail->setFrom(SMTP_USER, SITE_NAME);  // ✅ BENAR
$mail->addReplyTo($email, $name);       // Agar bisa reply ke pengirim
```

### 2. **Password SMTP Terekspos**
Password SMTP yang lama terekspos di file config.php. Ini berbahaya untuk keamanan.

### 3. **Error Handling Kurang Baik**
Error handling yang lama kurang informatif dan tidak memberikan feedback yang jelas.

---

## 📝 Cara Menggunakan File yang Sudah Diperbaiki

### Step 1: Backup File Lama
```bash
# Backup file lama
cp send-email.php send-email.php.backup
cp config.php config.php.backup
```

### Step 2: Replace dengan File Baru
```bash
# Ganti dengan file yang sudah diperbaiki
mv send-email-fixed.php send-email.php
mv config-fixed.php config.php
```

### Step 3: Setup App Password Gmail

**PENTING:** Gmail tidak lagi mengizinkan login dengan password biasa untuk aplikasi eksternal. Anda harus menggunakan **App Password**.

#### Cara Membuat App Password Gmail:

1. **Buka Google Account Security**
   - Kunjungi: https://myaccount.google.com/security
   - Login dengan akun Gmail Anda

2. **Aktifkan 2-Step Verification** (jika belum)
   - Cari bagian "2-Step Verification"
   - Klik dan ikuti petunjuk untuk mengaktifkannya

3. **Buat App Password**
   - Setelah 2-Step Verification aktif, cari "App passwords" atau "Kata sandi aplikasi"
   - Klik "App passwords"
   - Pilih:
     - App: **Mail**
     - Device: **Other (Custom name)**
     - Nama: **Portfolio Website**
   - Klik **Generate**

4. **Copy Password**
   - Gmail akan memberikan password 16 karakter (format: xxxx xxxx xxxx xxxx)
   - **COPY** password ini
   - **JANGAN tutup window** sampai password sudah disimpan

5. **Update config.php**
   ```php
   define('SMTP_PASS', 'abcd efgh ijkl mnop'); // Paste App Password di sini
   ```

### Step 4: Update Email Anda di Config
Edit file `config.php`:

```php
define('SMTP_USER', 'email-anda@gmail.com');    // Ganti dengan email Gmail Anda
define('SMTP_PASS', 'xxxx xxxx xxxx xxxx');     // Paste App Password dari Gmail
```

### Step 5: Test Form
1. Buka website Anda
2. Scroll ke bagian Contact/Kontak
3. Isi form dengan data test
4. Klik "Kirim Pesan"
5. Cek email Anda (renaldiyogapratama092@gmail.com)

---

## 🔍 Troubleshooting

### Problem: "SMTP connect() failed"
**Solusi:**
1. Pastikan App Password sudah benar (16 karakter)
2. Pastikan 2-Step Verification aktif
3. Coba gunakan port 465 dengan SSL:
   ```php
   define('SMTP_PORT', 465);
   define('SMTP_SECURE', 'ssl');
   ```

### Problem: "Could not authenticate"
**Solusi:**
1. App Password salah atau expired
2. Buat App Password baru
3. Update di config.php
4. Clear browser cache dan coba lagi

### Problem: Email tidak masuk
**Solusi:**
1. Cek folder **Spam/Junk** di Gmail
2. Cek file `contact_submissions.json` - pesan tetap tersimpan
3. Cek file `contact_log.txt` untuk log pesan
4. Cek file `php_errors.log` untuk error PHP

### Problem: "Failed to connect to server"
**Solusi:**
1. Pastikan server hosting Anda mengizinkan koneksi SMTP keluar
2. Hubungi hosting support untuk membuka port 587 atau 465
3. Beberapa shared hosting memblokir SMTP eksternal

---

## 📋 Checklist Setup

- [ ] Backup file lama (send-email.php, config.php)
- [ ] Copy file baru ke folder website
- [ ] Aktifkan 2-Step Verification di Gmail
- [ ] Buat App Password Gmail
- [ ] Update SMTP_USER di config.php
- [ ] Update SMTP_PASS dengan App Password di config.php
- [ ] Set error_reporting ke 0 untuk production
- [ ] Set display_errors ke 0 untuk production
- [ ] Test form kontak
- [ ] Cek email masuk
- [ ] Cek folder spam jika email tidak masuk
- [ ] Verify file backup (contact_submissions.json) tetap berfungsi

---

## 🎯 Perubahan Utama di Code

### send-email.php

#### Before (❌ ERROR):
```php
$mail->setFrom($email, $name);  // Email pengirim dari form
```

#### After (✅ FIXED):
```php
$mail->setFrom(SMTP_USER, SITE_NAME);  // Email dari SMTP yang terautentikasi
$mail->addReplyTo($email, $name);       // Reply ke pengirim form
```

### Penambahan Fitur:
1. ✅ Error logging yang lebih baik
2. ✅ Plain text alternative untuk email
3. ✅ User agent tracking di backup file
4. ✅ Better error messages untuk user
5. ✅ Informasi pengirim lebih jelas di email

---

## 📞 Contact untuk Support

Jika masih ada masalah setelah mengikuti panduan ini:

1. **Cek Error Log**
   - Lihat file `php_errors.log` di folder website
   - Screenshot error dan kirim via WhatsApp

2. **Cek Backup Files**
   - `contact_submissions.json` - semua pesan tersimpan di sini
   - `contact_log.txt` - log text yang mudah dibaca

3. **Hubungi Saya**
   - WhatsApp: 0895-4063-98540
   - Email: renaldiyogapratama092@gmail.com

---

## 🔐 Security Notes

1. **Jangan commit config.php ke Git** - Tambahkan ke .gitignore
2. **Gunakan Environment Variables** untuk production yang lebih aman
3. **Set error_reporting(0)** di production untuk tidak expose error
4. **Backup App Password** di tempat aman (password manager)
5. **Rotate App Password** secara berkala (6 bulan sekali)

---

## ✅ Quick Test

Setelah setup, test dengan command ini di browser console:

```javascript
// Test form submission
const formData = new FormData();
formData.append('name', 'Test User');
formData.append('email', 'test@example.com');
formData.append('subject', 'Test Subject');
formData.append('service', 'web-development');
formData.append('message', 'This is a test message');

fetch('send-email.php', {
    method: 'POST',
    body: formData
})
.then(r => r.json())
.then(data => console.log(data))
.catch(err => console.error(err));
```

Jika berhasil, Anda akan menerima email dan console akan menampilkan:
```json
{
  "success": true,
  "message": "Pesan berhasil dikirim! Saya akan menghubungi Anda segera."
}
```

---

**Happy Coding! 🚀**
