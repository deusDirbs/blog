<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManufactureMacAddress extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'manufacture_mac_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac',
        'address_format',
        'manufacture_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getManufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }
}
