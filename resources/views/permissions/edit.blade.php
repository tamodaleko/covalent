@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 file_browser">
                    <div class="x_panel">
                        <div class="x_title" style="margin-bottom: 0;">
                            <h2><i class="fa fa-cogs"></i> Permissions</h2>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <br>
                                <select id="permissions" class="form-control">
                                    <option value="">Select Company</option>

                                    @foreach (\App\Models\Company\Company::all() as $singleCompany)
                                        <option value="{{ $singleCompany->id }}" @if($company->id === $singleCompany->id) selected @endif>
                                            {{ $singleCompany->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            @if (!$users->count())
                                <p class="alert alert-info">Selected company has no users assigned.</p>
                            @elseif (!$folders)
                                <p class="alert alert-info">Selected company has no folders assigned.</p>
                            @else

                                {!! Form::open(['route' => ['permissions.update', 'id' => $company->id]]) !!}

                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <br />
                                            <div class="form-group">
                                                {{ Form::label('folders', 'Users:') }}
                                                
                                                <select name="users[]" class="select2-multiple2" multiple style="width: 100%;">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <br />
                                            <div class="form-group">
                                                {{ Form::label('folders', 'Folders:') }}
                                                
                                                <ul class="tree-file">
                                                    @foreach ($folders as $folder)
                                                        @include('partials.permissions.folders', ['selected' => []])
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                            @if ($users->count() && $folders)
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fa fa-check"></i> Save
                                                </button>
                                            @endif

                                            <a href="{{ route('permissions.index') }}" class="btn btn-default">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </div>
                                
                                {!! Form::close() !!}

                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
