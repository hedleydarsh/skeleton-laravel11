<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Type of class being validated.
     *
     * @var string
     */
    protected $type = 'App\\Models\\Model';

    /**
     * Form params
     */
    public function params(): array
    {
        return $this->all();
    }

    /**
     * Define nice names for attributes.
     */
    public function attributes(): array
    {
        return [];
    }
}
