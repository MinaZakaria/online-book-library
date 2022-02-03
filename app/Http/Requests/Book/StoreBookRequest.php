<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookRequest extends ApplicationRequest
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
        $categoryId = (int) $this->route('categoryId');

        return [
            'name' => 'required|string|max:100|unique:books',
            'author' => 'required|string|max:100',
            'categoryId' => 'required|int|min:1|matched:'.$categoryId
        ];
    }
}
