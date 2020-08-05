<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="books")
     */
    public function index()
    {
        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        usort($books, function($a, $b) {return $a->getCreatedAt() > $b->getCreatedAt();});

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }


    /**
     * @Route("/book/{id}", name="show_book")
     */
    public function showBook(int $id)
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }

}
