<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique:products",
            "brand" => "required"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = [];
        if (!empty($validator->errors()->getMessages())) {
            foreach ($validator->errors()->getMessages() as $key => $item_error) {
                $errors[] = $item_error[0];
            }
        }
        
        $response = response()->json([
            "message" => $errors
        ], 422);

        throw new HttpResponseException($response);
    }
}
