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
                            <h2><i class="fa fa-cogs"></i> Permissions</h2>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <br>
                                <select id="permissions" class="form-control">
                                    <option value="">Select Company</option>

                                    @foreach (\App\Models\Company\Company::all() as $singleCompany)
                                        <option value="{{ $singleCompany->id }}">
                                            {{ $singleCompany->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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
