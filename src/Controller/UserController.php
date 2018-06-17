<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\Impl\UserManager;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 *
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
     * @Route("/{id}", name="user_show", methods="GET")
     * @param User $user
     * @param LoggerInterface $logger
     * @return Response
     */
    public function show(User $user, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Showing user from given id.',
            array('user' => $user->__toString(), 'method' => 'show', 'class' => self::class)
        );
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     * @param User $user
     * @param LoggerInterface $logger
     * @return Response
     */
    public function edit(User $user, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Editing user from given id.',
            array('user' => $user->__toString(), 'method' => 'edit', 'class' => self::class)
        );
        return $this->render('user/edit.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     * @param Request $request
     * @param User $user
     * @param LoggerInterface $logger
     * @param UserManager $manager
     * @return Response
     */
    public function delete(Request $request, User $user, LoggerInterface $logger, UserManager $manager): Response
    {
        $logger->debug(
            'Deleting user from given id.',
            array('user' => $user->__toString(), 'method' => 'delete', 'class' => self::class)
        );

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $logger->debug(
                'Csrf token is valid.',
                array('user' => $user->__toString(), 'method' => 'delete', 'class' => self::class)
            );
            $manager->removeEntity($user);
        }

        return $this->redirectToRoute('user_index');
    }
}
