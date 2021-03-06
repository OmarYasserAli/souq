<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $casts = [
        'seller_id ' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function scopeActive($query){
        return $query->whereHas('seller', function ($query) {
            $query->where(['status' => 'approved']);
        });
    }
    public function scopeCountryFilter($query)
    {
        if(session()->has('country'))
            return  $query->where('country_id',session('country'));

    }
    public function scopeCityFilter($query)
    {
        if(session()->has('city'))
            return  $query->where('government_id',session('city'));

    }
}
