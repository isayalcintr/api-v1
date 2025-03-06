<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ProcessByUsers
{
    protected function formatDataBeforeCreate(array &$data): void
    {
        $data["created_by"] = Auth::check() ? Auth::id() : null;
        unset($data['updated_by']);
        unset($data['deleted_by']);
    }

    protected function formatDataBeforeUpdate(Model $record, array &$data): void
    {
        $data["updated_by"] = Auth::check() ? Auth::id() : null;
        unset($data['created_by']);
        unset($data['deleted_by']);
    }

    protected function formatDataAfterDelete(Model $record): void
    {
        $record->update(["deleted_by" => Auth::check() ? Auth::id() : null]);
    }
}
