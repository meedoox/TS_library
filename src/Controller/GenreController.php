<?php

namespace App\Controller;

use App\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="genre")
     */
    public function index()
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findBy(
                [],
                ['name' => 'ASC']
            );

        return $this->render('genre/index.html.twig', [
            'genres' => $genres
        ]);
    }
}
