@extends('admin.material_theme.layout')

@section('module_name')
    Roles
@endsection

@section('content')

    <?php
        $module_name = 'roles';
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <header class="card-heading">
                    <h2 class="card-title">Roles list</h2>
                    <ul class="card-actions icons right-top">
                        <li class="dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" aria-expanded="false">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu btn-primary dropdown-menu-right">
                                <li><a href="{{ route(config('admin.modules.roles.actions.create.route_name')) }}">Create new</a></li>
                            </ul>
                        </li>
                    </ul>
                </header>
                <div class="card-body">
                    <div>
                        <div>
                            <?php
                            $args = [
                                'delete' => [
                                    'button_label' => 'Remove selected items',
                                    'button_class' => 'btn-danger',
                                ]
                            ];
                            ?>
                            {!! MassActions::setMassActions($module_name, NULL, $args) !!}
                        </div>
                        {{-- Search --}}
                        <div></div>
                    </div>
                    <table class="table table-hover pc-cms-table">
                        <thead>
                        <tr>
                            <th><div class="checkbox"><label><input class="pc-selectable-input-all" type="checkbox"></label></div></th>
                            <th><a href="{{ getSortUrl('name', NULL, 'roles') }}">Role name</a></th>
                            <th><a href="{{ getSortUrl('created_at', NULL, 'roles') }}">Created at</a></th>
                            <th><a href="{{ getSortUrl('updated_at', NULL, 'roles') }}">Updated at</a></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($roles) > 0)
                            @foreach($roles as $role)
                                <tr class="pc-selectable-row">
                                    <td><div class="checkbox"><label><input type="checkbox" class="pc-selectable-input" data-item-id="{{ $role->id }}"></label></div></td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>{{ $role->updated_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('admin.users.roles.setPermissions', ['role' => $role->id]) }}">Set permissions</a></li>
                                                <li><a href="{{ url(route(getRouteName('roles', 'edit'), $role->id)) }}">Edit</a></li>
                                                @if ($role->allow_remove)
                                                    <li>
                                                        {!! Form::open(['method' => 'delete', 'route' => [getRouteName('roles', 'destroy'), $role->id], 'id' => 'roleRemoveForm-' . $role->id, 'style' => 'position: absolute']) !!}
                                                        {!! Form::close() !!}
                                                        <a href="#" class="pc-cms-remove-item" data-form="#roleRemoveForm-{{$role->id}}">Remove</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  