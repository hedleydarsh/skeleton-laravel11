<?php

namespace App\Http\Requests\Api\V1\Permission;

use App\Http\Requests\CrudRequest;
use Spatie\Permission\Models\Permission;

class PermissionRequest extends CrudRequest
{
    protected $type = Permission::class;

    /**
     * Rules when editing resource.
     *
     * @return array
     */
    protected function editRules()
    {
        $rules = [];

        return $rules;
    }

    /**
     * Rules when creating resource.
     *
     * @return array
     */
    protected function createRules()
    {
        $rules = [];

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
