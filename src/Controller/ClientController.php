<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Vente;
use App\Form\ClientType;
use App\Repository\CarteFideliteRepository;
use App\Repository\ClientRepository;
use App\Repository\MouvementFideliteRepository;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/admin/clients', name: 'admin_clients')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $entityManager,
        ClientRepository $clientR,
        CarteFideliteRepository $carteFideliteR,
        MouvementFideliteRepository $mouvementFideliteR,
        VenteRepository $venteR): Response
    {
        $searchFilter = $request->query->get('search');
        $newsletterFilter = $request->query->get('newsletter');
        $cityFilter = $request->query->get('city');

        $allowedLimits = [10, 50, 100, 250, 500, 1000];

        $limit = $request->query->getInt('limit', 10);

        if(!in_array($limit, $allowedLimits, true)) {
            $limit = 10;
        }

        $queryClient = $clientR->findByFilters(
            $searchFilter,
            $newsletterFilter,
            $cityFilter
            );

        $clients = $paginator->paginate(
            $queryClient,
            $request->query->getInt('page', 1),
            $limit
        );    

        $queryVente = $entityManager
            ->getRepository(Vente::class)
            ->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery();

        $queryClient = $clientR->findByFilters();

        /* Clients */
        $totalClients = $clientR->clientsCount();
        $newClients = $clientR->newClients();
        $findLoyalClients = $clientR->findLoyalClients();
        $count = count($findLoyalClients);
        $percentClient = ($count/$totalClients) * 100;
        $findAllCities = $clientR->findAllCities();

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
            'cities' => $findAllCities,
            'allowedLimits' => $allowedLimits,
            'pageLimit' => $limit,
        ]);
    }

    #[Route('/admin/clients/add', name:'admin_clients_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();
            return $this-> redirectToRoute('admin_clients', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clients/add.html.twig', [
            'client' => $client,
            'formClientAdd' => $form,
        ]);
    }

    #[Route('/admin/clients/export', name:'admin_clients_export')]
    public function export(ClientRepository $clientR): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($clientR) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Nom',
                'Prenom',
                'Date de naissance',
                'Téléphone',
                'E-mail',
                'Adresse',
                'Code postal',
                'Ville',
                'Complément d\'adresse',
                'Pays',
                'Date de création',
                'Newsletter',
                'ID de carte fidélité',
            ], ';');

        foreach ($clientR->findAll() as $client) {
            fputcsv($handle, [
                $client->getId(),
                $client->getNom(),
                $client->getPrenom(),
                $client->getDateNaissance()?->format('d/m/Y'),
                $client->getTelephone(),
                $client->getEmail(),
                $client->getAdresse(),
                $client->getCodePostal(),
                $client->getVille(),
                $client->getComplementAdresse(),
                $client->getPays(),
                $client->getDateCreation()?->format('d/m/Y'),
                $client->isNewsletter(),
                $client->getCarteFidelite()?->getId(),
            ], ';');
        }

        fclose($handle);
        });

        $response->headers->set(
            'Content-Type',
            'text/csv; charset=UTF-8'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename=clients_' . date('dmy_his') . '.csv'
        );

        return $response;
    }
}