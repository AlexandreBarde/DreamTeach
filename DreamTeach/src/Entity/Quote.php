<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 10/04/2019
 * Time: 13:29
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="quotecontent", type="string", length=255, nullable=false)
     */
    private $quotecontent;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=false)
     */
    private $author;

    /**
     * Quote constructor.
     * @param int $id
     * @param string $quotecontent
     * @param string $author
     */
    public function __construct(string $quotecontent, string $author)
    {

        $this->quotecontent = $quotecontent;
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getQuotecontent(): string
    {
        return $this->quotecontent;
    }

    /**
     * @param string $quotecontent
     */
    public function setQuotecontent(string $quotecontent): void
    {
        $this->quotecontent = $quotecontent;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }


}