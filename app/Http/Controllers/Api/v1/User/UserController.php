<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Api\v1\BaseApiController;
use App\Http\Requests\User\StatusRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserSelectCollection;
use App\Models\User;
use App\Objects\Traits\User\UserFilterObject;
use App\Objects\Traits\User\UserObject;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseApiController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);
            $users = $this->userService
                ->list((new UserFilterObject())->initFromRequest($request))
                ->paginate($perPage, ['*'], 'page', $page);
            return $this->successResponse("Users retrieved successfully!", new UserCollection($users), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function select(Request $request)
    {
        try {
            $limit = $request->query('limit', 100);
            $query = $this->userService->select((new UserFilterObject())->initFromRequest($request)->setStatus(true));
            $limit > 0 && $query->limit($limit);
            return $this->successResponse("Users retrieved successfully!", new UserSelectCollection($query->get()), Response::HTTP_OK);
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
            $object = (new UserObject())->initFromRequest($request);
            $user = $this->userService->store($object);
            return $this->successResponse("User created successfully!", new UserResource($user), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return $this->successResponse("User retrieved successfully!", new UserResource($user), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        try {
            $object = (new UserObject())->initFromRequest($request);
            $object->setUser($user);
            $user = $this->userService->update($object);
            return $this->successResponse("User updated successfully!", new UserResource($user), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->destroy($user);
            return $this->successResponse("User deleted successfully!", null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function updateStatus(User $user, StatusRequest $request)
    {
        try {
            $object = new UserObject();
            $object->setUser($user)->setStatus($request->input('status', $user->status));
            $user = $this->userService->update($object->setTargetProperties('status'));
            return $this->successResponse("User status updated successfully!", new UserResource($user), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

}
