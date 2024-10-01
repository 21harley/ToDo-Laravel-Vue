<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    
    protected $table = 'note';

    protected $fillable = [
        'title',
        'description',
        'creation_date',
        'due_date',
        'user_id',
        'tags',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
