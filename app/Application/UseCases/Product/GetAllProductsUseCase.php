<?php

namespace App\Application\UseCases\Product;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Application\DTOs\ProductDTO;

class GetAllProductsUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(): array
    {
        $products = $this->productRepository->findAll();
        
        return array_map(function ($product) {
            return new ProductDTO(
                $product->getId(),
                $product->getName(),
                $product->getDetail(),
                $product->getPrice(),
                $product->getPhoto(),
                $product->getCategoryId()
            );
        }, $products);
    }
}