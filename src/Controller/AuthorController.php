<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController {
    #[ Route( '/api/authors/', name: 'authors' ) ]

    public function getAllAuthors( AuthorRepository $authorRepository, SerializerInterface $serializer ): JsonResponse {
        $authorsList = $authorRepository->findAll();
        $jsonAuthorsList = $serializer->serialize( $authorsList, 'json', [ 'groups'=>'getAuthors' ] );
        return new JsonResponse( $jsonAuthorsList, Response::HTTP_OK, [], true );
    }

    #[ Route( '/api/authors/{id}', name: 'detailAuthor' ) ]

    public function getAuthor( int $id, AuthorRepository $authorRepository, SerializerInterface $serializer ): JsonResponse {
        $author = $authorRepository->find( $id );
        if ( $author ) {
            $jsonAuthor = $serializer->serialize( $author, 'json', [ 'groups'=>'getAuthors' ] );
            return new JsonResponse( $jsonAuthor, Response::HTTP_OK, [], true );
        }
        return new JsonResponse( null, Response::HTTP_NOT_FOUND );

    }

}

