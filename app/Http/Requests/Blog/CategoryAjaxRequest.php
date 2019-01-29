<?php

namespace App\Http\Requests\Blog;

use App\BlogCategory;
use App\Traits\Toggleable;
use Illuminate\Foundation\Http\FormRequest;
use Validator;

class CategoryAjaxRequest extends FormRequest
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

    public function updateSlug(BlogCategory $category)
    {

        $validator = Validator::make($this->all(), [
            'slug' => 'required|max:255|unique:blog_categories'. (isset($category) ? ',slug,' . $category->id : null),
        ]);

        if ($validator->fails()) return [
            'message' => $validator->errors()->first(),
            'error' => true,
            'type' => 'error'
        ];

        $slug = $this->input('slug');
        $category->slug = str_slug($slug);
        $category->isDirty() && $category->save();
        return $category->slug;
    }
}
