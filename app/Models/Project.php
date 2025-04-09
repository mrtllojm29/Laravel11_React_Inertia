<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'image_path', 
        'name', 
        'description', 
        'status', 
        'due_date', 
        'created_by', 
        'updated_by'
    ];

    // A project has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Creator relationship (user who created the project)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater relationship (user who last updated the project)
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
