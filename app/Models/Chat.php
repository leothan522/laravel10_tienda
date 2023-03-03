<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";
    protected $fillable = ['tipo'];

    public function chatusers(): HasMany
    {
        return $this->hasMany(ChatUser::class, 'chats_id', 'id');
    }

    public function chatmessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chats_id', 'id');
    }

}
