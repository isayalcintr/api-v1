<?php

namespace App\Objects\Traits\User;

use App\Objects\Traits\BaseFilterObject;
use Illuminate\Database\Eloquent\Builder;

class UserFilterObject extends BaseFilterObject
{
    protected ?string $search = null;
    protected ?bool $status = null;
    public function __construct(string $alias = "users", ?string $search = null)
    {
        parent::__construct($alias);
        $this->search = $search;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch($search): static
    {
        $this->search = $search;
        return $this;
    }

    public function isFilterableSearch(): bool
    {
        return !empty(trim($this->getSearch()));
    }

    public function filterToSearch(Builder $builder): Builder
    {
        return $builder->whereRaw("LOWER(CONCAT(".$this->getColumn('name').", ' &|& ', ".$this->getColumn('email').")) ILIKE LOWER(?)", ["%".trim($this->getSearch())."%"]);
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;
        return $this;
    }
}
