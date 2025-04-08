<?php

namespace App\Controller\Admin;

use App\Entity\Iceberg;
use App\Form\IcebergType;
use App\Repository\IcebergRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/admin/iceberg", name:'admin.iceberg.')]
class IcebergController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(IcebergRepository $repository): Response // Les objets
    {
        $icebergs = $repository->findAll(); // findAll permet de prendre tous les enregistrements en paramètre
        return $this->render('admin/iceberg/index.html.twig', [ // Envoyer au fichier .twig
            'iceberg' => $icebergs // Donner la liste des icebergs
        ]);     
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $iceberg = new Iceberg();
        $form = $this->createForm(IcebergType::class, $iceberg);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($iceberg);
            $em->flush(); // Sauvegarder les changements dès que le formulaire est soumis
            $this->addFlash('success', 'L`iceberg a été créé');
            return $this->redirectToRoute('admin.iceberg.index'); // Retourne vers iceberg.index (la page principale de l'onglet Icebergs)
        }
        return $this->render('admin/iceberg/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name:'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Iceberg $iceberg, Request $request, EntityManagerInterface $em){ // EntityManagerInterface $em : Sauvegarder les modifications faites au niveau d'une entité
        $form = $this->createForm(IcebergType::class, $iceberg); //Créer le formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush(); // Sauvegarder les changements dès que le formulaire est soumis
            $this->addFlash('success', 'L`iceberg a été modifié');
            return $this->redirectToRoute('admin.iceberg.index');
        }
        return $this->render('admin/iceberg/edit.html.twig', [ // Prendre en paramètre iceberg et le formulaire
            'iceberg' => $iceberg,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: 'delete', methods:['DELETE'], requirements: ['id' => Requirement::DIGITS])] // Une route qu'on pourra appeler uniquement avec la méthode
    public function remove(Iceberg $iceberg, EntityManagerInterface $em)
    {
        $em->remove($iceberg);
        $em->flush();
        $this->addFlash('success', 'L`iceberg a bien été supprimé');
        return $this->redirectToRoute('admin.iceberg.index'); 
    }
}
