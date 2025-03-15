<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Persistence\Models\ProductModel;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function findAll(): array
    {
        $productModels = ProductModel::all();
        
        $products = [];
        foreach ($productModels as $model) {
            $products[] = $this->mapToEntity($model);
        }
        
        return $products;
    }
    
    public function findById(int $id): ?Product
    {
        $model = ProductModel::find($id);
        
        if (!$model) {
            return null;
        }
        
        return $this->mapToEntity($model);
    }
    
    public function save(Product $product): Product
    {
        $model = new ProductModel();
        $model->name = $product->getName();
        $model->detail = $product->getDetail();
        $model->price = $product->getPrice();
        $model->photo = $product->getPhoto();
        $model->category_id = $product->getCategoryId();
        $model->save();
        
        return $this->mapToEntity($model);
    }
    
    public function update(Product $product): bool
    {
        $model = ProductModel::find($product->getId());
        
        if (!$model) {
            return false;
        }
        
        $model->name = $product->getName();
        $model->detail = $product->getDetail();
        $model->price = $product->getPrice();
        $model->photo = $product->getPhoto();
        $model->category_id = $product->getCategoryId();
        
        return $model->save();
    }
    
    public function delete(int $id): bool
    {
        $model = ProductModel::find($id);
        
        if (!$model) {
            return false;
        }
        
        return $model->delete();
    }
    
    public function findByCategoryId(int $categoryId): array
    {
        $productModels = ProductModel::where('category_id', $categoryId)->get();
        
        $products = [];
        foreach ($productModels as $model) {
            $products[] = $this->mapToEntity($model);
        }
        
        return $products;
    }
    
    private function mapToEntity(ProductModel $model): Product
    {
        return new Product(
            $model->id,
            $model->name,
            $model->detail,
            $model->price,
            $model->photo,
            $model->category_id
        );
    }
}