<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use App\Models\Admin;
use Illuminate\Validation\Rule;

class PermissionCategoryRequest extends MainRequest
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

        // switch ($this->method()) {
        //     case 'GET':
        //     case 'DELETE':
        //         return [];
        //     case 'PUT':
        //     case 'POST':
        //         return [
        //             'name' => ['required', 'string', 'min:3', 'max:100'],
        //         ];
        // }
        return [];
    }
}
