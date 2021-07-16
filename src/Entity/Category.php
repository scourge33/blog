<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Try Again")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=5,
     *     max=30,)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    // 1 catégorie pour x articles
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;

    private $categories;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }


    //
    // GETTERS N SETTERS
    //
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return
     */
    public function getArticles()
    {
        return $this->articles;
    }

    public function setIsPublished(\DateTime $param)
    {
        return $this->categories;
    }
}
