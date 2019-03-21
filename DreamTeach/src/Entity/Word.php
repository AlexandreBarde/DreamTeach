<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 20/03/2019
 * Time: 17:51
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity
 */
class Word
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
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     */
   private $word;

    /**
     * @var string
     *
     * @ORM\Column(name="definition", type="string", length=255, nullable=false)
     */
    private $definition;

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return $this->definition;
    }

    /**
     * @param string $definition
     */
    public function setDefinition(string $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * @var Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="theme", referencedColumnName="id")
     * })
     */
   private $theme;

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
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = $word;
    }

    /**
     * @return Theme
     */
    public function getTheme(): Theme
    {
        return $this->theme;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme(Theme $theme): void
    {
        $this->theme = $theme;
    }

}