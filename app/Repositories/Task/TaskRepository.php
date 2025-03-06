<?php

namespace App\Repositories\Task;

use App\Enums\ModuleEnum;
use App\Models\Task\Task;
use App\Repositories\BaseRepository;
use App\Repositories\Traits\GenerateCode;
use App\Repositories\Traits\Logable;
use App\Repositories\Traits\ProcessByUsers;

class TaskRepository extends BaseRepository
{
    use Logable,ProcessByUsers, GenerateCode {Logable::getModule insteadof  GenerateCode;}
    public int $module = ModuleEnum::TASK->value;
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    protected function relations(): array
    {
        return [
            'incumbentUsers',
            'creator',
            'updater',
            'deleter',
        ];
    }

    protected function syncIncumbentUsersAfterCreate(Task $record, array $data = []): void
    {
        $record->incumbentUsers()->sync($data['incumbent_users']);
    }

    protected function syncIncumbentUsersAfterUpdate(Task $record, array $data = []): void
    {
        $record->incumbentUsers()->sync($data['incumbent_users']);
    }

    protected function syncIncumbentUsersAfterUpdateOrCreate(Task $record, array $data = []): void
    {
        $record->incumbentUsers()->sync($data['incumbent_users']);
    }
}
