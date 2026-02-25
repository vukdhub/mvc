<?php

namespace App\Entity;

use App\Entity\Book;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Book.
 * This class tests all getter and setter methods of the Book entity,
 * including ID, Title, Author, ISBN, and Cover fields.
 */
class BookTest extends TestCase
{
    /**
     * @var Book The Book instance used in each test
     */
    private Book $book;

    /**
     * Sets up the test environment before each test.
     *
     * Initializes a new Book object.
     */
    protected function setUp(): void
    {
        $this->book = new Book();
    }

    /**
     * Test that the ID of a newly created Book is null.
     */
    public function testIdNull(): void
    {
        $this->assertNull($this->book->getId());
    }

    /**
     * Test the getter and setter for the Title field.
     */
    public function testTitleGetterSetter(): void
    {
        $this->book->setTitle('Swedish History');
        $this->assertSame('Swedish History', $this->book->getTitle());
    }

     /**
     * Test the getter and setter for the Author field.
     */
    public function testAuthorGetterSetter(): void
    {
        $this->book->setAuthor('Vuk Dz');
        $this->assertSame('Vuk Dz', $this->book->getAuthor());
    }

     /**
     * Test the getter and setter for the ISBN field.
     */
    public function testIsbnGetterSetter(): void
    {
        $this->book->setIsbn('001-1234567890');
        $this->assertSame('001-1234567890', $this->book->getIsbn());
    }

    /**
     * Test the getter and setter for the Cover field.
     */
    public function testCoverGetterSetter(): void
    {
        $this->book->setCover('cover.jpg');
        $this->assertSame('cover.jpg', $this->book->getCover());
    }
}

