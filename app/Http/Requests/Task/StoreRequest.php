<?php

namespace App\Http\Requests\Task;

use App\Enums\Task\PriorityEnum;
use App\Enums\Task\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'status' => 'required|integer|in:' . implode(',', array_column(StatusEnum::cases(), 'value')),
            'priority' => 'required|integer|in:' . implode(',', array_column(PriorityEnum::cases(), 'value')),
            'incumbent_users' => 'array|required',
            'incumbent_users.*' => 'integer|exists:users,id',
        ];
    }
}
