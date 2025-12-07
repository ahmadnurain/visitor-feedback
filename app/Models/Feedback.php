<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'destination_id',
        'user_id',
        'feedback_category_id', // Changed from category
        'visitor_name', // Added
        'channel', // Added
        'rating',
        'title',
        'content',
        'attachments',
        'status',
        'action_taken', // Added
        'processed_by', // Added
        'contact_email',
        'contact_phone',
        'submitted_ip',
        'submitted_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
