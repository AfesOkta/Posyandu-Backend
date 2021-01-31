<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaderRequest extends FormRequest
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
            'kader_kode' => 'required|alpha_num|max:5',
            'posyandu_id'=> 'required',
        ];
    }

    public function messages()
    {
        return [
            'posyandu_id.required' => 'Kode Posyandu harus diisi!!!',
            'kader_kode.required'    => 'Kode Kader harus diisi!!!',
        ];
    }
}
