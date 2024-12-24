<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use App\Models\User;
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
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST': return [
                'full_name' => ['required', 'string', 'min:5', 'max:255'],
                'active' => ['boolean'],
                'phone' => ['required','string','max:20'],
                'bank_id' => ['nullable', Rule::exists('banks', 'id')],
                'city_id' => ['nullable', Rule::exists('cities', 'id')],
                'webhook_url' => ['nullable', 'string','max:255'],
                'bank_account_number' => ['required', 'string', 'max:255']

            ];
            case 'PUT':
                return [
                    'full_name' => [ 'string', 'min:5', 'max:255'],
                    'active' => ['boolean'],
                    'phone' => ['string','max:20'],
                    'bank_id' => ['nullable', Rule::exists('banks', 'id')],
                    'city_id' => ['nullable', Rule::exists('cities', 'id')],
                    'webhook_url' => ['nullable', 'string','max:255'],
                    'profession_id'=>['nullable'],
                    'business_name' => [
                        'nullable',
                        'string',
                        'max:255'
                    ],
                ];
        }
        return [];
    }
}
