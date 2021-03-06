<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * NoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoteRepository extends \Doctrine\ORM\EntityRepository
{
    public function getProfileNotes($id)
    {
        $qb = $this->createQueryBuilder('n')
                ->where('n.user = :id AND n.status = true')
                ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }

    public function getNotesByCollabWithStatus($collabId, $usr): array
    {
        $qb = $this->createQueryBuilder('n')
                ->where('n.collab = :collabId')
                ->setParameter('collabId', $collabId)
                ->andWhere('n.userFrom = :usr')
                ->setParameter('usr', $usr)
                ->leftJoin('n.user', 'usrTo')
                ->addSelect('usrTo');

        return $qb->getQuery()->getResult();
    }

    public function getNotesNotNull($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
                ->select('n.note')
                ->from('AppBundle:Note', 'n')
                ->leftJoin('n.collab', 'collab')
                ->where('collab.id = :id')
                ->andWhere('n.note is not null')
                ->setParameter('id', $id);

        return $qb->getQuery()->getScalarResult();
    }
}
