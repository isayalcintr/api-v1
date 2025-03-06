<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserSelectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($user) {
            return [
                'id' => $user->id,
                'title' => $user->title ?? $user->name,
                'attributes' => [
                    'email' => $user->email,
                    'status' => $user->status,
                ],
            ];
        })->toArray();
    }
}
