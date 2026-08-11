<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Vente;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/admin/clients', name: 'app_client')]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $queryClient = $entityManager
            ->getRepository(Client::class)
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();

        $queryVente = $entityManager
            ->getRepository(Vente::class)
            ->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery();

        $clients = $paginator->paginate(
            $queryClient,
            $request->query->getInt('page', 1),
            5
        );

        $ventes = $queryVente->getResult();

        

        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clients,
            'ventes' => $ventes,
        ]);
    }
}
