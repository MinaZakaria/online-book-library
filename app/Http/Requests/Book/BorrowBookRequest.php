<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\ApplicationRequest;

class BorrowBookRequest extends ApplicationRequest
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
            'startDate' => 'required|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'endDate' => 'required|date_format:Y-m-d|after:startDate',
        ];
    }
}
