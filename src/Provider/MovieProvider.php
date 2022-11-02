<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\OmdbMovieTransformer;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class MovieProvider
{
    public function __construct(
        private MovieRepository $movieRepository,
        private OMDbApiConsumer $consumer,
        private OmdbMovieTransformer $transformer,
        private GenreProvider $genreProvider,
        private Security $security
    ) {}

    public function getMovieByTitle(string $title)
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_TITLE, $title);
    }

    public function getMovieById(string $id): Movie
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_ID, $id);
    }

    private function getOneMovie(string $mode, string $value)
    {
        $data = $this->consumer->consume($mode,  $value);

        if ($entity = $this->movieRepository->findOneBy(['title' => $data['Title']])) {
            return $entity;
        }
        $movie = $this->transformer->transform($data);
        foreach ($this->genreProvider->getGenresFromString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        $movie->setAddedBy($this->security->getUser());
        $this->movieRepository->add($movie, true);

        return $movie;
    }
}

