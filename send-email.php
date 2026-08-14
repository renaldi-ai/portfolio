<?php
// send-email.php - Handle form submission dengan fallback yang telah diperbaiki

// Include config
require_once 'config.php';

// Set JSON header
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_json_response(false, 'Method not allowed');
}

// Get and sanitize form data
$name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
$subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
$service = isset($_POST['service']) ? sanitize_input($_POST['service']) : 'Tidak ditentukan';
$message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';

// Validate required fields
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    send_json_response(false, 'Semua field wajib diisi');
}

if (!validate_email($email)) {
    send_json_response(false, 'Email tidak valid');
}

// Try to use PHPMailer if available
if (file_exists('PHPMailer/src/PHPMailer.php')) {
    try {
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        require 'PHPMailer/src/Exception.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';
        
        // Debug jika diperlukan (set di config.php)
        if (defined('SMTP_DEBUG') && SMTP_DEBUG > 0) {
            $mail->SMTPDebug = SMTP_DEBUG;
            $mail->Debugoutput = 'html';
        }
        
        // Recipients - PERBAIKAN: Gunakan SMTP_USER sebagai sender
        // Karena Gmail tidak mengizinkan setFrom dengan email arbitrary
        $mail->setFrom(SMTP_USER, SITE_NAME);
        $mail->addAddress(SITE_EMAIL, 'Renaldi Yoga Pratama');
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = SITE_NAME . ' - ' . $subject;
        
        // Email body dengan informasi pengirim yang jelas
        $email_body = "
        <!DOCTYPE html>
        <html lang='id'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-item { margin-bottom: 15px; }
                .label { font-weight: bold; color: #2563eb; }
                .message-box { background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin: 20px 0; }
                .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 12px; }
                .sender-info { background: #e0f2fe; padding: 15px; border-left: 4px solid #2563eb; margin-bottom: 20px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Pesan Baru dari Portfolio</h1>
                    <p>" . SITE_NAME . "</p>
                </div>
                <div class='content'>
                    <div class='sender-info'>
                        <h3 style='margin-top: 0; color: #2563eb;'>Informasi Pengirim</h3>
                        <div class='info-item'>
                            <span class='label'>Nama:</span> $name
                        </div>
                        <div class='info-item'>
                            <span class='label'>Email:</span> <a href='mailto:$email'>$email</a>
                        </div>
                        <div class='info-item'>
                            <span class='label'>Subjek:</span> $subject
                        </div>
                        <div class='info-item'>
                            <span class='label'>Layanan:</span> $service
                        </div>
                        <div class='info-item'>
                            <span class='label'>Tanggal:</span> " . date('d-m-Y H:i:s') . "
                        </div>
                    </div>
                    
                    <div class='message-box'>
                        <h3>Isi Pesan:</h3>
                        <p>" . nl2br($message) . "</p>
                    </div>
                    
                    <div class='footer'>
                        <p>Email ini dikirim dari form kontak portfolio " . SITE_NAME . "</p>
                        <p><strong>Untuk membalas:</strong> Klik tombol reply atau balas langsung ke <a href='mailto:$email'>$email</a></p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $mail->Body = $email_body;
        
        // Plain text alternative
        $mail->AltBody = "Pesan baru dari: $name ($email)\n\n" .
                        "Subjek: $subject\n" .
                        "Layanan: $service\n\n" .
                        "Pesan:\n$message\n\n" .
                        "Untuk membalas, kirim email ke: $email";
        
        // Send email
        if ($mail->send()) {
            // Save to file as backup
            save_contact_to_file($name, $email, $subject, $service, $message);
            
            send_json_response(true, 'Pesan berhasil dikirim! Saya akan menghubungi Anda segera.');
        } else {
            throw new Exception('Gagal mengirim email: ' . $mail->ErrorInfo);
        }
        
    } catch (Exception $e) {
        // Log error untuk debugging
        error_log('PHPMailer Error: ' . $e->getMessage());
        
        // Jika PHPMailer gagal, save ke file
        save_contact_to_file($name, $email, $subject, $service, $message);
        
        // Kirim response yang user-friendly dengan nomor WA
        send_json_response(true, 'Pesan Anda telah tersimpan! Silakan hubungi langsung via WhatsApp 0895-4063-98540 untuk respon cepat.');
    }
} else {
    // If PHPMailer not available, save to file
    save_contact_to_file($name, $email, $subject, $service, $message);
    
    send_json_response(true, 'Pesan berhasil disimpan! Silakan hubungi langsung via WhatsApp 0895-4063-98540 untuk respon cepat.');
}

// Function to save contact to file
function save_contact_to_file($name, $email, $subject, $service, $message) {
    $data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'service' => $service,
        'message' => $message,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ];
    
    $filename = 'contact_submissions.json';
    
    // Read existing data
    $submissions = [];
    if (file_exists($filename)) {
        $existing = file_get_contents($filename);
        if ($existing) {
            $submissions = json_decode($existing, true) ?? [];
        }
    }
    
    // Add new submission
    $submissions[] = $data;
    
    // Save to file
    file_put_contents($filename, json_encode($submissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // Also save to simple text file for easy viewing
    $log_entry = "[" . date('Y-m-d H:i:s') . "]\n";
    $log_entry .= "Nama: $name\n";
    $log_entry .= "Email: $email\n";
    $log_entry .= "Subjek: $subject\n";
    $log_entry .= "Layanan: $service\n";
    $log_entry .= "Pesan: $message\n";
    $log_entry .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown') . "\n";
    $log_entry .= str_repeat("-", 50) . "\n\n";
    
    file_put_contents('contact_log.txt', $log_entry, FILE_APPEND);
}
?>
