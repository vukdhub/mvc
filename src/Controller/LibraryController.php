<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'Library',
        ]);
    }

    //Create
    #[Route('/library/create', name: 'library_create')]
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book1 = new Book();
        $book1->setTitle('Ask the Dust');
        $book1->setIsbn('9780060829642');
        $book1->setAuthor('John Fante');
        $book1->setCover('fante.jpg');

        $book2 = new Book();
        $book2->setTitle('Post Office');
        $book2->setIsbn('9780061177575');
        $book2->setAuthor('Charles Bukowski');
        $book2->setCover('bukowski.jpg');

        $book3 = new Book();
        $book3->setTitle('The Old Man and the Sea');
        $book3->setIsbn('9780684801223');
        $book3->setAuthor('Ernest Hemingway');
        $book3->setCover('ernest.jpg');

        $entityManager->persist($book1);
        $entityManager->persist($book2);
        $entityManager->persist($book3);
        $entityManager->flush();

        return $this->redirectToRoute('library');
    }

    //View
    #[Route('/library/view', name: 'library_view')]
    public function viewAllProduct(
        BookRepository $productRepository
    ): Response {
        $books = $productRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('library/view.html.twig', $data);
    }

    //Show by ID
    #[Route('/book/view/{id}', name: 'book_by_id')]
    public function showProductById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        return $this->render('library/single.html.twig', [
        'book' => $book
    ]);
    }

    //Adding new book
    #[Route('/library/add', name: 'library_add')]
    public function addBook(ManagerRegistry $doctrine, Request $request): Response
    {
        $book = new Book();

        if ($request->isMethod('POST')) {
            $book->setTitle((string)$request->request->get('title'));
            $book->setAuthor((string)$request->request->get('author'));
            $book->setIsbn((string)$request->request->get('isbn'));
            $book->setCover((string)$request->request->get('cover'));

            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('library_view');
        }

        return $this->render('library/add.html.twig');
    }

    //Updating - editing
    #[Route('/library/edit/{id}', name: 'library_edit')]
    public function edit(
        Book $book,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {

        if ($request->isMethod('POST')) {
            $book->setTitle((string)$request->request->get('title'));
            $book->setAuthor((string)$request->request->get('author'));
            $book->setIsbn((string)$request->request->get('isbn'));
            $book->setCover((string)$request->request->get('cover'));

            $doctrine->getManager()->flush();

            return $this->redirectToRoute('library_view', ['id' => $book->getId()]);
        }

        return $this->render('library/edit.html.twig', [
            'book' => $book
        ]);
    }

    //Delete
    #[Route('/library/delete/{id}', name: 'library_delete')]
    public function delete(Book $book, ManagerRegistry $doctrine): Response
    {
        $delete = $doctrine->getManager();
        $delete->remove($book);
        $delete->flush();

        return $this->redirectToRoute('library_view');
    }

    //API JSON
    #[Route('/api/library/books', name: 'library_json')]
    public function libraryJson(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();

        $data = [];

        foreach ($books as $book) {
            $data[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn(),
                'cover' => $book->getCover(),
            ];
        }

        return new JsonResponse($data);
    }

    //API JSON book by ISBN
    #[Route('/api/library/book/{isbn}', name: 'library_json_isbn')]
    public function libraryJsonIsnb(BookRepository $bookRepository, string $isbn): JsonResponse
    {
        $book = $bookRepository->findOneBy(['Isbn' => $isbn]);

        if (!$book) {
            return $this->json([
                'error' => 'Book not found'
            ], 404);
        }

        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'cover' => $book->getCover(),
        ];

        return new JsonResponse($data);
    }

}
