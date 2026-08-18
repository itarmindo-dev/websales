<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckModel extends Model
{
    protected $fillable = [
        'name',
        'series',
        'description',
        'image',
        'whatsapp_message',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
