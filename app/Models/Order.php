<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->hasOne(Shop::class, 'user_id', 'seller_id');
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function club_point()
    {
        return $this->hasMany(ClubPoint::class);
    }

    public function delivery_boy()
    {
        return $this->belongsTo(User::class, 'assign_delivery_boy', 'id');
    }

    public function proxy_cart_reference_id()
    {
        return $this->hasMany(ProxyPayment::class)->select('reference_id');
    }

    public function scopeDateStart($query, $date)
    {
        if ($date) {
            $query->whereDate('created_at', '>=', $date);
        }

    }

    public function scopeDateEnd($query, $date)
    {
        if ($date) {
            $query->whereDate('created_at', '<=', $date);
        }

    }

    public function scopeProvider($query, $seller_id)
    {
        if ($seller_id) {
            $query->where('seller_id', $seller_id);
        }

    }

    public function scopeStatus($query, $status)
    {
        $filter = 0;

        if ($status == 'En espera') {
            $status = null;
            $filter = 1;
        }
        elseif($status == 'Aprobada') {
            $status = 1;
            $filter = 1;
        } else {
            $status = 0;
            $filter = 1;
        }

        if ($filter) {
            $query->where('status', '>=', $status);
        }

    }

    public function scopeTipoNegocio($query, $tipoNegocio)
    {
        if ($tipoNegocio) {
            return $query->whereHas('seller', function ($query) {
                return $query->where('tipo', $tipoNegocio);
            });
        }
    }
}
