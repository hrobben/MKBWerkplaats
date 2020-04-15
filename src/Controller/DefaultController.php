<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\QuestionRepository;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
//   public function index()
//    {
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);
//   }
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }
}
