<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    protected $guard = 'jobs';

    protected $table = 'jobs';

    protected $primaryKey = 'job_id';

    protected $fillable = [
        'job_tag',
        'skill_set',
        'work_period',
        'budget_des',
        'budget',
        'job_des',

        // des means description
    ];

    protected $casts = [
        'jobs_created_at' => 'datetime',
    ];

    // Creating a relationship to savedJobs model
    public function savedJobs()
    {
        return $this->belongsToMany(User::class, 'saved_jobs');
    }

    // Creating a relationship to assignedJobs model
    public function assignedJobs()
    {
        return $this->belongsToMany(User::class, 'assigned_jobs');
        return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
    }
}
