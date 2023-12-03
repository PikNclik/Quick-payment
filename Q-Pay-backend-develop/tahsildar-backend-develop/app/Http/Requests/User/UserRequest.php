<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = User::where('id', $this->route('user'))->first();
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
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
            case 'PUT':
                return [
                    'full_name' => ['required', 'string', 'min:5', 'max:255'],
                    'bank_id' => ['nullable', Rule::exists('banks', 'id')],
                    'city_id' => ['required', Rule::exists('cities', 'id')],
                    'bank_account_number' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'email', 'max:255',
                        Rule::unique('users', 'email')->ignore(Auth::id())],
                    'files' => ['nullable', 'array','min:0','max:1'],
              ];
        }
        return [];
    }
}
