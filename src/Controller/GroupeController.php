<?php

namespace App\Controller;

use App\Entity\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Request;

class GroupeController extends AbstractController {
    
    #[Route('/groupe/{id}', name:'groupe spécifique')]
    public function getGroupData(EntityManagerInterface $entityManager, int $id){
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
        
        if (!$groupe) {
            throw $this->createNotFoundException(
                'No group found for id '.$id
            );
        }

        return $this->render('groupe.html.twig', ['NomGroupe' => $groupe->getNom()]);
    }
}
