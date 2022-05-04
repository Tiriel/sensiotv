<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Length(min: 5)]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $author;

    #[Assert\Length(min: 10)]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $message;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
