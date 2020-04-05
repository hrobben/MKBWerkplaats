<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\ReadMore;
use App\Repository\ReadMoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\QuestionRepository;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("defaultreadmore/{id}", name="read_more_default", methods={"GET"})
     */
    public function readmore($id, ReadMoreRepository $readMoreRepository): Response
    {
        $readMore = $readMoreRepository->findOneBy(['id' => $id]);
        //$readMore->setContent(htmlentities($readMore->getContent()));
        return $this->render('default/readmore.html.twig', [
            'read_more' => $readMore,
        ]);
    }

}
