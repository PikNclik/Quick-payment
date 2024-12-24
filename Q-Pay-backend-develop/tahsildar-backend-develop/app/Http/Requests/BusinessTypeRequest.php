<?php

namespace App\Http\Requests;

use App\Models\BusinessType;

class BusinessTypeRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = BusinessType::where('id', $this->route('business_type'))->first();
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
            case 'PATCH':
            case 'DELETE':
            case 'PUT':
            case 'POST':
            default:
                break;
        }
        return [];
    }
}
