<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Modelo de Transacao 

    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'type', 'amount', 
    'description', 'date', 'is_recurring'];

    const TYPE_INCOME = 'income';
    const TYPE_EXPENSE = 'expense';

    protected $casts = [
        'date' => 'date',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
