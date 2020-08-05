<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddAuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="authors")
     */
    public function index()
    {
        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();

        foreach ($authors as $author) {
            $name = explode(" ", $author->getLastname());
            $surname = $name[count($name)-1];
            unset($name[count($name)-1]);
            $newName = $surname . ", " . implode(" ", $name);

            $author->setLastname($newName);
        }

        $sort = function ($a, $b){
            static $czechCharsS = array('Á', 'Č', 'Ď', 'É', 'Ě' , 'Ch' , 'Í', 'Ň', 'Ó', 'Ř', 'Š', 'Ť', 'Ú', 'Ů' , 'Ý', 'Ž', 'á', 'č', 'ď', 'é', 'ě' , 'ch' , 'í', 'ň', 'ó', 'ř', 'š', 'ť', 'ú', 'ů' , 'ý', 'ž');
            static $czechCharsR = array('AZ','CZ','DZ','EZ','EZZ','HZZZ','IZ','NZ','OZ','RZ','SZ','TZ','UZ','UZZ','YZ','ZZ','az','cz','dz','ez','ezz','hzzz','iz','nz','oz','rz','sz','tz','uz','uzz','yz','zz');

            $A = str_replace($czechCharsS, $czechCharsR, $a->getLastname());
            $B = str_replace($czechCharsS, $czechCharsR, $b->getLastname());

            return strnatcasecmp($A, $B);
        };

        usort($authors, $sort);

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
            'active' => 'authors'
        ]);
    }


    /**
     * @Route("/admin/author", name="admin_authors")
     */
    public function adminAuthorList()
    {
        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();

        foreach ($authors as $author) {
            $name = explode(" ", $author->getLastname());
            $surname = $name[count($name)-1];
            unset($name[count($name)-1]);
            $newName = $surname . ", " . implode(" ", $name);

            $author->setLastname($newName);
        }

        $sort = function ($a, $b){
            static $czechCharsS = array('Á', 'Č', 'Ď', 'É', 'Ě' , 'Ch' , 'Í', 'Ň', 'Ó', 'Ř', 'Š', 'Ť', 'Ú', 'Ů' , 'Ý', 'Ž', 'á', 'č', 'ď', 'é', 'ě' , 'ch' , 'í', 'ň', 'ó', 'ř', 'š', 'ť', 'ú', 'ů' , 'ý', 'ž');
            static $czechCharsR = array('AZ','CZ','DZ','EZ','EZZ','HZZZ','IZ','NZ','OZ','RZ','SZ','TZ','UZ','UZZ','YZ','ZZ','az','cz','dz','ez','ezz','hzzz','iz','nz','oz','rz','sz','tz','uz','uzz','yz','zz');

            $A = str_replace($czechCharsS, $czechCharsR, $a->getLastname());
            $B = str_replace($czechCharsS, $czechCharsR, $b->getLastname());

            return strnatcasecmp($A, $B);
        };

        usort($authors, $sort);

        return $this->render('author/admin_list.html.twig', [
            'authors' => $authors,
            'active' => 'authors'
        ]);
    }


    /**
     * @Route("/remove/author/{id}", name="remove_author")
     */
    public function removeAuthor(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $author = $entityManager->getRepository(Author::class)->find($id);
        if($author) {
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_authors');
    }


    /**
     * @Route("/admin/add/author", name="add_author")
     */
    public function addAuthor(Request $request)
    {
        $author = new Author();

        $form = $this->createForm(AddAuthorType::class, $author);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin_authors');
        }


        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit/author/{id}", name="edit_author")
     */
    public function editAuthor(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $author = $entityManager->getRepository(Author::class)->find($id);

        $form = $this->createForm(AddAuthorType::class, $author);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin_authors');
        }


        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
            'author' => $author
        ]);
    }
}
