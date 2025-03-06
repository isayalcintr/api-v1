<?php

namespace App\Services\Task;

use App\Models\Task\Task;
use App\Objects\Task\TaskFilterObject;
use App\Objects\Task\TaskObject;
use App\Repositories\Task\TaskRepository;
use Illuminate\Support\Facades\DB;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function list(TaskFilterObject $filterObject): \Illuminate\Database\Eloquent\Builder
    {
        return $filterObject->apply($this->taskRepository->queryWithRelations());
    }

    public function store(TaskObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->taskRepository->create($object->toArrayForSnakeCase());
        });
    }

    public function update(\App\Objects\Task\TaskObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->taskRepository->update($object->getTask(), $object->toArrayForSnakeCase());
        });
    }

    public function destroy(Task $task)
    {
        return DB::transaction(function () use ($task) {
            return $this->taskRepository->delete($task);
        });
    }
}
