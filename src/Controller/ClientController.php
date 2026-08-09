<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/admin/clients', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clientRepository->findAll(),
        ]);
    }
}
