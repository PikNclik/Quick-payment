<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransactionToDoRequest extends MainRequest
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
            case 'DELETE':
            case 'POST':
                return [];

            case 'PUT':
                return [
                    'due_date' => ['required', 'date','date_format:Y-m-d']
                ];
        }
        return [];
    }
}
