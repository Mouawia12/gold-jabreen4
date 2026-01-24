<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Model;

class ItemsCollectible extends Model
{
    protected $table = "items_collectibles";
    protected $fillable = [
        'code',
        'name_ar',
        'name_en',
        'branch_id',
        'category_id',
        'karat_id',
        'weight',
        'no_metal',
        'no_metal_type',
        'made_Value',
        'item_type',
        'brand',
        'stone_type',
        'stone_purity',
        'stone_color',
        'stone_size',
        'metal_weight',
        'other_properties1',
        'other_properties2',
        'other_properties3', 
        'tax',
        'price',
        'cost',
        'stat',
        'img',
        'att_file',
        'quantity', 
        'user_id'

    ];

    public function karat(){
       return $this -> belongsTo(\App\Models\Karat::class ,'karat_id' );
    }

    public function category(){
        return $this -> belongsTo(\App\Models\Category::class ,'category_id' );
    }


}
