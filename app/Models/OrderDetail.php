<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function refund_request()
    {
        return $this->hasOne(RefundRequest::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function scopeProducto($query, $producto)
    {
        if ($producto) {
            return $query->whereHas('product', function ($query) use ($producto) {
                $query->where('id', $producto);
            });
        }
    }

    public function scopeProveedor($query, $proveedor)
    {
        if ($proveedor) {
            return $query->whereHas('user', function ($query) use ($proveedor) {
                $query->where('id', $proveedor);
            });
        }
    }
}
