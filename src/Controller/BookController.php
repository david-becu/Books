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
function getBookList(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
    $bookList = $bookRepository->findAll();
    $jsonBookList = $serializer->serialize($bookList, 'json');
    return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
}

// #[Route('/api/books/{id}', name:'detailBook', methods:['GET'])]
// function getDetailBook(int $id, BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
//     {
//     $book = $bookRepository->find($id);
//     if ($book) {
//         $jsonBook = $serializer->serialize($book, 'json');
//         return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
//     }
//     return new JsonResponse(null, Response::HTTP_NOT_FOUND);
// }

#[Route('/api/books/{id}', name:'detailBook', methods:['GET'])]
function getDetailBook(Book $book, SerializerInterface $serializer): JsonResponse
    {
    $jsonBook = $serializer->serialize($book, 'json');
    return new JsonResponse($jsonBook, Response::HTTP_OK, ['accept' => 'json'], true);
}

}
