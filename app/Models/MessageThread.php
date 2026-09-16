<?php

namespace App\Models;

use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsSchool;
use App\Models\Sms\SmsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MessageThread extends Model
{
    protected $fillable = [
        'school_id',
        'admin_id',
        'parent_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(SmsUser::class, 'admin_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SmsParent::class, 'parent_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'thread_id')->orderBy('created_at', 'asc');
    }

    public function unreadCount($userId, $userType): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('sender_type', '!=', $userType)
            ->where('is_read', false)
            ->count();
    }
}
