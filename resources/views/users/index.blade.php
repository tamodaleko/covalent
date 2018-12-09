@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> Users</h2>
                <span class="right">
                    <a class="btn btn-default" href="{{ route('users.create') }}">
                        <i class="fa fa-plus-square"></i> Add New User
                    </a>
                </span>         
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="clearfix"></div>

                @if (!$users->count())
                    <p class="alert alert-warning">There are no users found.</p>
                @else
                    <div class="dashboard-widget-content a">
                        <div class="contentfrefix" id="contentfrefix1">
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Company</th>
                                        <th>Admin</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="content-file">
                                    @foreach ($users as $user)
                                        <tr class="odd gradeX">
                                            <td>#{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->company ? $user->company->name : '-' }}</td>
                                            <td>
                                                @if ($user->is_admin)
                                                    <span style="color: green;"><b>Yes</b></span>
                                                @else
                                                    <span style="color: red;"><b>No</b></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->status === \App\Models\User::STATUS_ACTIVE)
                                                    <span style="color: green;"><b>Active</b></span>
                                                @else
                                                    <span style="color: orange;"><b>In-Active</b></span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('m/d/Y') }}</td>
                                            <td class="center">
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'confirm btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection