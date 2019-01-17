@extends('layouts.auth')

@section('title', 'Activate Account')

@section('content')
<div class="row log-in-page" style="margin-bottom: 0px;">
    <div class="col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">
                <form>
                    <h1>Activate Account</h1>

                    <div class="alert alert-success fade in">
                        @if ($result)
                            Your email address is verified. Your account will be activated in a few hours.
                        @else
                            The token is invalid.
                        @endif
                    </div>

                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
