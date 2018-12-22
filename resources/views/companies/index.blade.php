@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> Companies</h2>
                <span class="right">
                    <a class="btn btn-default" href="{{ route('companies.create') }}">
                        <i class="fa fa-plus"></i> Add New Company
                    </a>
                </span>         
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="clearfix"></div>

                @if (!$companies->count())
                    <p class="alert alert-info">There are no companies found.</p>
                @else
                    <div class="dashboard-widget-content a">
                        <div class="contentfrefix" id="contentfrefix1">
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Users</th>
                                        <th>Folders</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="content-file">
                                    @foreach ($companies as $company)
                                        <tr class="odd gradeX">
                                            <td>#{{ $company->id }}</td>
                                            <td>
                                                @if ($company->logo)
                                                    <img src="/uploads/images/companies/{{ $company->logo }}" alt="{{ $company->name }}">
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td>{{ $company->name }}</td>
                                            <td>
                                                @if (!count($company->users))
                                                    <span>-</span>
                                                @endif
                                                
                                                @foreach ($company->users as $user)
                                                    {{ $user->name }}<br />
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($folders = \App\Models\Folder::getAllowedByCompany($company))
                                                    @foreach ($folders as $folder)
                                                        /{{ $folder->getPath() }}<br />
                                                    @endforeach
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($company->status === \App\Models\Company\Company::STATUS_ACTIVE)
                                                    <span style="color: green;"><b>Active</b></span>
                                                @else
                                                    <span style="color: orange;"><b>In-Active</b></span>
                                                @endif
                                            </td>
                                            <td class="center">
                                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a href="{{ route('companies.permissions.edit', $company->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-cogs"></i>
                                                </a>

                                                {!! Form::open(['method' => 'DELETE','route' => ['companies.destroy', $company->id], 'style' => 'display:inline']) !!}
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
