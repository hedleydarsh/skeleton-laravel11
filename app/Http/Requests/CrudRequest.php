<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class CrudRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge_recursive(
            $this->baseRules(),
            $this->isMethod('put')
                ? $this->editRules()
                : $this->createRules()
        );
    }

    /**
     * Rules when editing resource.
     *
     * @return array
     */
    protected function editRules()
    {
        return [];
    }

    /**
     * Rules when creating resource.
     *
     * @return array
     */
    protected function createRules()
    {
        return [];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Base rules for both creating and editing the resource.
     *
     * @return array
     */
    abstract protected function baseRules();

    public function withValidator($validator)
    {
        $validator->addExtension('string_or_image', function ($attribute, $value, $parameters, $validator) {
            // Verifica se o valor é uma string
            if (is_string($value)) {
                return true;
            }

            // Verifica se o valor é uma instância de UploadedFile (imagem)
            if ($value instanceof \Illuminate\Http\UploadedFile && $value->isValid()) {
                // Adicione aqui quaisquer outras validações específicas para imagens, se necessário
                return true;
            }

            return false;
        });
    }
}
