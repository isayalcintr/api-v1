<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\BaseCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends BaseCollection
{
    protected function mapData(\Illuminate\Support\Collection $collection): \Illuminate\Support\Collection
    {
        return $this->collection->map(function ($item) {
            return $item->load('incumbentUsers', 'creator', 'updater', 'deleter');
        });
    }
}
