<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Updatemf_CompanyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'file'=>'Nullable|image|mimes:png,jpg,jpeg|max:7000'

        ];
    }
}
