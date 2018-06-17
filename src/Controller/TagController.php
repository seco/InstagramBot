<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Manager\Impl\TagManager;
use App\Repository\TagRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController
 * @package App\Controller
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 *
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tag_index", methods="GET")
     * @param TagRepository $tagRepository
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(TagRepository $tagRepository, LoggerInterface $logger): Response
    {
        $logger->debug('Returning tag entities.', array('method' => 'index', 'class' => self::class));
        return $this->render('tag/index.html.twig', ['tags' => $tagRepository->findAll()]);
    }

    /**
     * @Route("/new", name="tag_new", methods="GET|POST")
     * @param Request $request
     * @param LoggerInterface $logger
     * @param TagManager $manager
     * @return Response
     */
    public function new(Request $request, LoggerInterface $logger, TagManager $manager): Response
    {
        $logger->debug('Request for a new tag entity.', array('method' => 'new', 'class' => self::class));
        $tag = $manager->createEntity();

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->debug(
                'Form is submitted and valid.',
                array('tag' => $tag->getLabel(), 'method' => 'new', 'class' => self::class)
            );
            $manager->saveEntity($tag);
            return $this->redirectToRoute('tag_index');
        }

        $logger->debug('Form is not submitted. Rendering template.', array('method' => 'new', 'class' => self::class));
        return $this->render('tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tag_show", methods="GET")
     * @param Tag $tag
     * @param LoggerInterface $logger
     * @return Response
     */
    public function show(Tag $tag, LoggerInterface $logger): Response
    {
        $logger->debug(
            'Showing tag from given id.',
            array('tag' => $tag->getLabel(), 'method' => 'show', 'class' => self::class)
        );
        return $this->render('tag/show.html.twig', ['tag' => $tag]);
    }

    /**
     * @Route("/{id}/edit", name="tag_edit", methods="GET|POST")
     * @param Request $request
     * @param Tag $tag
     * @param LoggerInterface $logger
     * @param TagManager $manager
     * @return Response
     */
    public function edit(Request $request, Tag $tag, LoggerInterface $logger, TagManager $manager): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        $logger->debug(
            'Editing tag from given id.',
            array('tag' => $tag->getLabel(), 'method' => 'edit', 'class' => self::class)
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->debug(
                'Form is submitted and valid.',
                array('tag' => $tag->getLabel(), 'method' => 'edit', 'class' => self::class)
            );
            $manager->saveEntity($tag);
            return $this->redirectToRoute('tag_index');
        }

        $logger->debug(
            'Form is not submitted. Rendering template.',
            array('tag' => $tag->getLabel(), 'method' => 'edit', 'class' => self::class)
        );
        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tag_delete", methods="DELETE")
     * @param Request $request
     * @param Tag $tag
     * @param LoggerInterface $logger
     * @param TagManager $manager
     * @return Response
     */
    public function delete(Request $request, Tag $tag, LoggerInterface $logger, TagManager $manager): Response
    {
        $logger->debug(
            'Deleting tag from given id.',
            array('tag' => $tag->getLabel(), 'method' => 'delete', 'class' => self::class)
        );

        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $logger->debug(
                'Csrf token is valid.',
                array('tag' => $tag->getLabel(), 'method' => 'delete', 'class' => self::class)
            );
            $manager->removeEntity($tag);
        }

        return $this->redirectToRoute('tag_index');
    }
}
