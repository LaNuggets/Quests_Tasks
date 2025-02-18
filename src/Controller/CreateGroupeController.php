<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\GroupeType;


final class CreateGroupeController extends AbstractController
{
    #[Route('/create/groupe', name: 'app_create_groupe')]
    public function index(): Response
    {

        $groupeForm = $this->createForm(GroupeType::class);
        
        return $this->render('/createGroupe.html.twig', [
            'groupeForm' => $groupeForm->createView()
        ]);
    }
}
