<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'avatar' => 'image|mimes:jpg,jpeg,svg,png,gif|max:1024|dimensions:width=128, height=128',
            'locale' => [
                'required',
                Rule::in(array_keys(User::LOCALES))
            ]
        ];
    }
}
