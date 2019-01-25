<?php

namespace App\Http\Requests\Project;

use App\ProjectCategory;
use App\Traits\HasFiles;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    use HasFiles;
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
        $category = $this->route('category');
        return [
            'name' => 'required|max:255',
            'slug' => 'max:255|unique:blog_categories'. (isset($category) ? ',slug,' . $category->id : null),
            'imageThumbnail[]' => 'image|max:2048'
        ];
    }

    public function storeCategory()
    {
        $name = $this->input('name');
        $slug = $this->input('slug');
        ProjectCategory::create([
            'name' => $name,
            'slug' => isset($slug) ? str_slug($slug) : str_slug($name),
            'description' => $this->input('description'),
            'published' => $this->has('saveAndPublish'),
            'thumbnail' =>  $this->hasFile('imageThumbnail') ?  $this->uploadFiles($this->file('imageThumbnail'), ProjectCategory::uploadDir()) : null
        ]);
    }

    public function updateCategory(ProjectCategory $category)
    {
        $name = $this->input('name');
        $slug = $this->input('slug');

        $this->hasFile('imageThumbnail') ?  $category->thumbnail = $this->uploadFiles($this->file('imageThumbnail'), ProjectCategory::uploadDir()) : null;
        $category->name = $name;
        $this->has('slug') && $slug !== $category->slug ? str_slug($slug) : null;
        $category->description = $this->input('description');
        $category->published = $this->has('saveAndPublish');
        $category->isDirty() ? $category->save() : null;
        return $category;
    }
}
