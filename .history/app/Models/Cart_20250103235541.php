<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    public $timestamps = false;
    // protected $primaryKey = ['user_id', 'product_id'];
    protected $primaryKey = null; // Không sử dụng primary key mặc định


    // Hàm để xác định composite key
    public function scopeFindCompositeKey($query, $key1, $key2)
    {
        return $query->where('key1', $key1)->where('key2', $key2);
    }
    public $incrementing = false;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

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
    
    // Schema::create('carts', function (Blueprint $table) {
    //     $table->unsignedBigInteger('user_id');
    //     $table->unsignedBigInteger('product_id');
    //     $table->integer('quantity');
    //     $table->timestamps();
    
    //     $table->primary(['user_id', 'product_id']);
    //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //     $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    // });
}
