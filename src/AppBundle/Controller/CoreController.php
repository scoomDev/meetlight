<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Note;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction(): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_registration_register');
        }

        $em = $this->getDoctrine()->getManager();
        $collabsList = $em->getRepository('AppBundle:Collab')->getIndexCollab();

        return $this->render('app/index.html.twig', compact('collabsList'));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchBarAction(Request $request): Response
    {
        $searchBar_form = $this->createForm('AppBundle\Form\SearchFormType');
        $searchBar_form->handleRequest($request);

        return $this->render('app/inc/searchBar.html.twig', ['searchBar_form' => $searchBar_form->createView()]);
    }

    /**
     * @param int $id
     *
     * @return Response
     * @Route("/show-user/{id}", name="showUser")
     */
    public function showUser(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $user = $em->getRepository('AppBundle:User')->showCompleteUser($id, $usr);

        return $this->render('app/show-user.html.twig', compact('user'));
    }

    /**
     * @Route("/users", name="usersJson")
     * @return JsonResponse
     */
    public function userJsonAction(): JsonResponse
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $userList = $repository->findUsersJson();

        return new JsonResponse($userList, 200);
    }

    /**
     * @Route("/search-result", name="searchResult")
     * @param Request $request
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function searchResultAction(Request $request): Response
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
                $usersList = $em->getRepository('AppBundle:User')
                        ->findUserByTown($town, $keyword, $skillId);
                break;
            case 'around':
                $usersList = $em->getRepository('AppBundle:User')
                        ->findUserByDistance($keyword, $skillId, $lat, $lng, $requestedDistance);
                break;
            default:
                $usersList = $em->getRepository('AppBundle:User')
                        ->findUserByKeyword($keyword, $skillId);
        }

        $skill = $em->getRepository('AppBundle:Skill')->findOneBy(['id' => $skillId]);

        return $this->render('app/search-results.html.twig', [
                'usersList' => $usersList,
                'keyword' => $keyword,
                'skill' => $skill,
        ]);
    }

    /**
     * @return Response
     * @Route("show-collab", name="showCollab")
     */
    public function showCollab(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $collabs = $em->getRepository('AppBundle:Collab')->findAllCollab($this->getUser());

        return $this->render('app/show-collab.html.twig', [
                'collabs' => $collabs
        ]);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/validate-collab/{id}", name="validateCollab")
     */
    public function validateCollab($id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('AppBundle:Collab')->find($id);
        $collab->setIsFinished(true);
        $em->persist($collab);
        $em->flush();

        $this->addFlash('success', 'Cette collaboration est noté comme terminé');

        return $this->redirectToRoute('showCollab');
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/cancel-collab/{id}", name="cancelCollab")
     */
    public function cancelCollab($id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('AppBundle:Collab')->find($id);
        $collab->setIsCanceled(true);
        $em->persist($collab);
        $em->flush();

        $this->addFlash('success', 'Cette collaboration est noté comme annulé');

        return $this->redirectToRoute('showCollab');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/invitation", name="invitationJson")
     */
    public function invitationJsonAction(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $invitation = $em->getRepository('AppBundle:CollabRequest')->findInvitation($user->getId());

            return new JsonResponse(count($invitation), 200);
        }

        return new JsonResponse('error', 500);
    }

    /**
     * @return Response
     * @Route("/show-request", name="showRequest")
     */
    public function showRequestAction(): Response
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $invitations = $em->getRepository('AppBundle:CollabRequest')->findUserInvitation($user->getId());

        return $this->render('app/show-request.html.twig', compact('invitations'));
    }


    /**
     * @param $id
     *
     * @return Response
     * @Route("/put-a-note/{id}", name="putANote")
     */
    public function putANoteAction($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('AppBundle:Collab')->find($id);
        $notes = $em->getRepository('AppBundle:Note')->getNotesByCollabWithStatus($collab->getId(), $this->getUser());

        return $this->render('app/put-a-note.html.twig', [
            'collab' => $collab,
            'notes' => $notes
        ]);
    }
}
