<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\CrudRequest;
use App\Models\User;

class UserFormRequest extends CrudRequest
{
    protected $type = User::class;

    /**
     * Rules when editing resource.
     *
     * @return array
     */
    protected function editRules()
    {
        $rules = [
            'name' => ['required', 'string'],
            'password' => ['sometimes', 'nullable', 'string', 'min:6'],
            'phone' => ['required', 'string'],
            'cpf' => ['required', 'string', 'min:11'],
            'birth_date' => ['required', 'date'],
            'image' => ['nullable'],
            'profile' => ['sometimes', 'required', 'string'],
        ];

        return $rules;
    }

    /**
     * Rules when creating resource.
     *
     * @return array
     */
    protected function createRules()
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required', 'string'],
            'cpf' => ['required', 'string', 'min:11', 'unique:users,cpf'],
            'birth_date' => ['required', 'date'],
            'image' => ['nullable', 'string_or_image'],
            'profile' => ['required'],
        ];

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function baseRules()
    {
        return [];
    }
}
