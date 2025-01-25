<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataStreamRequest extends FormRequest
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
        $k = $this->k;
        return [
            'stream' => 'required|string',
            'k' => 'required|integer|min:1',
            'top' => 'required|integer|min:1',
            'exclude' => 'sometimes|array',
            'exclude.*' => 'string|size:' . $k
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'statusCode'=> 500,
            'message' => $validator->errors()->first(),
            'result'=> null
        ]));
    }
}
