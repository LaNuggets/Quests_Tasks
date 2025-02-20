<?php

namespace App\Controller;

use App\Entity\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Request;

class GroupeController extends AbstractController {
    
    #[Route('/groupe', name:'app_groupe_connexion')]
    public function getGroupData(EntityManagerInterface $entityManager){
        $user = $this->getUser();
        //        $groupeInvitation = $user.getInvitation();
        //        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
        return $this->render('twig/groupconnexion.html.twig', []);
    }
}
