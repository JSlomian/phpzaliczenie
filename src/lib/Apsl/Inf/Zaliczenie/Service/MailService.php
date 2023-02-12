<?php

namespace Apsl\Inf\Zaliczenie\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

final class MailService
{
    private const EMAIL = "apsl-dev@gmx.com";
    private const DSN = "smtp://apsl-dev@gmx.com:apslDEV2023@mail.gmx.com:587";
    private Mailer $mailer;
    public function __construct()
    {
        $transport = Transport::fromDsn(self::DSN);
        $this->mailer = new Mailer($transport);
    }

    public function sendEmail(string $email, string $message, &$errors): void
    {
        $emailObj = (new Email())
            ->from(self::EMAIL)
            ->to($email)
            ->subject('Resetowanie hasła')
            ->html($message);
        try {
        $this->mailer->send($emailObj);
        } catch (TransportExceptionInterface $e) {
            $errors[] = $e;
        }
    }

}