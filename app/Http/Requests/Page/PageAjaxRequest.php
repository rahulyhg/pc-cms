<?php

namespace App\Http\Requests\Page;

use App\Traits\Toggleable;
use Illuminate\Foundation\Http\FormRequest;

class PageAjaxRequest extends FormRequest
{
    use Toggleable;
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
            //
        ];
    }

}
