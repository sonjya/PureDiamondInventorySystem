<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{   
    
    use HasFactory;

    protected $table = 'tbl_items';
    
    protected  $primaryKey = 'ItemID';

    protected $fillable = [
        'ItemID',
        'ItemName',
        'ItemPrice',
        'ItemUOM',
        'BrandID',
        'MinStock',
        'ReorderQty',
        'IsActive',
    ];
}
