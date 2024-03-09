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

    // product filters
    public static function productsFilters(){
        $productsFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productsFilters['sleeveArray'] = array('Full Sleeve','Half Sleeve', 'Short Sleeve','Sleeveless');
        $productsFilters['patternArray'] = array('Checked', 'Plain','Printed','Self','Solid');
        $productsFilters['fitArray'] = array('Regular', 'Slim');
        $productsFilters['occasionArray'] = array('Casual', 'Formal');
        return $productsFilters;
    }

    // One product has many images
    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    // one product has many attributes
    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }
}
