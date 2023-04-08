<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController {
    #[ Route( '/api/books/', name:'books', methods:[ 'GET' ] ) ]

    function getAllBooks( BookRepository $bookRepository, SerializerInterface $serializer ): JsonResponse {
        $bookList = $bookRepository->findAll();
        return $this->json( $bookList, $status = 200, $headers = [], [ 'groups' => 'getBooks' ] );
        // $jsonBookList = $serializer->serialize( $bookList, 'json', [ 'groups'=>'getBooks' ] );
        // return new JsonResponse( $jsonBookList, Response::HTTP_OK, [], true );
    }

    #[ Route( '/api/books/{id}', name:'detailBook', methods:[ 'GET' ] ) ]

    function getDetailBook( int $id, SerializerInterface $serializer, BookRepository $bookRepository ): JsonResponse {
        $book = $bookRepository->find( $id );
        if ( $book ) {
            return $this->json( $book, $status = 200, $headers = [], [ 'groups' => 'getBooks' ] );
            // $jsonBook = $serializer->serialize( $book, 'json', [ 'groups'=>'getBooks' ] );
            // return new JsonResponse( $jsonBook, Response::HTTP_OK, [], true );
        }
        return new JsonResponse( null, Response::HTTP_NOT_FOUND );
    }

    #[ Route( '/api/books/{id}', name: 'deleteBook', methods: [ 'DELETE' ] ) ]

    public function deleteBook( Book $book, EntityManagerInterface $managerBook ): JsonResponse {
        $managerBook->remove( $book );
        $managerBook->flush();
        return new JsonResponse( null, Response::HTTP_NO_CONTENT );
    }

    #[Route('/api/books', name:"createBook", methods: ['POST'])]
    public function createBook(Request $request, SerializerInterface $serializer, EntityManagerInterface $managerBook, UrlGeneratorInterface $urlGenerator): JsonResponse {
        
        // Récupération du contenu de la requête sous la forme d'un objet Book enregistré dans la variable $book
        $book = $serializer->deserialize( $request->getContent(), Book::class, 'json');
        
        // Enregistrement du livre
        $managerBook->persist($book);
        
        // Confirmation de l'enregistrement
        $managerBook->flush();
        
        // jsonBook est retournée pour information à l'envoyeur
        $jsonBook = $serializer->serialize( $book, 'json', [ 'groups'=>'getBooks' ] );
        
        // l'usage demande dans le cadre du POST d'ajouter une information dans le HEADER de la réponse.
        // $location permet d'indiquer le chemin de l'URL de la requête et sera disponible pour 
        // information afin de tester que l'URL a réellement été créée 
        $location = $urlGenerator->generate('detailBook', ['id'=>$book->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
    }

}
