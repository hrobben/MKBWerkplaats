<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Entity\Question;
use App\Form\SurveyType;
use App\Repository\SurveyRepository;
use App\Repository\QuestionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/survey")
 * @IsGranted("ROLE_ADMIN")
 */
class SurveyController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="survey_index", methods={"GET"})
     */
    public function index(SurveyRepository $surveyRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('survey/index.html.twig', [
                'surveys' => $surveyRepository->findAll(),
            ]);
        } else {
            return $this->redirectToRoute('survey_fill', ['id' => 1]);
        }
    }

    /**
     * @Route("/new", name="survey_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $survey = new Survey();
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($survey);
            $entityManager->flush();

            return $this->redirectToRoute('survey_index');
        }

        return $this->render('survey/new.html.twig', [
            'survey' => $survey,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="survey_show", methods={"GET"})
     */
    public function show(Survey $survey): Response
    {
        return $this->render('survey/show.html.twig', [
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/{id}", name="survey_fill")
     */
    public function fillsurvey($id, Request $request, QuestionRepository $questionRepository, SurveyRepository $surveyRepository){
        $active = $surveyRepository->findBy(['Active' => true]);

        if ($id < 1) {
            return $this->redirectToRoute('form', ['id' => 1]);
        }

        $questions = $questionRepository->findBy(['Survey' => $active[0]->getId()]);

        if (empty($questions[$id - 1])) {
            return $this->redirectToRoute('fos_user_registration_register');
        }

        return $this->render('survey/fillsurvey.html.twig', [
            'id' => $id,
            'questions' => $questions,
            'question' => $questions[$id - 1],
        ]);
    }

    /**
     * @Route("/{id}/active", name="survey_active", methods={"GET","POST"})
     */
    public function active(Survey $survey, SurveyRepository $surveyRepository)
    {
        $active = $surveyRepository->findBy(['Active' => true]);
        
        $active[0]->setActive(false);
        $survey->setActive(true);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('survey_index');
    }

    /**
     * @Route("/{id}/edit", name="survey_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Survey $survey): Response
    {
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('survey_index');
        }

        return $this->render('survey/edit.html.twig', [
            'survey' => $survey,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="survey_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Survey $survey): Response
    {
        if ($this->isCsrfTokenValid('delete'.$survey->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($survey);
            $entityManager->flush();
        }

        return $this->redirectToRoute('survey_index');
    }
}
