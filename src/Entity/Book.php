<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
/**
 * Entity representing a book.
 *
 * Stores basic book's data: title, author, ISBN and cover.
 */
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Author = null;

    #[ORM\Column]
    private ?string $Isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $Cover = null;

    /**
     * Get the ID of the book.
     *
     * @return int|null Book ID or null if not set
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the book title.
     *
     * @return string|null Title or null if not set
     */
    public function getTitle(): ?string
    {
        return $this->Title;
    }

    /**
     * Set the book title.
     *
     * @param string $Title Book title
     * @return static
     */
    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    /**
     * Get the author name.
     *
     * @return string|null Author or null if not set
     */
    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    /**
     * Set the author name.
     *
     * @param string $Author Author name
     * @return static
     */
    public function setAuthor(string $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * Get the ISBN number.
     *
     * @return string|null ISBN or null if not set
     */
    public function getIsbn(): ?string
    {
        return $this->Isbn;
    }

    /** Set the ISBN number.
    *
    * @param string $Isbn ISBN value
    * @return static
    */
    public function setIsbn(string $Isbn): static
    {
        $this->Isbn = $Isbn;

        return $this;
    }

    /**
     * Get the cover image path or URL.
     *
     * @return string|null Cover path or null if not set
     */
    public function getCover(): ?string
    {
        return $this->Cover;
    }

    /**
     * Set the cover image path or URL.
     *
     * @param string $Cover Cover path or URL
     * @return static
     */
    public function setCover(string $Cover): static
    {
        $this->Cover = $Cover;

        return $this;
    }
}
