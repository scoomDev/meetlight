<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends Controller
{
    /**
     * @Route("/show-profile", name="showProfile")
     */
    public function showAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $notesList = $em->getRepository('AppBundle:Note')->getProfileNotes($user->getId());

        $note = 0;
        if (count($notesList) != 0) {
            for ($i = 0; $i < count($notesList); $i++) {
                $note += $notesList[$i]->getNote();
            }
            $note = $note / count($notesList);
        }

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Profile/show.html.twig', array(
                'user' => $user,
                'note' => $note
        ));
    }

}
