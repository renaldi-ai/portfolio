<?php
// config.php - Konfigurasi untuk website portfolio
// ALTERNATIF SMTP TANPA APP PASSWORD GMAIL

// Site Configuration
define('SITE_NAME', 'Portfolio Renaldi Yoga Pratama');
define('SITE_EMAIL', 'renaldiyogapratama092@gmail.com');
define('SITE_PHONE', '0895-4063-98540');
define('SITE_LOCATION', 'Bengkulu, Indonesia');
define('SITE_WHATSAPP', '62895406398540');

/* ═══════════════════════════════════════════════════════════════
   PILIHAN SMTP - PILIH SALAH SATU (uncomment yang mau dipakai)
   ═══════════════════════════════════════════════════════════════ */

// ────────────────────────────────────────────────────────────────
// OPTION 1: SENDINBLUE (Brevo) - GRATIS 300 email/hari
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://www.brevo.com (gratis)
// 2. Login → Settings → SMTP & API
// 3. Copy SMTP credentials
// 4. Uncomment baris di bawah dan isi dengan data Anda

/*
define('SMTP_HOST', 'smtp-relay.brevo.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@example.com');      // Email yang didaftarkan di Brevo
define('SMTP_PASS', 'your-brevo-smtp-key');         // SMTP key dari Brevo
define('SMTP_SECURE', 'tls');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 2: MAILGUN - GRATIS 5000 email/bulan (3 bulan pertama)
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://www.mailgun.com
// 2. Verify domain atau gunakan sandbox domain
// 3. Get SMTP credentials
// 4. Uncomment baris di bawah

/*
define('SMTP_HOST', 'smtp.mailgun.org');
define('SMTP_PORT', 587);
define('SMTP_USER', 'postmaster@your-domain.mailgun.org');  // Dari Mailgun dashboard
define('SMTP_PASS', 'your-mailgun-password');                // Password dari Mailgun
define('SMTP_SECURE', 'tls');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 3: MAILTRAP - UNTUK TESTING (email tidak terkirim ke real user)
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://mailtrap.io (gratis)
// 2. Buat inbox baru
// 3. Copy SMTP credentials
// 4. Uncomment baris di bawah
// CATATAN: Ini hanya untuk testing, email tidak benar-benar terkirim

/*
define('SMTP_HOST', 'sandbox.smtp.mailtrap.io');
define('SMTP_PORT', 2525);
define('SMTP_USER', 'your-mailtrap-username');
define('SMTP_PASS', 'your-mailtrap-password');
define('SMTP_SECURE', 'tls');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 4: ZOHO MAIL - GRATIS untuk domain sendiri
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://www.zoho.com/mail/
// 2. Buat email account
// 3. Uncomment baris di bawah

/*
define('SMTP_HOST', 'smtp.zoho.com');
define('SMTP_PORT', 465);
define('SMTP_USER', 'your-email@yourdomain.com');
define('SMTP_PASS', 'your-zoho-password');
define('SMTP_SECURE', 'ssl');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 5: SENDGRID - GRATIS 100 email/hari
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://sendgrid.com
// 2. Create API Key
// 3. Use 'apikey' as username and your API key as password
// 4. Uncomment baris di bawah

/*
define('SMTP_HOST', 'smtp.sendgrid.net');
define('SMTP_PORT', 587);
define('SMTP_USER', 'apikey');                          // Literally type "apikey"
define('SMTP_PASS', 'SG.xxxxxxxxxxxxxxxxxxxxxxxx');    // Your SendGrid API key
define('SMTP_SECURE', 'tls');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 6: MAILJET - GRATIS 200 email/hari, 6000/bulan
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Daftar di: https://www.mailjet.com
// 2. Settings → SMTP Settings
// 3. Uncomment baris di bawah

/*
define('SMTP_HOST', 'in-v3.mailjet.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-mailjet-api-key');
define('SMTP_PASS', 'your-mailjet-secret-key');
define('SMTP_SECURE', 'tls');
*/

// ────────────────────────────────────────────────────────────────
// OPTION 7: HOSTING SMTP (Jika hosting Anda menyediakan email)
// ────────────────────────────────────────────────────────────────
// Cara setup:
// 1. Buat email di cPanel hosting (contoh: noreply@yourdomain.com)
// 2. Cari SMTP settings di cPanel/email settings
// 3. Uncomment dan isi dengan data hosting Anda

/*
define('SMTP_HOST', 'mail.yourdomain.com');          // atau smtp.yourdomain.com
define('SMTP_PORT', 465);                            // atau 587
define('SMTP_USER', 'noreply@yourdomain.com');       // Email yang dibuat di cPanel
define('SMTP_PASS', 'your-email-password');          // Password email
define('SMTP_SECURE', 'ssl');                        // ssl untuk 465, tls untuk 587
*/

// ────────────────────────────────────────────────────────────────
// OPTION 8: ELASTIC EMAIL - GRATIS 100 email/hari
// ────────────────────────────────────────────────────────────────
/*
define('SMTP_HOST', 'smtp.elasticemail.com');
define('SMTP_PORT', 2525);
define('SMTP_USER', 'your-email@example.com');
define('SMTP_PASS', 'your-elastic-email-smtp-password');
define('SMTP_SECURE', 'tls');
*/

// ═══════════════════════════════════════════════════════════════
// REKOMENDASI SAYA:
// ═══════════════════════════════════════════════════════════════
// 1. SENDINBLUE (Brevo) - Paling mudah, gratis 300 email/hari
// 2. MAILJET - Mudah setup, gratis 200 email/hari
// 3. Hosting SMTP - Jika sudah punya domain & hosting email
// ═══════════════════════════════════════════════════════════════

// DEFAULT: SENDINBLUE (GANTI DENGAN CREDENTIALS ANDA)
define('SMTP_HOST', 'smtp-relay.brevo.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@example.com');        // GANTI dengan email Brevo Anda
define('SMTP_PASS', 'your-brevo-smtp-key');          // GANTI dengan SMTP key Brevo
define('SMTP_SECURE', 'tls');
define('SMTP_DEBUG', 0);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Security Headers
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Function untuk sanitize input
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Function untuk validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function untuk send JSON response
function send_json_response($success, $message, $data = null) {
    header('Content-Type: application/json');
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// Function cek konfigurasi SMTP
function check_smtp_config() {
    $errors = [];
    
    if (SMTP_PASS === 'your-brevo-smtp-key' || SMTP_PASS === 'your-mailgun-password' || strlen(SMTP_PASS) < 5) {
        $errors[] = 'SMTP Password belum diisi dengan benar';
    }
    
    if (SMTP_USER === 'your-email@example.com' || !filter_var(SMTP_USER, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'SMTP User belum diisi dengan email yang valid';
    }
    
    return $errors;
}
?>
