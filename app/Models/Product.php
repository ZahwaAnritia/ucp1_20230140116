<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name', 
        'qty', 
        'price', 
        'user_id'
    ];

    // Fungsi ini harus ada DI DALAM kurung kurawal class
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
} // Kurung ini harus jadi yang paling terakhir di file