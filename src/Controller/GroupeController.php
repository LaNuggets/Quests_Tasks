<?php

namespace App\Controller;

use App\Entity\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class GroupeController extends AbstractController {
    
    // #[Route('/groupe/', name:'groupe Général')]    
    // public function getIdGroupe($id){
    //     $GroupeId = $id;
    //     return $this->render('groupe.html.twig', ['GroupeId' => $GroupeId]);
    // }
    
    #[Route('/groupe/{id}', name:'groupe spécifique')]
    public function getGroupData(EntityManagerInterface $entityManager, int $id){
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
        
        if (!$groupe) {
            throw $this->createNotFoundException(
                'No group found for id '.$id
            );
        }

        return $this->render('groupe.html.twig', ['NomGroupe' => $groupe->getNom()]);
        //        return new Response('Voici la page du groupe '.$groupe->getNom());
    }
}
