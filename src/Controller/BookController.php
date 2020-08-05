<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddBookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="books")
     */
    public function index(Request $request)
    {
        $filter = $request->query->get('filter');
        $authorId = $request->query->get('author');
        $genreId = $request->query->get('genre');

        if($filter == "true" && $authorId) {
            $books = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findByAuthor($authorId);

        } elseif ($filter == "true" && $genreId) {
            $books = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findByGenre($genreId);

        } else {
            $books = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findAll();
        }

        usort($books, function($a, $b) {return $a->getCreatedAt() > $b->getCreatedAt();});

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'active' => 'books'
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


    /**
     * @Route("/admin/book", name="admin_books")
     */
    public function adminBookList()
    {
        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        usort($books, function($a, $b) {return $a->getCreatedAt() > $b->getCreatedAt();});

        return $this->render('book/admin_list.html.twig', [
            'books' => $books,
            'active' => 'books'
        ]);
    }


    /**
     * @Route("/remove/book/{id}", name="remove_book")
     */
    public function removeBook(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        if($book) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_books');
    }

    /**
     * @Route("/admin/add/book", name="add_book")
     */
    public function addBook(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(AddBookType::class, $book);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $book->setCreatedAt(new \DateTime());
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin_books');
        }


        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit/book/{id}", name="edit_book")
     */
    public function editBook(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $form = $this->createForm(AddBookType::class, $book);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin_books');
        }


        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }


}
