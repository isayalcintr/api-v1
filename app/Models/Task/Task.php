<?php

namespace App\Models\Task;

use App\Enums\Task\PriorityEnum;
use App\Enums\Task\StatusEnum;
use App\Models\Traits\HasProcessByUserRelations;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, HasProcessByUserRelations;

    protected $table = 'tasks';

    protected $fillable = [
        'code',
        'title',
        'description',
        'status',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $appends = ["priority_title", "status_title"];

    public function getPriorityTitleAttribute(): string
    {
        return PriorityEnum::getLabel($this->priority) ?? "Bilinmiyor";
    }

    public function getStatusTitleAttribute(): string
    {
        return StatusEnum::getLabel($this->status) ?? "Bilinmiyor";
    }
    public function incumbentUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_users', 'task_id', 'user_id');
    }
}
