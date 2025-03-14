<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions','permission_id', 'user_id');
    }

}

