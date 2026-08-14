<?php
/**
 * test-email.php
 * File untuk test konfigurasi email PHPMailer
 * 
 * PENTING: Hapus atau rename file ini setelah testing selesai untuk keamanan!
 * 
 * Cara pakai:
 * 1. Upload file ini ke folder yang sama dengan send-email.php
 * 2. Buka di browser: http://yoursite.com/test-email.php
 * 3. Lihat hasilnya
 * 4. Hapus file ini setelah selesai testing
 */

// Include config
require_once 'config.php';

// Set HTML output
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email Configuration</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { margin-bottom: 10px; }
        .content { padding: 30px; }
        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            border-left: 4px solid #2563eb;
        }
        .test-section h2 {
            color: #2563eb;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #e5e5e5;
        }
        .info-row:last-child { border-bottom: none; }
        .label { font-weight: 600; color: #555; }
        .value { color: #333; }
        .success { color: #10b981; font-weight: 600; }
        .error { color: #ef4444; font-weight: 600; }
        .warning { color: #f59e0b; font-weight: 600; }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success { background: #d1fae5; border-left: 4px solid #10b981; }
        .alert-error { background: #fee2e2; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fef3c7; border-left: 4px solid #f59e0b; }
        .code {
            background: #1e293b;
            color: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 Test Email Configuration</h1>
            <p>Pengujian Konfigurasi PHPMailer & SMTP</p>
        </div>
        
        <div class="content">
            <?php
            // Check if PHPMailer exists
            $phpmailer_exists = file_exists('PHPMailer/src/PHPMailer.php');
            
            echo '<div class="test-section">';
            echo '<h2>1. File PHPMailer</h2>';
            if ($phpmailer_exists) {
                echo '<div class="alert alert-success">✅ PHPMailer ditemukan di folder PHPMailer/</div>';
            } else {
                echo '<div class="alert alert-error">❌ PHPMailer tidak ditemukan! Download dari <a href="https://github.com/PHPMailer/PHPMailer" target="_blank">GitHub</a></div>';
            }
            echo '</div>';
            
            // Check configuration
            echo '<div class="test-section">';
            echo '<h2>2. Konfigurasi SMTP</h2>';
            
            $config_errors = check_smtp_config();
            
            if (empty($config_errors)) {
                echo '<div class="alert alert-success">✅ Konfigurasi dasar sudah benar</div>';
            } else {
                echo '<div class="alert alert-error">';
                echo '<strong>❌ Ditemukan masalah konfigurasi:</strong><ul>';
                foreach ($config_errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul></div>';
            }
            
            echo '<div class="info-row">';
            echo '<span class="label">SMTP Host:</span>';
            echo '<span class="value">' . SMTP_HOST . '</span>';
            echo '</div>';
            
            echo '<div class="info-row">';
            echo '<span class="label">SMTP Port:</span>';
            echo '<span class="value">' . SMTP_PORT . '</span>';
            echo '</div>';
            
            echo '<div class="info-row">';
            echo '<span class="label">SMTP User:</span>';
            echo '<span class="value">' . SMTP_USER . '</span>';
            echo '</div>';
            
            echo '<div class="info-row">';
            echo '<span class="label">SMTP Password:</span>';
            echo '<span class="value">';
            if (SMTP_PASS === 'xxxx xxxx xxxx xxxx' || strlen(SMTP_PASS) < 10) {
                echo '<span class="error">❌ Belum diisi!</span>';
            } else {
                echo '<span class="success">✅ Sudah diisi (' . strlen(SMTP_PASS) . ' karakter)</span>';
            }
            echo '</span>';
            echo '</div>';
            
            echo '<div class="info-row">';
            echo '<span class="label">SMTP Secure:</span>';
            echo '<span class="value">' . SMTP_SECURE . '</span>';
            echo '</div>';
            
            echo '<div class="info-row">';
            echo '<span class="label">Site Email:</span>';
            echo '<span class="value">' . SITE_EMAIL . '</span>';
            echo '</div>';
            
            echo '</div>';
            
            // Test SMTP Connection
            if ($phpmailer_exists && empty($config_errors)) {
                echo '<div class="test-section">';
                echo '<h2>3. Test Koneksi SMTP</h2>';
                
                try {
                    require 'PHPMailer/src/PHPMailer.php';
                    require 'PHPMailer/src/SMTP.php';
                    require 'PHPMailer/src/Exception.php';
                    
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\SMTP;
                    use PHPMailer\PHPMailer\Exception;
                    
                    $mail = new PHPMailer(true);
                    
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = SMTP_HOST;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = SMTP_SECURE;
                    $mail->Port       = SMTP_PORT;
                    $mail->Timeout    = 10;
                    
                    // Try to connect
                    if ($mail->smtpConnect()) {
                        echo '<div class="alert alert-success">';
                        echo '✅ <strong>Koneksi SMTP berhasil!</strong><br>';
                        echo 'Server merespon dengan baik. Konfigurasi email Anda sudah benar.';
                        echo '</div>';
                        $mail->smtpClose();
                        
                        // Show send test email button
                        echo '<form method="POST" style="margin-top: 20px;">';
                        echo '<p><strong>Kirim email test ke:</strong></p>';
                        echo '<input type="email" name="test_email" placeholder="email@example.com" required style="padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px; margin-right: 10px;">';
                        echo '<button type="submit" name="send_test" class="btn">📧 Kirim Test Email</button>';
                        echo '</form>';
                        
                    } else {
                        throw new Exception('Tidak dapat terhubung ke SMTP server');
                    }
                    
                } catch (Exception $e) {
                    echo '<div class="alert alert-error">';
                    echo '❌ <strong>Koneksi SMTP gagal!</strong><br>';
                    echo 'Error: ' . $e->getMessage();
                    echo '</div>';
                    
                    echo '<div class="alert alert-warning">';
                    echo '<strong>💡 Troubleshooting:</strong><ul>';
                    echo '<li>Pastikan App Password Gmail sudah benar (16 karakter)</li>';
                    echo '<li>Pastikan 2-Step Verification aktif di akun Gmail</li>';
                    echo '<li>Cek apakah hosting Anda memblokir port SMTP (587 atau 465)</li>';
                    echo '<li>Coba ganti port dari 587 ke 465 dan SMTP_SECURE dari tls ke ssl</li>';
                    echo '</ul></div>';
                }
                
                echo '</div>';
            }
            
            // Handle send test email
            if (isset($_POST['send_test']) && !empty($_POST['test_email'])) {
                echo '<div class="test-section">';
                echo '<h2>4. Hasil Pengiriman Test Email</h2>';
                
                try {
                    require 'PHPMailer/src/PHPMailer.php';
                    require 'PHPMailer/src/SMTP.php';
                    require 'PHPMailer/src/Exception.php';
                    
                    use PHPMailer\PHPMailer\PHPMailer;
                    
                    $mail = new PHPMailer(true);
                    
                    $mail->isSMTP();
                    $mail->Host       = SMTP_HOST;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = SMTP_SECURE;
                    $mail->Port       = SMTP_PORT;
                    $mail->CharSet    = 'UTF-8';
                    
                    $mail->setFrom(SMTP_USER, SITE_NAME);
                    $mail->addAddress($_POST['test_email']);
                    
                    $mail->isHTML(true);
                    $mail->Subject = 'Test Email dari ' . SITE_NAME;
                    $mail->Body    = '<h1>Test Email Berhasil!</h1><p>Jika Anda menerima email ini, berarti konfigurasi email PHPMailer Anda sudah benar.</p><p>Timestamp: ' . date('Y-m-d H:i:s') . '</p>';
                    $mail->AltBody = 'Test Email Berhasil! Jika Anda menerima email ini, berarti konfigurasi email PHPMailer Anda sudah benar.';
                    
                    $mail->send();
                    
                    echo '<div class="alert alert-success">';
                    echo '✅ <strong>Email test berhasil dikirim!</strong><br>';
                    echo 'Email telah dikirim ke: <strong>' . htmlspecialchars($_POST['test_email']) . '</strong><br>';
                    echo 'Silakan cek inbox atau folder spam.';
                    echo '</div>';
                    
                } catch (Exception $e) {
                    echo '<div class="alert alert-error">';
                    echo '❌ <strong>Gagal mengirim email!</strong><br>';
                    echo 'Error: ' . $mail->ErrorInfo;
                    echo '</div>';
                }
                
                echo '</div>';
            }
            
            // Instructions
            echo '<div class="test-section">';
            echo '<h2>📝 Langkah Selanjutnya</h2>';
            
            if (!$phpmailer_exists) {
                echo '<p><strong>1. Download PHPMailer</strong></p>';
                echo '<div class="code">git clone https://github.com/PHPMailer/PHPMailer.git</div>';
                echo '<p>atau download ZIP dari GitHub dan ekstrak ke folder PHPMailer/</p>';
            }
            
            if (!empty($config_errors)) {
                echo '<p><strong>2. Perbaiki Konfigurasi</strong></p>';
                echo '<ul>';
                echo '<li>Buka file <code>config.php</code></li>';
                echo '<li>Update SMTP_USER dengan email Gmail Anda</li>';
                echo '<li>Buat App Password Gmail (lihat PERBAIKAN_EMAIL.md)</li>';
                echo '<li>Update SMTP_PASS dengan App Password tersebut</li>';
                echo '</ul>';
            } else {
                echo '<p class="success">✅ Konfigurasi sudah benar! Anda siap menggunakan fitur email.</p>';
            }
            
            echo '<p><strong>⚠️ PENTING:</strong> Hapus file test-email.php ini setelah selesai testing untuk keamanan!</p>';
            
            echo '</div>';
            
            // Server info
            echo '<div class="test-section">';
            echo '<h2>ℹ️ Info Server</h2>';
            echo '<div class="info-row">';
            echo '<span class="label">PHP Version:</span>';
            echo '<span class="value">' . phpversion() . '</span>';
            echo '</div>';
            echo '<div class="info-row">';
            echo '<span class="label">Server Software:</span>';
            echo '<span class="value">' . $_SERVER['SERVER_SOFTWARE'] . '</span>';
            echo '</div>';
            echo '<div class="info-row">';
            echo '<span class="label">Current Time:</span>';
            echo '<span class="value">' . date('Y-m-d H:i:s') . '</span>';
            echo '</div>';
            echo '</div>';
            ?>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="index.html" class="btn">← Kembali ke Portfolio</a>
            </div>
        </div>
    </div>
</body>
</html>
