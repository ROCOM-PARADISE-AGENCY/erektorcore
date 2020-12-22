<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/21/2019
 * Time: 9:13 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;

use rpa\erektorcoreConfig;
use rpa\erektorcoreError;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    /*
     * Send an email message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content
     * @param string $html Html content
     *
     * @return mixed
     */
    public static function send($to, $subject, $text, $html) : bool
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                    // Enable verbose debug output
            $mail->isSMTP();                                         // Set mailer to use SMTP
            $mail->Host       = Config::EMAIL_HOST;                  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = Config::SMTP_AUTH;                   // Enable SMTP authentication
            $mail->Username   = Config::EMAIL_USERNAME;              // SMTP username
            $mail->Password   = Config::EMAIL_PASSWORD;              // SMTP password
            $mail->SMTPSecure = Config::SMTP_SECURE;                 // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = Config::SMTP_PORT;                   // TCP port to connect to

            // For most clients expecting the Priority header:
            // 1 = High, 2 = Medium, 3 = Low
            $mail->Priority = 1;
            // MS Outlook custom header
            // May set to "Urgent" or "Highest" rather than "High"
            $mail->AddCustomHeader("X-MSMail-Priority: High");
            // Not sure if Priority will also set the Importance header:
            $mail->AddCustomHeader("Importance: High");

            //Recipients
            $mail->setFrom('no-reply@paradise-agency.ro', 'Erektor');
            $mail->addAddress($to, 'No reply');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $text;

            return $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            throw new \Exception('Message could not be sent. Mailer Error:' . $mail->ErrorInfo);
        }
    }
}