<?php

namespace AppBundle\Controller;

use AppBundle\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AdminController
 *
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/board", name="board")
     * @return Response
     */
    public function indexAction() : Response
    {
        return $this->render('admin/board.html.twig');
    }

    /**
     *
     * @param Request      $request
     *
     * @return RedirectResponse | JsonResponse
     * @Route("/crop-img", name="cropImg")
     */
    public function cropImgAction(Request $request) : RedirectResponse
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById($this->getUser()->getId());

            $data = $request->getContent();
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents($this->getParameter('kernel.project_dir').'\web\images\profile\\'.$this->getUser()->getUsername().$this->getUser()->getId().'.jpg', $data);

            if ($data) {
                $user->setImageName($this->getUser()->getUsername().$this->getUser()->getId().'.jpg');
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('fos_user_profile_edit');
            }
        }
        $this->addFlash('danger', 'Il y a eu un problème, veuillez recommencer ou contacter le support');
        return $this->redirectToRoute('fos_user_profile_edit');
    }
}
