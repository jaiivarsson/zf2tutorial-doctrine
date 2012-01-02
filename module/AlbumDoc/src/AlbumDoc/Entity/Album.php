<?php

namespace AlbumDoc\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album {

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $artist;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * global getter
     * 
     * @param type $property
     * @return type 
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Global setter
     * 
     * @param type $property
     * @param type $value 
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

}