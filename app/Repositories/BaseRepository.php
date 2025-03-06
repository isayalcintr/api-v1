<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionMethod;

class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function query(): Builder
    {
        return $this->model->query();
    }

    public function queryWithRelations(): Builder
    {
        return $this->query()->with($this->relations());
    }

    public function findWithRelations(int|string $id): ?Model
    {
        return $this->query()->with($this->findRelations())->find($id);
    }

    protected function relations(): array
    {
        return [];
    }

    protected function findRelations(): array
    {
        return $this->relations();
    }

    public function create(array $data): Model
    {
        $this->executeHooks('BeforeCreate', $data);
        $record = $this->model->create($data);
        $record->refresh();
        $this->executeHooks('AfterCreate', $record, $data);
        return $record;
    }

    public function update(Model $record, array $data): Model
    {
        $this->executeHooks('BeforeUpdate', $record, $data);
        $record->update($data);
        $record->refresh();
        $this->executeHooks('AfterUpdate', $record, $data);
        return $record;
    }

    public function delete(Model $record): bool
    {
        $this->executeHooks('BeforeDelete', $record);
        $deleted = $record->delete();
        $record->refresh();
        $this->executeHooks('AfterDelete', $record);
        return $deleted;
    }

    public function updateOrCreate(array $conditions, array $data): Model
    {
        $this->executeHooks('BeforeUpdateOrCreate', $data);
        $record = $this->model->updateOrCreate($conditions, $data);
        $record->refresh();
        $this->executeHooks('AfterUpdateOrCreate', $record, $data);
        return $record;
    }

    /**
     * Belirtilen hook için ilgili metotları çalıştırır.
     */
    protected function executeHooks(string $hook, mixed &...$params): void
    {
        $methods = $this->getHookMethods($hook);
        foreach ($methods as $method) {
            $this->{$method['name']}(...$params);
        }
    }

    /**
     * Hook metotlarını bulur ve öncelik sırasına göre sıralar.
     */
    protected function getHookMethods(string $hook): array
    {
        $methods = [];
        foreach ((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PROTECTED) as $method) {
            if (preg_match('/(.+)' . $hook . '(?:P(\d+))?/', $method->getName(), $matches)) {
                $priority = isset($matches[2]) ? (int) $matches[2] : 10;
                $methods[] = [
                    'name' => $method->getName(),
                    'priority' => $priority,
                ];
            }
        }
        return $this->sortMethodsByPriority($methods);

    }

    /**
     * Metotları öncelik sırasına göre sıralar.
     */
    protected function sortMethodsByPriority(array $methods): array
    {
        usort($methods, fn($a, $b) => $a['priority'] <=> $b['priority']);
        return $methods;
    }
}
