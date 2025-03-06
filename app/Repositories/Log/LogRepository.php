<?php

namespace App\Repositories\Log;

use App\Models\Log;
use App\Repositories\BaseRepository;

class LogRepository extends BaseRepository
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }
}
