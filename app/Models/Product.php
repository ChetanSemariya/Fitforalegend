<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // every product belongs to some category
    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id')->with('parentcategory');
    }
}
