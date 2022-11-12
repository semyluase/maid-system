<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTakenMaid extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function userAction()
    {
        return $this->belongsTo(User::class, 'user_action', 'id');
    }
}
