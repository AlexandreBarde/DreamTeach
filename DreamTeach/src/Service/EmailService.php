<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 12/03/2019
 * Time: 18:58
 */

namespace App\Service;


class EmailService
{

    public function __construct()
    {}

    /**
     * Send a mail to receiver
     * @param $receiver
     * @param $subject
     * @param $body
     * @param \Swift_Mailer $mailer
     */
    public static function sendMail($receiver, $subject, $body, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom("ptutdreamteach@gmail.com")
            ->setTo($receiver)
            ->setBody($body,'text/html');
        $mailer->send($message);
    }

}