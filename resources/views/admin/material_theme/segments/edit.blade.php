@extends('admin.material_theme.layout')

@section('module_name')
    Segments
@endsection

@section('content')

    <?php
        $module_name = 'segments';
    ?>

    <div class="row">
        {!! Form::open([
                     'route' => [getRouteName($module_name, 'update'), $segment->id],
                     'method' => 'put',
                     'id' => 'editSegmentForm',
                     'novalidate' => 'novalidate',
                     'files' => true
                     ]) !!}
        <div class="col-xs-12 col-md-6">
            <div class="card">
                <header class="card-heading ">
                    <h2 class="card-title">Edit - {{ $segment->name }}</h2>
                </header>
                <div class="card-body">

                    <div class="form-group">
                        {!! Form::label(null, 'Segment name') !!}
                        {!! Form::text('name', $segment->name, ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label(null, 'Segment content') !!}
                        {!! Form::textarea('content', $segment->content, ['class' => 'form-control pc-cms-editor']) !!}
                    </div>

                    <button type="submit" class="btn btn-primary pc-cms-loader-btn" data-form="#editSegmentForm">Save</button>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    @include('admin.material_theme.components.forms.uploadImage', [
                                    'filedName' => 'segmentImage',
                                    'id' => 'segmentImage',
                                    'label' => 'Image',
                                    'placeholder' => 'Choose additional image',
                                    'previewContainerId' => 'segmentImagePreview',
                                    'multiple' => false,
                                    'editState' => true,
                                    'image' => $segment->image,
                                    'dir' => 'segments',
                                    'noImageInputName' => 'noImage'
                                ])
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

            $('#editSegmentForm').validate();
        })();
    </script>

@endpush