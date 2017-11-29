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
    public function navbarAction(Request $request) : Response
    {
        $searchForm = $this->createForm('AppBundle\Form\SearchFormType');
        $searchForm->handleRequest($request);

        return $this->render('app/inc/navbar.html.twig', ['searchForm' => $searchForm->createView()]);
    }

    /**
     * @Route("/search-result", name="searchResult")
     * @return Response
     */
    public function searchResultAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $keyword = $request->request->get('search_form')['search'];
        $usersList = $em->getRepository('AppBundle:User')->findUserByKeyword($keyword);

        return $this->render('app/search-results.html.twig', ['usersList' => $usersList, 'keyword' => $keyword]);
    }
}
