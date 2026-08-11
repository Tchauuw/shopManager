<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\MouvementFidelite;
use App\Entity\Vente;
use App\Repository\CarteFideliteRepository;
use App\Repository\ClientRepository;
use App\Repository\MouvementFideliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/admin/clients', name: 'app_client')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $entityManager,
        ClientRepository $clientR,
        CarteFideliteRepository $carteFidelite,
        MouvementFideliteRepository $mouvementFidelite): Response
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

        /* Clients */
        $totalClients = $clientR->clientsCount();
        $newClients = $clientR->newClients();
        $findLoyalClients = $clientR->findLoyalClients();
        $count = count($findLoyalClients);
        $percentClient = ($count/$totalClients) * 100;

        /* Ventes */
        $ventes = $queryVente->getResult();

        /* Points fidélités */
        $loyalty = $carteFidelite->loyaltyPoints();

        /* Mouvements fidélités */
        $thisMonth = $mouvementFidelite->moveThisMonth();

        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clients,
            'ventes' => $ventes,
            'totalClients' => $totalClients,
            'newClients' => $newClients,
            'loyalClients' => $count,
            'percentClient' => $percentClient,
            'loyalty' => $loyalty,
            'thisMonth' => $thisMonth,
        ]);
    }
}
