<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    // Modelo de Alerta 

    use HasFactory;

    protected $fillable = ['user_id', 'type', 'message', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
