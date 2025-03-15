<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Product;
    public function save(Product $product): Product;
    public function update(Product $product): bool;
    public function delete(int $id): bool;
    public function findByCategoryId(int $categoryId): array;
}