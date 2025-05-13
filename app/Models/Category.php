<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Todo2;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id'];

    // Relasi satu kategori punya banyak todo
    public function todos()
    {
        return $this->hasMany(Todo2::class);
    }
}
