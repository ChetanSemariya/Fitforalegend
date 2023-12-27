<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function parentcategory(){
        return $this->hasOne('App\Models\Category','id', 'parent_id')->select('id','category_name','url')->where('status', 1);
    }
}
