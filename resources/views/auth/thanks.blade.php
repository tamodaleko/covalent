@extends('layouts.auth')

@section('title', 'Thank You')

@section('content')
<div class="row log-in-page" style="margin-bottom: 0px;">
    <div class="col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">
                <form>
                    <h1>Thank You</h1>

                    <div class="alert alert-success fade in">
                        Your registration request has been received. A verification email has been sent to the email address you provided. Please click the verification link in that email. It may take a few hours to activate your account due to security protocols.
                    </div>

                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
