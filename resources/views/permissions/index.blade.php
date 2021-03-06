@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 file_browser">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="form-group">
                                <br>
                                <select id="permissions" class="form-control">
                                    @foreach (\App\Models\Company\Company::getList(true) as $companyId => $companyName)
                                        <option value="{{ $companyId }}">
                                            {{ $companyName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{ route('dashboard.index') }}">
                                <h2 class="not_active">File Browser</h2>
                            </a>
                            <h2 class="active_state" style="margin-left: 5px;">Group Permissions</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <p class="alert alert-info">Please select a company to manage permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
