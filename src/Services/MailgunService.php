<?php

namespace App\Services;

use App\Contracts\SenderInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailgunService implements SenderInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send($from, $to, $subject, $message)
    {
        $email = (new Email())
            ->from('Arnaud POINTET <mailgun@mg.forelse.info>')
            ->to($to)
            ->subject($subject)
            ->text($from.'\n'.$message);

        $this->mailer->send($email);
    }
}