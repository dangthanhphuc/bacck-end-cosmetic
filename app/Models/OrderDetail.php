<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OrderDetail extends Model
{
    use HasFactory, HasCompositeKey;

    protected $table = 'order_details';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['order_id', 'product_id'];
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price'];

    public function getKeyName() {
        return $this->primaryKey;
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public static function createFromProducts($orderId, $products) {
        foreach ($products as $product) {
            self::create([
                'product_id' => $product['id'],
                'order_id' => $orderId,
                'quantity' => $product['quantity'],
                'unit_price' =>  Product::find($product['id'])->price,
            ]);
        } 
    }

}
