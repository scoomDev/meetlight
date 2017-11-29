<?php

namespace AppBundle\Controller;

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
     * @return JsonResponse
     * @Route("/crop-img", name="cropImg")
     */
    public function cropImgAction(Request $request) : JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById($this->getUser()->getId());

            $data = $request->getContent();
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $root = $this->getParameter('kernel.project_dir');
            $imagePath = '\web\images\profile\\';
            $imageName = uniqid($prefix = "ml_avatar_");


            if ($data) {
                file_put_contents($root.$imagePath.$imageName.'.jpg', $data);
                if ($user->getImageName() && file_exists($root.$imagePath.$user->getImageName())) {
                    if ($user->getImageName() != "default-avatar.jpg") {
                        unlink($root.$imagePath.$user->getImageName());
                    }
                }
                $user->setImageName($imageName.'.jpg');
                $em->persist($user);
                $em->flush();
            }

            return new JsonResponse('ok', 200);
        }
        return new JsonResponse('error', 500);
    }
}
