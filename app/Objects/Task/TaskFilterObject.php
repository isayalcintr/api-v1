<?php

namespace App\Objects\Task;


use App\Objects\BaseFilterObject;

class TaskFilterObject extends BaseFilterObject
{
    public function __construct(string $alias = "tasks")
    {
        parent::__construct($alias);
    }
}
