<?php

namespace App\Entity;
// créé une table
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @ORM\Entity()
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

}