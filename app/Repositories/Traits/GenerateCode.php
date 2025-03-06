<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait GenerateCode
{
    /**
     * @throws \Exception
     */
    protected function generateCodeBeforeCreate(array &$data): void
    {
        $code = DB::scalar("SELECT generate_module_code(?)", [$this->getModule()]);
        if (empty($code)) {
            throw new \Exception("Module Code Not Found!");
        }
        $data["code"] = $code;
    }

    protected function clearCodeBeforeUpdate(Model $record, array &$data): void
    {
        unset($data['code']);
    }

    protected function getModule(): int
    {
        return property_exists($this, 'module') ? $this->module : 0;
    }
}
