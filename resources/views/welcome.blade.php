<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ asset('css/jquery.datetimepicker.min.css') }}" rel="stylesheet" type="text/css">

    <title>Laravel</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="card uper">
            <div class="card-header">
                Add Event
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form method="post" action="{{ route('gcalendar.store') }}">
                    <div class="form-group">
                        @csrf
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone :</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="datetimepicker">Date&Time :</label>
                        <input id="datetimepicker" name="datetimepicker" class="form-control" type="text" value="{{ old('datetimepicker') }}">
                    </div>
                    <div class="form-group row {{ $errors->has('captcha') ? 'has-error' : '' }}">
                        <div class="col-md-4 captcha">
                            <small>If you are receiving CAPTCHA error, please click Refresh button before your next attempt, even if the code has changed. Thank you.</small>
                            <span>{!! captcha_img() !!}</span>
                            <button tabindex="-1" type="button" onclick="call_captcha();" class="pull-right btn btn-default">Refresh</button>
                        </div>
                        <div class="col-md-6 {{ $errors->has('captcha') ? 'has-error' :'' }}">
                            <input type="text" id="captcha" name="captcha"
                                   autocomplete="off"
                                   class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Captcha">
                            @if ($errors->has('captcha'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{!! $errors->first('captcha') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $( function() {
        $('#datetimepicker').datetimepicker({
            {{--format: '{{ config('app.date_format_js') }}'--}}
        });
    });
    function call_captcha() {
        $.ajax({
            type: 'GET',
            url: "{{route('refresh_captcha')}}",
            success: function (data) {
                $('.captcha span').html(data);
            }
        });
    }

    function closeAlert() {
        $('.alert').remove();
    }
</script>
</html>
