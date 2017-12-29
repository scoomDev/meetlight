<?php

namespace AppBundle\DoctrineListener;

use AppBundle\Email\Mailer;
use AppBundle\Entity\Collab;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CollabCreationListener
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Collab) {
            return;
        }

        $this->mailer->sendNewNotification($entity);
    }
}