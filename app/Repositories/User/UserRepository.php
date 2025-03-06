<?php

namespace App\Repositories\User;

use App\Enums\ModuleEnum;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Traits\Logable;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    use Logable;
    public int $module = ModuleEnum::USER->value;

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function initPasswordBeforeUpdate(&$record, &$data): void
    {
        if (empty(trim($data['password']))) {
            unset($data['password']);
        }
        else {
            $data['password'] = Hash::make($data['password']);
        }
    }
}
