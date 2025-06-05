<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'company_id',
        'comment',
        'price',
        'stock',
        'image_path',];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}