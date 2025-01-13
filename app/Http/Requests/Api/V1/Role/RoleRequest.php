<?php

namespace App\Http\Requests\Api\V1\Role;

use App\Http\Requests\CrudRequest;
use Spatie\Permission\Models\Role;

class RoleRequest extends CrudRequest
{
    protected $type = Role::class;

    /**
     * Rules when editing resource.
     *
     * @return array
     */
    protected function editRules()
    {
        return [
            'name'  => ['required', 'string'],
            'title' => ['required', 'string'],
        ];
    }

    /**
     * Rules when creating resource.
     *
     * @return array
     */
    protected function createRules()
    {
        return [
            'name'  =>  ['required', 'string', 'unique:roles,name'],
            'title' => ['required', 'string'],
        ];
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
