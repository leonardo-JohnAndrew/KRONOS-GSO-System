<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storepurchase_request extends FormRequest
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
            'category' =>'string|required',
            'purpose'=>'string|required|max:255',
            'dateNeeded' => 'required|date|date_format:Y-m-d',
             'reason'=>'string|max:255', 
             'remark'=>'string', 
             'notification'=>'string',
             'materials' => 'array|nullable'
        ];

      


    }
}
