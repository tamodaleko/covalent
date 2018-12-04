@extends('layouts.auth')

@section('content')
<div class="row log-in-page">
    <div class="col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">
                
                <h1>Unathorized action</h1>
                
                <div class="col-xs-12">
                    <p></p>
                </div>
                <div class="col-xs-12">
                    <a href="{{ url('/') }} " class="btn btn-success">
                        <i class="fa fa-forward"> </i>
                        Go Back
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
