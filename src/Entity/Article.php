<?php

namespace App\Entity;
// créé une table
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */

class Article
{
    /**
     * @ORM\Id() // Primary key
     * @ORM\Column(type="integer") // type
     * @ORM\GeneratedValue()  // auto incremente
     */
    private $id;

    /**
     * @ORM\Column(type="string", length="255")
     */
    private $title;

    /**
     * @ORM\Column(type="text") // + de 255 caractères
     */
    private $content;

    /**
     * @ORM\Column(type="datetime") // dd//mm//yyyy
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;

    //getters et setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle() //getter
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void //getter
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

}