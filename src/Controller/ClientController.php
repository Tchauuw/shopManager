<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\MouvementFidelite;
use App\Entity\Vente;
use App\Repository\CarteFideliteRepository;
use App\Repository\ClientRepository;
use App\Repository\MouvementFideliteRepository;
use App\Repository\VenteRepository;
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
        CarteFideliteRepository $carteFideliteR,
        MouvementFideliteRepository $mouvementFideliteR,
        VenteRepository $venteR): Response
    {
        $search = $request->query->get('search');

        $queryClient = $clientR->findByFilters($search);

        $clients = $paginator->paginate(
            $queryClient,
            $request->query->getInt('page', 1),
            5
        );    

        $queryVente = $entityManager
            ->getRepository(Vente::class)
            ->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery();

        $queryClient = $clientR->findAllOrderedById();

        /* Clients */
        $totalClients = $clientR->clientsCount();
        $newClients = $clientR->newClients();
        $findLoyalClients = $clientR->findLoyalClients();
        $count = count($findLoyalClients);
        $percentClient = ($count/$totalClients) * 100;

        /* Ventes */
        $ventes = $queryVente->getResult();
        $totalSales = $venteR->totalSales();
        $salesThisMonth = $venteR->salesThisMonth();


        /* Points fidélités */
        $loyalty = $carteFideliteR->loyaltyPoints();

        /* Mouvements fidélités */
        $thisMonth = $mouvementFideliteR->moveThisMonth();

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
            'totalSales' => $totalSales,
            'salesThisMonth' => $salesThisMonth,
        ]);
    }
}
