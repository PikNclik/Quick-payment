<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use App\Models\Admin;
use Illuminate\Validation\Rule;

class AdminRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = Admin::where('id', $this->route('admin'))->first();
        if ($model)
            switch ($this->method()) {
                case 'GET':
                case 'POST':
                case 'PUT':
                case 'PATCH':
                case 'DELETE':
                    break;
            }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'username' => ['required', 'string', 'min:3', 'max:100'],
                    'password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                    'role_id' => ['required', Rule::exists('roles', 'id')]

                ];
            case 'PUT':
                return [
                    'username' => ['required', 'string', 'min:3', 'max:100'],
                    'password' => ['nullable', 'string', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                    'role_id' => ['required', Rule::exists('roles', 'id')]
                ];
        }
        return [];
    }
}
