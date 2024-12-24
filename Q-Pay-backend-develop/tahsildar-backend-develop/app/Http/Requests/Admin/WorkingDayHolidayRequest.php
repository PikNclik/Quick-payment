<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;

class WorkingDayHolidayRequest extends MainRequest
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
        $super_admin = Auth::user()->tokenCan('super_admin');
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
        ];
        switch ($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
            return  $rules;
            default:
                break;
        }
        return [];
    }
}
