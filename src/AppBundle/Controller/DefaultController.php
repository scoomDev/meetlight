<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function Sodium\compare;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction() : Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_registration_register');
        }
        return $this->render('app/index.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchBarAction(Request $request) : Response
    {
        $searchBar_form = $this->createForm('AppBundle\Form\SearchFormType');
        $searchBar_form->handleRequest($request);

        return $this->render('app/inc/searchBar.html.twig', ['searchBar_form' => $searchBar_form->createView()]);
    }

    /**
     * @Route("/search-result", name="searchResult")
     * @param Request $request
     *
     * @return Response
     */
    public function searchResultAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $place = $request->request->get('search_form')['place'];
        $town = $request->request->get('search_form')['town'];
        $keyword = $request->request->get('search_form')['search'];
        $skillId = $request->request->get('search_form')['skill'];
        $requestedDistance = $request->request->get('search_form')['distance'];

        $actualUser = $this->getUser();
        $lat = $actualUser->getLat();
        $lng = $actualUser->getLng();

        switch ($place) {
            case 'town':
                $usersList = $em->getRepository('AppBundle:User')->findUserByTown($town, $keyword, $skillId);
                break;
            case 'around':
                $usersList = $em->getRepository('AppBundle:User')->findUserByDistance($keyword, $skillId, $lat, $lng, $requestedDistance);
                break;
            default:
                $usersList = $em->getRepository('AppBundle:User')->findUserByKeyword($keyword, $skillId);
        }

        $skill = $em->getRepository('AppBundle:Skill')->findOneBy(['id' => $skillId]);
        return $this->render('app/search-results.html.twig', ['usersList' => $usersList, 'keyword' => $keyword, 'skill' => $skill]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/edit-gallery", name="gallery")
     */
    public function editGalleryAction(Request $request) : Response
    {
        $form = $this->createForm('AppBundle\Form\UploadType')->handleRequest($request);
        return $this->render('app/edit-gallery.html.twig', [
                'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/upload-gallery", name="upload")
     */
    public function uploadAction(Request $request) : JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $root = $this->getParameter('kernel.project_dir');
            $imagePath = '\web\images\gallery\\';
            $imageName = uniqid($prefix = "ml_gallery_");

            move_uploaded_file($request->files->get('file'), $root.$imagePath.$imageName.'.jpg');
            return new JsonResponse('ok', 200);
        }
        return new JsonResponse('error', 500);
    }
}
