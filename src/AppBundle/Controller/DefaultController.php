<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $keyword = $request->request->get('search_form')['search'];
        $skillId = $request->request->get('search_form')['skill'];
        $requestedDistance = $request->request->get('search_form')['distance'];

        $actualUser = $this->getUser();
        $lat = $actualUser->getLat();
        $lng = $actualUser->getLng();
        $usersList = $em->getRepository('AppBundle:User')->findUserByDistance($keyword, $skillId, $lat, $lng, $requestedDistance);

        $skill = $em->getRepository('AppBundle:Skill')->findOneBy(['id' => $skillId]);
        return $this->render('app/search-results.html.twig', ['usersList' => $usersList, 'keyword' => $keyword, 'skill' => $skill]);
    }
}
