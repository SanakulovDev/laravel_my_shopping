<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'detail',
        'price',
        'photo',
        'category_id'
    ];

    /**
     * Get the category that owns the product.
     */
    // public function category()
    // {
    //     return $this->belongsTo(CategoryModel::class, 'category_id');
    // }
}