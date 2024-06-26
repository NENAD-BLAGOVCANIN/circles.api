<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    protected $fillable = [
        'subject',
        'description',
        'lead_id',
        'team_id',
        'assigned_to',
        'status'
    ];

    public function assignee()
    {
        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }

}
