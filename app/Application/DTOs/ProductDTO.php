<?php

namespace App\Application\DTOs;

class ProductDTO
{
    public $id;
    public $name;
    public $detail;
    public $price;
    public $photo;
    public $categoryId;
    public $categoryName;

    public function __construct($id = null, $name = null, $detail = null, $price = null, $photo = null, $categoryId = null, $categoryName = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->detail = $detail;
        $this->price = $price;
        $this->photo = $photo;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }
}