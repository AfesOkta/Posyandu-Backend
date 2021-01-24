<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosyanduRequest extends FormRequest
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
    public function rules()
    {
        return [
            //
            'posyandu_kode' => 'required|alpha_num|max:5',
        ];
    }

    public function messages()
    {
        return [
            'posyandu_kode.required' => 'Kode Posyandu harus diisi!!!',
        ];
    }
}
