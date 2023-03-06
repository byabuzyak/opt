<?php

namespace App\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use App\Entity\User;
use SplSubject;

class SignupSuccessNotification implements \SplObserver
{
    /**
     * @param SplSubject $subject
     * @param User|null $user
     * @return void
     * @throws TransportExceptionInterface
     */
    public function update(SplSubject $subject, User $user = null): void
    {
        /**
         * Ideally we should init a config object and get the credentials here
         */
        $transport = Transport::fromDsn('smtp://null:null@mailhog:1025');
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('robot@opt.com')
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGHEST)
            ->subject('Your registration is verified')
            ->text(
                sprintf(
                    'Hello, %s. Your registration is verified',
                    $user->getName()
                )
            );

        $mailer->send($email);
    }
}