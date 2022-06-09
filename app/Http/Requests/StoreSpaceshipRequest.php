<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpaceshipRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'class' => ['required', 'string'],
            'crew' => ['required', 'integer', 'numeric', 'min:0'],
            'image' => ['required', 'string', 'min:0'],
            'value' => ['required', 'numeric', ],
            'status' => ['required', 'string'],
            'armament' => ['required', 'array'],
            'armament.*.title' => ['required', 'string'],
            'armament.*.qty' => ['required', 'integer', 'numeric', 'min:0'],
        ];
    }
}
