<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            if ( $this->getParameter('env_parameter') == "dev" ) {
                dump($contactFormData);  // for debug info
            } else {
                $message = (new \Swift_Message('You Got Mail from ' . $contactFormData['name']))
                    ->setFrom($contactFormData['e-mail'])
                    ->setReplyTo($contactFormData['e-mail'])
                    ->setTo($this->getParameter('mail_parameter'))
                    ->setBody(
                        $contactFormData['message'],
                        'text/plain'
                    );
                $mailer->send($message);

            }
            return $this->render('contact/index.html.twig', [
                'our_form' => null,
            ]);
        }


        return $this->render('contact/index.html.twig', [
                'our_form' => $form->createView(),
            ]);
        }
}
