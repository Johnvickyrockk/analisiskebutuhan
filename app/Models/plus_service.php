<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class plus_service extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'price', 'status_plus_service'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function transaksis()
    {
        return $this->belongsToMany(transaksi::class, 'transaksi_plus_services')
            ->withPivot('category_sepatu_id', 'uuid')
            ->withTimestamps();
    }

    public function categorySepatus()
    {
        return $this->belongsToMany(CategorySepatu::class, 'transaksi_plus_services')
            ->withPivot('transaksi_id', 'uuid')
            ->withTimestamps();
    }
}
