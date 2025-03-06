<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Api\v1\BaseApiController;
use App\Http\Requests\Task\PriorityRequest;
use App\Http\Requests\Task\StatusRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task\Task;
use App\Objects\Task\TaskFilterObject;
use App\Objects\Task\TaskObject;
use App\Services\Task\TaskService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends BaseApiController
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);
            $tasks = $this->taskService
                ->list((new TaskFilterObject())->initFromRequest($request))
                ->paginate($perPage, ['*'], 'page', $page);
            return $this->successResponse("Tasks retrieved successfully!", new TaskCollection($tasks), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $object = (new TaskObject())->initFromRequest($request);
            $task = $this->taskService->store($object);
            return $this->successResponse("Task created successfully!", new TaskResource($task), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            return $this->successResponse("Task retrieved successfully!", new TaskResource($task), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task)
    {
        try {
            $object = (new TaskObject())->initFromRequest($request);
            $object->setTask($task);
            $task = $this->taskService->update($object);
            return $this->successResponse("Task updated successfully!", new TaskResource($task), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $this->taskService->destroy($task);
            return $this->successResponse("Task deleted successfully!", null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function updateStatus(Task $task, StatusRequest $request)
    {
        try {
            $object = new TaskObject();
            $object->setTask($task)->setStatus($request->input('status', $task->status));
            $user = $this->taskService->update($object->setTargetProperties('status'));
            return $this->successResponse("Task status updated successfully!", new TaskResource($user), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function updatePriority(Task $task, PriorityRequest $request)
    {
        try {
            $object = new TaskObject();
            $object->setTask($task)->setStatus($request->input('priority', $task->priority));
            $user = $this->taskService->update($object->setTargetProperties('priority'));
            return $this->successResponse("Task status updated successfully!", new TaskResource($user), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
