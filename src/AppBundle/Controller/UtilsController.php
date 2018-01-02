<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Collab;
use AppBundle\Entity\CollabRequest;
use AppBundle\Entity\Image;
use AppBundle\Entity\Note;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 *
 * @package AppBundle\Controller
 * @Route("/utils")
 */
class UtilsController extends Controller
{
    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/crop-img", name="cropImg")
     */
    public function cropImgAction(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $data = $request->getContent();
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
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

    /**
     * @Route("/create-collab", name="create_collab")
     * @param Request $request
     *
     * @return Response
     */
    public function createCollabAction(Request $request): Response
    {
        $collab = new Collab();

        $collabForm = $this->createForm('AppBundle\Form\CollabType', $collab)->handleRequest($request);

        if ($collabForm->isSubmitted() && $collabForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $usersGuest = $request->request->get('userTab')['userTo'];

            $usersTab = [];
            foreach ($usersGuest as $user) {
                $usersTab[] = $em->getRepository('AppBundle:User')->find($user);
            }

            // Set CollabRequest
            $collab->setUserFrom($this->getUser());
            foreach ($usersTab as $user) {
                $collab->addUserTo($user);

                $collabRequest = new CollabRequest();
                $collabRequest->setCollab($collab);
                $collabRequest->setUser($user);
                $em->persist($collabRequest);
            }

            // Set note
            $usersTab[] = $this->getUser();
            foreach ($usersTab as $user) {
                foreach ($usersTab as $usr) {
                    if ($usr != $user) {
                        $note = new Note();
                        $note->setCollab($collab);
                        $note->setUserFrom($user);
                        $note->setUser($usr);
                        $note->setStatus(false);
                        $em->persist($note);
                    }
                }
            }

            $em->persist($collab);
            $em->flush();

            $this->addFlash('success', 'La collaboration à bien été créé');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('app/create-collab.html.twig', [
                'collabForm' => $collabForm->createView(),
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
     * @return Response
     * @Route("/edit-gallery", name="gallery")
     */
    public function editGalleryAction(): Response
    {
        return $this->render('app/edit-gallery.html.twig');
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/remove-image/{id}", name="removeImage")
     */
    public function removeImageAction($id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->findOneBy(['id' => $id]);

        if (!$image) {
            $this->addFlash('danger',
                    'Il y a eu une erreur lors de la suppression, veuillez réessayer ou nous contacter, merci');

            return $this->redirectToRoute('gallery');
        }

        $root = $this->getParameter('kernel.project_dir');
        unlink($root.$image->getImagePath().$image->getImageName());


        $em->remove($image);
        $em->flush();

        return $this->redirectToRoute('gallery');
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return RedirectResponse
     * @Route("/edit-alt/{id}", name="editAlt")
     */
    public function editImageAltAction(Request $request, $id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->findOneBy(['id' => $id]);

        if (!$image) {
            $this->addFlash('danger',
                    'Il y a eu une erreur de l\'édition, veuillez réessayer ou nous contacter, merci');

            return $this->redirectToRoute('gallery');
        }

        $alt = $request->request->get('alt');
        $image->setImageAlt($alt);

        $em->persist($image);
        $em->flush();

        return $this->redirectToRoute('gallery');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/upload-gallery", name="upload")
     */
    public function uploadAction(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $username = $user->getUsername();
            $imageFile = $request->files->get('file');

            $root = $this->getParameter('kernel.project_dir');
            $imagePath = '\web\images\gallery\\';
            $imageName = uniqid($prefix = "ml_gallery_".$username."_");

            if ($user) {
                $image = new Image();
                $image->setImageName($imageName.'.jpg');
                $image->setImagePath($imagePath);
                $image->setImageAlt('Photo de : '.$user->getUsername());
                $image->setImageSize($imageFile->getSize());
                $image->setUser($user);

                $em->persist($image);
                $em->flush();
            }

            move_uploaded_file($imageFile, $root.$imagePath.$imageName.'.jpg');

            return new JsonResponse('ok', 200);
        }

        return new JsonResponse('error', 500);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/accept-request/{id}", name="acceptRequest")
     */
    public function acceptRequestAction($id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $collabRequest = $em->getRepository('AppBundle:CollabRequest')->find($id);
        $collabRequest->setIsAccepted(true);

        $em->persist($collabRequest);
        $em->flush();

        $mailer = $this->container->get('app_bundle.email.request_mailer');
        $mailer->sendNewNotification($collabRequest, $collabRequest->getUser());

        $this->addFlash('success', 'L\'invitation à bien été accepté');

        $invitations = $em->getRepository('AppBundle:CollabRequest')->findInvitation($user->getId());
        if (count($invitations) > 0) {
            return $this->redirectToRoute('showRequest');
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/refuse-request/{id}", name="refuseRequest")
     */
    public function refuseRequestAction($id): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $collabRequest = $em->getRepository('AppBundle:CollabRequest')->find($id);
        $collabRequest->setIsRefused(true);

        $em->persist($collabRequest);
        $em->flush();

        $mailer = $this->container->get('app_bundle.email.request_mailer');
        $mailer->sendNewNotification($collabRequest, $collabRequest->getUser());

        $this->addFlash('success', 'L\'invitation à bien été refusé');

        $invitations = $em->getRepository('AppBundle:CollabRequest')->findInvitation($user->getId());
        if (count($invitations) > 0) {
            return $this->redirectToRoute('showRequest');
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/set-note", name="setNote")
     */
    public function setNote(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $noteId = $request->request->get('noteId');
            $noteContent = $request->request->get('note');
            $commentContent = $request->request->get('comment');

            $em = $this->getDoctrine()->getManager();
            $note = $em->getRepository('AppBundle:Note')->find($noteId);
            $collab = $em->getRepository('AppBundle:Collab')->findOneById($note->getCollab()->getId());
            $collabNote = $em->getRepository('AppBundle:Note')->getNotesNotNull($collab->getId());

            if (!empty($collabNote)) {
                $notes = [];
                for ($i = 0; $i < count($collabNote); $i++) {
                    $notes[] = $collabNote[$i]['note'];
                }
                $average = (array_sum($notes) + $noteContent) / (count($notes) + 1);
            } else {
                $average = $noteContent;
            }
            $collab->setAverageRating($average);

            $note->setNote($noteContent);
            if (!empty($commentContent)) {
                $note->setComment($commentContent);
            }
            $note->setStatus(true);

            $em->persist($collab);
            $em->persist($note);
            $em->flush();

            return new JsonResponse('ok', 200);
        }
        return new JsonResponse('error', 500);
    }
}