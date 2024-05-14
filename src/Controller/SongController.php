<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/songs/{id<\d+>}', methods: ['GET'], name: 'api_songs_get_one')]
    function getSong(int $id): Response
    {

        $songs = [
            1 => [
                'id' => 1,
                'name' => 'Dirty',
                'url' => '/songs/Charlotte Cardin - Dirty Dirty [Official Music Video].mp3',
            ],
            2 => [
                'id' => 2,
                'name' => 'Joublie tout',
                'url' => '/songs/Jul - Joublie tout [Son Officiel].mp3',
            ],
            3 => [
                'id' => 3,
                'name' => 'Memories',
                'url' => '/songs/Maroon_5_-_Memories_Official_Video.mp3',
            ],
            4 => [
                'id' => 4,
                'name' => 'Avancer',
                'url' => '/songs\Ridsa - Avancer [Clip].mp3',
            ],
            5 => [
                'id' => 5,
                'name' => 'Memories',
                'url' => '/songs/Maroon_5_-_Memories_Official_Video.mp3',
            ],
            6 => [
                'id' => 6,
                'name' => 'Mon Bijou',
                'url' => '/songs\JUL - MON BIJOU    CLIP OFFICIEL    2016.mp3',
            ],
        ];
        return $this->json($songs[$id]);
    }
}
