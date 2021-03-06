@extends('admin::layout')

@section('module_name')
    Blog categories
@endsection

@section('content')

    <?php
    $module_name = 'blog_categories';
    ?>

    <div class="row">
        {!! Form::open([
            'method' => 'put',
            'route' => [getRouteName($module_name, 'update'), $category->id],
            'files' => true,
            'id' => 'editBlogCategoryForm',
            'novalidate' => 'novalidate'
        ]) !!}
        <div class="col-xs-12 col-md-8">
            <div class="card">
                <header class="card-heading">
                    <h2 class="card-title">Edit - {{ $category->name }}</h2>
                </header>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label(null, 'Category name') !!}
                        {!! Form::text('name', $category->name, ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                    </div>

                    <div class="form-group">
                        @include('admin::components.forms.slugField', ['route' => url(route('ajax.articles.categories.updateSlug', $category->id)), 'value' => $category->slug])
                    </div>

                    <div class="form-group">
                        {!! Form::label(null, 'Description') !!}
                        {!! Form::textarea('description', $category->description, ['class' => 'form-control pc-cms-editor']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input name="saveAndPublish" type="checkbox" @if($category->published) checked @endif> Save and publish
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary pc-cms-loader-btn" data-form="#editBlogCategoryForm">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::label(null, 'Parent category') !!}
                                <select name="parent_id" class="select form-control">
                                    <option></option>
                                    @if (count($categories) > 0)
                                        @foreach($categories as $_category)
                                            @if ($category->id !== $_category->id)
                                                <option
                                                        value="{{ $_category->id }}"
                                                        @if ($category->parent_id === $_category->id)
                                                        selected
                                                        @endif
                                                >{{ $_category->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                @include('admin::components.forms.uploadImage', [
                                    'filedName' => 'imageThumbnail',
                                    'id' => 'categoryThumbnail',
                                    'label' => 'Thumbnail',
                                    'placeholder' => 'Choose category image',
                                    'previewContainerId' => 'categoryThumbnailPreview',
                                    'editState' => true,
                                    'files' => $category->getFilesFrom('thumbnail'),
                                    'noFileInputName' => 'noImage'
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@push('admin.footer')

    <script>
        (function () {

            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight: function (elem) {
                    $(elem)
                        .closest('.form-group')
                        .addClass('has-error');
                },
                unhighlight: function (elem) {
                    $(elem)
                        .closest('.form-group')
                        .removeClass('has-error')
                }
            });

            $('#editBlogCategoryForm').validate();
        })();
    </script>

@endpush
