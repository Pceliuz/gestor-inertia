<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'last_seen'];

    /**
     * Relación: un registro de ActiveUser pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
