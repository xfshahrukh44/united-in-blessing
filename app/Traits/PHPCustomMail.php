<?php

namespace App\Traits;

use File;
use PHPMailer\PHPMailer\PHPMailer;

trait PHPCustomMail
{
    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $html
     * @return bool
     */
    public function customMail($from, $to, $subject, $html)
    {
//        $from = 'no-reply@tha-network.com';

        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Compose a simple HTML email message
        $message = $html;

        // Sending email
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    public function customMailerWithAttachment($from, $to, $subject, $html, $file = null)
    {
        $email = new PHPMailer();

        $email->isHTML(true);
        $email->isMail();
        $email->setFrom($from);
        $email->addAddress($to);
        $email->addCustomHeader('From', $from);
        $email->addCustomHeader('Reply-To', $from);
        $email->addCustomHeader('X-Mailer', 'PHP/' . phpversion());
        $email->Subject = $subject;
        $email->Body = $html;

        if (!empty($file)){
            $email->addAttachment($file, File::name($file));
        }

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }

}
