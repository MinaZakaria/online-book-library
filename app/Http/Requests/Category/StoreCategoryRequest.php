<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends ApplicationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $currentUser = Auth::user();
        return $currentUser->isAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:categories',
        ];
    }
}
