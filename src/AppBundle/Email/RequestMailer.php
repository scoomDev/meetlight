<?php

namespace AppBundle\Email;

use AppBundle\Entity\CollabRequest;
use AppBundle\Entity\User;

class RequestMailer
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
     * @param CollabRequest $collabRequest
     * @param User          $user
     */
    public function sendNewNotification(CollabRequest $collabRequest, User $user)
    {
        $date = $collabRequest->getCollab()->getStartedAt();

        $status = "";
        if ($collabRequest->getIsAccepted()) {
            $status = "accepté";
        } else {
            $status = "refusé";
        }

        $message = new \Swift_Message(
                'Meetlight - '.$user->getUsername().' a '.$status.' votre invitation',
                $user->getUsername().' à '.$status.' votre invitation pour la collabration du '.$date->format('d/m/Y').'.'
        );

        $message
                ->addTo($collabRequest->getCollab()->getUserFrom()->getEmail())
                ->addFrom('contact@meetlight.com');

        $this->mailer->send($message);
    }
}
