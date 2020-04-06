<?php

namespace App\Controller;

use App\Entity\ReadMore;
use App\Form\ReadMoreType;
use App\Repository\ReadMoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/read/more")
 */
class ReadMoreController extends AbstractController
{
    /**
     * @Route("/", name="read_more_index", methods={"GET"})
     */
    public function index(ReadMoreRepository $readMoreRepository): Response
    {
        return $this->render('read_more/index.html.twig', [
            'read_mores' => $readMoreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="read_more_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $readMore = new ReadMore();
        $form = $this->createForm(ReadMoreType::class, $readMore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($readMore);
            $entityManager->flush();

            return $this->redirectToRoute('read_more_index');
        }

        return $this->render('read_more/new.html.twig', [
            'read_more' => $readMore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read_more_show", methods={"GET"})
     */
    public function show(ReadMore $readMore): Response
    {
        return $this->render('read_more/show.html.twig', [
            'read_more' => $readMore,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="read_more_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReadMore $readMore): Response
    {
        $form = $this->createForm(ReadMoreType::class, $readMore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('read_more_index');
        }

        return $this->render('read_more/edit.html.twig', [
            'read_more' => $readMore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read_more_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReadMore $readMore): Response
    {
        if ($this->isCsrfTokenValid('delete'.$readMore->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($readMore);
            $entityManager->flush();
        }

        return $this->redirectToRoute('read_more_index');
    }
}
