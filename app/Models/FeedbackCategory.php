<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
