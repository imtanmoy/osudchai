<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class PackSize extends Model
{
    protected $fillable = [
        'name'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(PackSizeValue::class, 'pack_size_id', 'id');
    }
}
