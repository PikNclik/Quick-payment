<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatisticsRrequest extends MainRequest
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
        switch ($this->method()) {
            case 'GET':
                return [
                'date' => ['date','date_format:Y-m-d'],
                'start' => ['date','date_format:Y-m-d'],
                'end' => ['date','date_format:Y-m-d'],
                'user_id' => ['nullable',Rule::exists('users','id')],
                ];
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
            default:
                break;
        }
        return [];
    }
}
