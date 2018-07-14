<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackSizeValue extends Model
{
    protected $fillable = [
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packSize()
    {
        return $this->belongsTo(PackSize::class, 'pack_size_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productAttributes()
    {
        return $this->belongsToMany(ProductPackSize::class);
    }
}
