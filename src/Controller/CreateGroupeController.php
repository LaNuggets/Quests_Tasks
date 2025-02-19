<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\GroupeType;
use App\Entity\Groupe;



final class CreateGroupeController extends AbstractController
{
    #[Route('/create/groupe', name: 'app_create_groupe')]
    public function index(Request $request): Response
    {
        $groupe = new Groupe();
        $groupeForm = $this->createForm(GroupeType::class, $groupe);
        $groupeForm->handleRequest($request);

        if($groupeForm->isSubmitted() && $groupeForm->isValid())
        {
            dump($request->request->all());
        }
        
        return $this->render('create_groupe/index.html.twig', [
            'groupeForm' => $groupeForm->createView()
        ]);
    }
}
