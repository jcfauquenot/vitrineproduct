<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FormulaireController extends AbstractController
{
    /**
     * @Route("/formulaire", name="formulaire")
     */
    public function formulaire(Request $request)
    {
        $formulaire = new Formulaire();
        $form = $this->createForm(FormulaireType::class, $formulaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
        $formulaire = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formulaire);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Merci votre message a bien été envoyé'
        );

        return $this->redirectToRoute('formulaire');

        }

        /* dump($form);die;*/
        return $this->render('formulaire/formulaire.html.twig', [
            'forme' => $form->createView(),
        ]);
    }
}
