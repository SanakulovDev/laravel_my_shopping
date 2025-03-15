<?php

namespace App\Domain\Entities;

class Product
{
    private $id;
    private $name;
    private $detail;
    private $price;
    private $photo;
    private $categoryId;

    public function __construct(
        $id = null, 
        $name = null, 
        $detail = null, 
        $price = null, 
        $photo = null, 
        $categoryId = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->detail = $detail;
        $this->price = $price;
        $this->photo = $photo;
        $this->categoryId = $categoryId;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDetail() { return $this->detail; }
    public function getPrice() { return $this->price; }
    public function getPhoto() { return $this->photo; }
    public function getCategoryId() { return $this->categoryId; }

    // Setters
    public function setName($name) { $this->name = $name; }
    public function setDetail($detail) { $this->detail = $detail; }
    public function setPrice($price) { $this->price = $price; }
    public function setPhoto($photo) { $this->photo = $photo; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
}