<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/api/books/', name:'books', methods:['GET'])]
function getAllBooks(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
    $bookList = $bookRepository->findAll();
    return $this->json($bookList, $status = 200, $headers = [], ['groups' => 'getBooks']);git add
    // $jsonBookList = $serializer->serialize($bookList, 'json', ['groups'=>'getBooks']);
    // return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
}

#[Route('/api/books/{id}', name:'detailBook', methods:['GET'])]
function getDetailBook(int $id, SerializerInterface $serializer, BookRepository $bookRepository): JsonResponse
    {
    $book = $bookRepository->find($id);
    if ($book) {
        return $this->json($book, $status = 200, $headers = [], ['groups' => 'getBooks']);
        // $jsonBook = $serializer->serialize($book, 'json', ['groups'=>'getBooks']);
        // return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
    }
    return new JsonResponse(null, Response::HTTP_NOT_FOUND);
}

}
