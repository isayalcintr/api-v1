<?php

namespace App\Objects\Task;

use App\Models\Task\Task;
use App\Objects\BaseObject;
use App\Objects\Traits\HasProcessByUser;

class TaskObject extends BaseObject
{
    use HasProcessByUser;
    protected ?Task $task = null;
    protected ?int $id = null;
    protected ?string $title = null;
    protected ?string $description = null;
    protected ?string $status = null;
    protected ?string $priority = null;
    protected ?array $incumbentUsers = [];
    public function __construct(?Task $task = null, ?int $id = null, ?string $title = null, ?string $description = null, ?string $status = null, ?string $priority = null, ?array $incumbentUsers = [])
    {
        $this->setTask($task)
                ->setId($id)
                ->setTitle($title)
                ->setDescription($description)
                ->setStatus($status)
                ->setPriority($priority)
                ->setIncumbentUsers($incumbentUsers);
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getIncumbentUsers(): ?array
    {
        return $this->incumbentUsers;
    }

    public function setIncumbentUsers(?array $incumbentUsers): self
    {
        $this->incumbentUsers = $incumbentUsers;
        return $this;
    }

}
