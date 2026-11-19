<?php

declare(strict_types=1);

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public static function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $body
    ): bool {

        try {

            $rootPath = dirname(__DIR__, 2);

            require_once $rootPath . '/vendor/autoload.php';

            $config = require $rootPath . '/config/mail.php';

            if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            $mail = new PHPMailer(true);

            // Cấu hình SMTP Gmail
            $mail->isSMTP();

            $mail->Host = $config['host'];

            $mail->SMTPAuth = true;

            $mail->Username = $config['username'];

            $mail->Password = $config['password'];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = (int) $config['port'];

            $mail->CharSet = 'UTF-8';

            // Thông tin người gửi
            $mail->setFrom(
                $config['from_email'],
                $config['from_name']
            );

            // Thông tin người nhận
            $mail->addAddress(
                $toEmail,
                $toName
            );

            // Nội dung email
            $mail->isHTML(true);

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->AltBody = strip_tags($body);

            // Gửi email
            $mail->send();

            return true;

        } catch (\Throwable $e) {

            error_log(
                '========== PHPMailer ERROR =========='
            );

            error_log(
                'Message: ' . $e->getMessage()
            );

            error_log(
                'File: ' . $e->getFile()
            );

            error_log(
                'Line: ' . $e->getLine()
            );

            error_log(
                '====================================='
            );

            return false;
        }
    }
}
