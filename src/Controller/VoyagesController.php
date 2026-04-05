<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Description of VoyagesController
 *
 * @author marce
 */
class VoyagesController extends AbstractController{
    
    #[Route('/voyages', name: 'voyages')]
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');

        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }
    
    #[Route('/voyages/tri/{champ}/{ordre}', name: 'voyages.sort')]
    public function sort($champ, $ordre): Response {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);

        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }
    
    #[Route('/voyages/recherche/{champ}', name: 'voyages.findallequal')]
    public function findAllEqual(string $champ, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('filtre_' . $champ, $request->request->get('_token'))) {
            return $this->redirectToRoute('voyages');
        }

        $valeur = trim((string) $request->request->get('recherche'));
 
        if ($champ === 'environnements') {
            $visites = $valeur === ''
                ? $this->repository->findAllOrderBy('datecreation', 'DESC')
                : $this->repository->findByEnvironnement($valeur);
        } elseif ($champ === 'ville' || $champ === 'pays') {
            $visites = $this->repository->findByEqualValue($champ, $valeur);
        } else {
            return $this->redirectToRoute('voyages');
        }


        return $this->render('pages/voyages.html.twig', [
            'visites' => $visites
        ]);
    }
    
    #[Route('/voyages/voyage/{id}', name: 'voyages.showone')]
    public function showOne($id): Response
    {
        $visite = $this->repository->find($id);
        return $this->render("pages/voyage.html.twig", [
            'visite' => $visite
        ]);
    }



    
    /**
    *
    * @var VisiteRepository
    */
   private $repository;

   /**
    * 
    * @param VisiteRepository $repository
    */
   public function __construct(VisiteRepository $repository) {
       $this->repository = $repository;
   }
   
}