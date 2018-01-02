<?php

namespace AppBundle\DoctrineListener;

use AppBundle\Email\InvitationMailer;
use AppBundle\Entity\Collab;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CollabCreationListener
{
    private $invitationMailer;

    public function __construct(InvitationMailer $invitationMailer)
    {
        $this->invitationMailer = $invitationMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Collab) {
            return;
        }

        $this->invitationMailer->sendNewNotification($entity);
    }
}