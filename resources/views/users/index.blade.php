@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> Users</h2>
                <span class="right">
                    <a class="btn btn-default" href="{{ route('users.create') }}">
                        <i class="fa fa-plus"></i> Add New User
                    </a>
                </span>         
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <br>
                            <select id="company" class="form-control">
                                <option value="">Select Company</option>
                                <option value="no-company" @if(app('request')->company_id == 'no-company') selected @endif>No Company Selected</option>

                                @foreach (\App\Models\Company\Company::all() as $singleCompany)
                                    <option value="{{ $singleCompany->id }}" @if(app('request')->company_id == $singleCompany->id) selected @endif>
                                        {{ $singleCompany->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                @if (!$users || !$users->count())
                    <p class="alert alert-info">There are no users found.</p>
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
                                                @if ($user->status === \App\Models\User\User::STATUS_ACTIVE)
                                                    <span class="green" style="margin-left: 15px;"></span>
                                                @else
                                                    <span class="red" style="margin-left: 15px;"></span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('m/d/Y') }}</td>
                                            <td class="center">
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if (!$user->is_admin)
                                                    <a href="{{ route('users.permissions.edit', $user->id) }}" class="btn btn-primary">
                                                        <i class="fa fa-cogs"></i>
                                                    </a>
                                                @endif

                                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                    <button class="btn btn-primary confirm">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
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
