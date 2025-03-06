<?php

namespace App\Services\User;

use App\Models\User;
use App\Objects\Traits\User\UserFilterObject;
use App\Objects\Traits\User\UserObject;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    public UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(UserFilterObject $filterObject): \Illuminate\Database\Eloquent\Builder
    {
        return $filterObject->apply($this->userRepository->queryWithRelations());
    }

    public function select(UserFilterObject $filterObject)
    {
        return $filterObject->apply($this->userRepository->query()->select('id', "name as title", "email", "status"));
    }


    public function store(UserObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->userRepository->create($object->toArrayForSnakeCase());
        });
    }

    public function update(UserObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->userRepository->update($object->getUser(), $object->toArrayForSnakeCase());
        });
    }

    public function destroy(User $user)
    {
        return DB::transaction(function () use ($user) {
            return $this->userRepository->delete($user);
        });
    }
}
