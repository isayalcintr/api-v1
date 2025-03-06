<?php

namespace App\Objects\Traits\User;

use App\Models\User;
use App\Objects\Traits\BaseObject;

class UserObject extends BaseObject
{
    protected ?User $user = null;
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $email = null;
    protected ?string $password = null;
    protected ?bool $status = null;
    public function __construct(?User $user = null, ?int $id = null, ?string $name = null, ?string $email = null, ?string $password = null, ?bool $status = null)
    {
        $this->setUser($user)
            ->setId($id)
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setStatus($status);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;
        return $this;
    }
}
