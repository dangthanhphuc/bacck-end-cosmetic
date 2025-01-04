<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false;
   
    public $incrementing = false;
    protected $fillable = ['user_id', 'product_id', 'quantity'];
    protected $primaryKey = ['user_id', 'product_id'];
    public function getKeyName()
    {
        return $this->primaryKey;
    }

     // Định nghĩa mối quan hệ với User
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     // Định nghĩa mối quan hệ với Product
    public function product()
    {
         return $this->belongsTo(Product::class);
    }
    
}
