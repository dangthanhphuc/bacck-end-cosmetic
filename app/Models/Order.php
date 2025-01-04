<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'date',
        'status'
    ];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }

    public function delete() {
        
        // $this->orderDetails()->update(['order_id' => null]); Có thể set null thay vì xóa
        $this->orderDetails()->delete(); // Delete order details records
        return parent::delete(); // Delete order record
    }

}
