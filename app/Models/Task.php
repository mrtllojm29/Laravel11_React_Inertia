<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Fields that are mass assignable
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'status',
        'priority',
        'due_date',
        'assigned_user_id',
        'created_by',
        'updated_by',
        'project_id',
    ];

    // A task belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // The user assigned to this task
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    // The user who created this task
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // The user who last updated this task
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
