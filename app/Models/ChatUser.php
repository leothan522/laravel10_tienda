<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = "chatusers";
    protected $fillable = ['users_id', 'chats_id', 'default', 'mensajes_vistos'];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chats_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}
