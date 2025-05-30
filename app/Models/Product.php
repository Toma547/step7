<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['image','name', 'price', 'stock', 'company_id','description'];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
