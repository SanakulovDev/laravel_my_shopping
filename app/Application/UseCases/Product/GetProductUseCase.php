<?php

namespace App\Application\UseCases\Product;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Application\DTOs\ProductDTO;

class GetProductUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id): ?ProductDTO
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            return null;
        }
        
        return new ProductDTO(
            $product->getId(),
            $product->getName(),
            $product->getDetail(),
            $product->getPrice(),
            $product->getPhoto(),
            $product->getCategoryId()
        );
    }
}