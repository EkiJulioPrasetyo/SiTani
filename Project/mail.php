<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmailToPetani($subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'edijulio112@gmail.com';          // Ganti
        $mail->Password   = 'xckp nevb bxlq euaa';             // Ganti dengan App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('edijulio112@gmail.com', 'SiTani Admin');

        include 'koneksi.php';
        $result = $conn->query("SELECT email FROM Akun WHERE peran = 'petani'");
        while ($row = $result->fetch_assoc()) {
            $mail->addAddress($row['email']);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email gagal: {$mail->ErrorInfo}");
        return false;
    }
}
