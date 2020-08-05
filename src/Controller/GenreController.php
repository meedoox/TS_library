<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\AddGenreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="genres")
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
            'genres' => $genres,
            'active' => 'genres'
        ]);
    }


    /**
     * @Route("/admin/genre", name="admin_genres")
     */
    public function adminGenreList()
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findBy(
                [],
                ['name' => 'ASC']
            );

        return $this->render('genre/admin_list.html.twig', [
            'genres' => $genres,
            'active' => 'genres'
        ]);
    }


    /**
     * @Route("/remove/genre/{id}", name="remove_genre")
     */
    public function removeGenre(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $genre = $entityManager->getRepository(Genre::class)->find($id);
        if($genre) {
            $entityManager->remove($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_genres');
    }

    /**
     * @Route("/admin/add/genre", name="add_genre")
     */
    public function addGenre(Request $request)
    {
        $genre = new Genre();

        $form = $this->createForm(AddGenreType::class, $genre);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_genres');
        }


        return $this->render('genre/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit/genre/{id}", name="edit_genre")
     */
    public function editGenre(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $genre = $entityManager->getRepository(Genre::class)->find($id);

        $form = $this->createForm(AddGenreType::class, $genre);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_genres');
        }


        return $this->render('genre/add.html.twig', [
            'form' => $form->createView(),
            'genre' => $genre
        ]);
    }
}
