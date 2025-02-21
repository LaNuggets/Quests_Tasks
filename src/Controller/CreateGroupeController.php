<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Datetime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\GroupeType;
use App\Entity\Groupe;


final class CreateGroupeController extends AbstractController
{
    #[Route('/create/groupe', name: 'app_create_groupe')]
    public function index(Request $request, EntityManagerInterface $entityManager,): Response
    {
        $user = $this->getUser();
        $groupe = new Groupe();
        $groupeForm = $this->createForm(GroupeType::class, $groupe);
        $groupeForm->handleRequest($request);
        
        if($groupeForm->isSubmitted() && $groupeForm->isValid())
        {
            $groupe->setChef($user->getPseudo());
            $groupe->setScore(0);
            $groupe->setDateCreation(new DateTime('now'));
            $groupe->addMembreId($this->getUser()->getId());
            $this->getUser()->setGroupe($groupe);
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute('app_habitudes');
        }
        
        return $this->render('create_groupe/index.html.twig', [
            'groupeForm' => $groupeForm->createView(),
        ]);
    }
}
