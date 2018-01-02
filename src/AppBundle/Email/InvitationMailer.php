<?php

namespace AppBundle\Email;

use AppBundle\Entity\Collab;

class InvitationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Collab $collab
     */
    public function sendNewNotification(Collab $collab)
    {
        $date = $collab->getStartedAt();
        foreach ($collab->getUserTo() as $user) {
            $message = new \Swift_Message(
                    'Meetlight - Vous avez reçu une invitation',
                    'Vous avez reçu une invitation de '.$collab->getUserFrom()->getUsername().' pour collaborer le '.$date->format('d/m/Y').'.'
            );

            $message
                    ->addTo($user->getEmail())
                    ->addFrom('contact@meetlight.com');

            $this->mailer->send($message);
        }
    }
}
