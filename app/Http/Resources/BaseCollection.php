<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $response = [];
        $data = $this->mapData($this->collection);
        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $response[$this->getDataKey()] = $data->toArray();
            $response['pagination'] = $this->pagination();
        }
        else {
            $response = $data->toArray();
        }

        return $response;
    }



    protected function mapData(\Illuminate\Support\Collection $collection): \Illuminate\Support\Collection
    {
        return $collection;
    }

    protected function pagination(): array
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage(),
        ];
    }

    /**
     * Dinamik anahtar adı (Veri koleksiyonunun adı)
     */
    protected function getDataKey(): string
    {
        return "items";
    }
}
