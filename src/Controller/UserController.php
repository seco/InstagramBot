<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     * @param UserRepository $userRepository
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(UserRepository $userRepository, LoggerInterface $logger): Response
    {
        $logger->debug('Returning user entities.', array('method' => 'index', 'class' => self::class));
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     */
    public function new(Request $request, LoggerInterface $logger): Response
    {
        $logger->debug('Request for a new user entity.', array('method' => 'new', 'class' => self::class));

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->debug(
                'Form is submitted and valid.',
                array('instagram id' => $user->getInstagramId(), 'method' => 'new', 'class' => self::class)
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        $logger->debug('Form is not submitted. Rendering template.', array('method' => 'new', 'class' => self::class));
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     * @param User $user
     * @param LoggerInterface $logger
     * @return Response
     */
    public function show(User $user, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Showing user from given id.',
            array('instagram id' => $user->getInstagramId(), 'method' => 'show', 'class' => self::class)
        );

        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     * @param Request $request
     * @param User $user
     * @param LoggerInterface $logger
     * @return Response
     */
    public function edit(Request $request, User $user, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Editing user from given id.',
            array('instagram id' => $user->getInstagramId(), 'method' => 'edit', 'class' => self::class)
        );

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->debug(
                'Form is submitted and valid.',
                array('instagram id' => $user->getInstagramId(), 'method' => 'edit', 'class' => self::class)
            );

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        $logger->debug(
            'Form is not submitted. Rendering template.',
            array('instagram id' => $user->getInstagramId(), 'method' => 'edit', 'class' => self::class)
        );

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     * @param Request $request
     * @param User $user
     * @param LoggerInterface $logger
     * @return Response
     */
    public function delete(Request $request, User $user, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Deleting user from given id.',
            array('instagram id' => $user->getInstagramId(), 'method' => 'delete', 'class' => self::class)
        );

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $logger->debug(
                'Form is submitted and valid.',
                array('instagram id' => $user->getInstagramId(), 'method' => 'delete', 'class' => self::class)
            );

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        $logger->debug(
            'Form is not submitted, rendering template.',
            array('instagram id' => $user->getInstagramId(), 'method' => 'delete', 'class' => self::class)
        );

        return $this->redirectToRoute('user_index');
    }
}
