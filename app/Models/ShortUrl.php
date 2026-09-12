<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "original_url",
        "user_id",
        "company_id",
        "clicks",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeVisibleTo(Builder $query, User $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isAdmin()) {
            return $query->where("company_id", $user->company_id);
        }

        return $query->where("user_id", $user->id);
    }
}
