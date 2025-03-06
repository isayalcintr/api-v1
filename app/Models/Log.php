<?php

namespace App\Models;

use App\Enums\Enums\Log\ActionEnum;
use App\Enums\ModuleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'module',
        'action',
        'related_id',
        'user_id',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    protected $appends = ['module_title', 'action_title'];

    public function getModuleTitleAttribute(): string
    {
        return ModuleEnum::getLabel($this->module_id) ?? 'Bilinmiyor';
    }

    public function getActionTitleAttribute(): string
    {
        return ActionEnum::getLabel($this->action) ?? 'Bilinmiyor';
    }

}
