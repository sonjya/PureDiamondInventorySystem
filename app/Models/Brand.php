<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_brand';
    
    protected  $primaryKey = 'BrandID';

    protected $fillable = [
        'BrandID',
        'BrandName',
        'IsActive',
    ];

}
