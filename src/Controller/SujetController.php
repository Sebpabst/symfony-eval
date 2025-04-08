<?php

namespace App\Controller;

use App\Repository\SujetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class SujetController extends AbstractController
{
    #[Route('/sujet', name: 'sujet.index')]
    public function index(Request $request, SujetsRepository $repository): Response
    {
        $sujet = $repository->findAll();
        return $this->render('sujet/index.html.twig', [
            'sujet' => $sujet
        ]);
    }
}
