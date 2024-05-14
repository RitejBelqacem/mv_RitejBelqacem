<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Pagerfanta\Pagerfanta;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\String\u;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    function homepage(): Response
    {
        $tracks = [
            ['song' => 'Dirty Dirty', 'artist' => 'Charlotte Cardin'],
            ['song' => 'Joublie tout', 'artist' => 'Jul'],
            ['song' => 'Memories', 'artist' => 'Maroon 5'],
            ['song' => 'Avancer', 'artist' => 'Ridsa'],
            ['song' => 'Macarena', 'artist' => 'Tyga'],
            ['song' => 'Mon Bijou', 'artist' => 'Jul'],
        ];
        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'Travail réalisé par Ritej',
            'tracks' => $tracks,
        ]);
    }
    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, Request $request, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        //$mixRepository = $entityManager->getRepository(VinylMix::class);
        //$mixes = $mixRepository->findAll();
        //$mixes = $mixRepository->findBy([], ['votes' => 'DESC']);
        //$mixes = $mixRepository->findAllOrderedByVotes($slug);
        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'pager' => $pagerfanta,
        ]);
    }
}
