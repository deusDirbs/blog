<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Helpers\ManufactureMacAddressHelper;

class Manufacture  extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    protected $table = 'manufacture';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getManufactureAddress()
    {
        return $this->hasOne(ManufactureAddress::class);
    }

    /**
     * @return mixed
     */
    public function getManufactureMacAddress()
    {
        return $this->hasOMany(ManufactureMacAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getManufactureMacAsHex()
    {
        return $this->hasOne(ManufactureMacAddress::class)->where('address_format', ManufactureMacAddressHelper::HEX);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getManufactureMacAsBase()
    {
        return $this->hasOne(ManufactureMacAddress::class)->where('address_format', ManufactureMacAddressHelper::BASE);
    }
}
