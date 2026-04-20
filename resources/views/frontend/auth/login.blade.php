@extends('frontend.master')
@section('content')
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style type="text/css">
    .site-link {
        padding: 5px 15px;
        position: fixed;
        z-index: 99999;
        background: #fff;
        box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
        right: 30px;
        bottom: 30px;
        border-radius: 10px;
    }

    .site-link img {
        width: 30px;
        height: 30px;
    }
</style>


<style>
    .body {
        background: #ff4931;
        transition: all .5s;
        padding: 1px;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .veen {
        width: 70%;
        margin: 100px auto;
        background: rgba(255, 255, 255, .5);
        min-height: 400px;
        display: table;
        position: relative;
        box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
    }

    .veen>div {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        color: #fff;
    }

    .veen button {
        background: transparent;
        /* background-image: linear-gradient(90deg, #e0b722, #ff4931); */
        display: inline-block;
        padding: 10px 30px;
        border: 3px solid #fff;
        border-radius: 50px;
        background-clip: padding-box;
        position: relative;
        color: #FFF;
        /* box-shadow: 0 0 4px rgba(0,0,0,.14), 0 4px 8px rgba(0,0,0,.28); */
        transition: all .25s;
    }

    .veen button.dark {
        border-color: #ff4931;
        background: #ff4931;
    }

    .veen .move button.dark {
        border-color: #e0b722;
        background: #e0b722;
    }

    .veen .splits p {
        font-size: 18px;
    }

    .veen button:active {
        box-shadow: none;
    }

    .veen button:focus {
        outline: none;
    }

    .veen>.wrapper {
        position: absolute;
        width: 40%;
        height: 120%;
        top: -10%;
        left: 5%;
        background: #fff;
        box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
        transition: all .5s;
        color: #303030;
        overflow: hidden;
    }

    .veen .wrapper>form {
        padding: 15px 30px 30px;
        width: 100%;
        transition: all .5s;
        background: #fff;
        width: 100%;
    }

    .veen .wrapper>form:focus {
        outline: none;
    }

    .veen .wrapper #login {
        padding-top: 20%;
        visibility: visible;
    }

    .veen .wrapper #register {
        transform: translateY(-80%) translateX(100%);
        visibility: hidden;
    }

    .veen .wrapper.move #register {
        transform: translateY(-80%) translateX(0%);
        visibility: visible;
    }

    .veen .wrapper.move #login {
        transform: translateX(-100%);
        visibility: hidden;
    }

    .veen .wrapper>form>div {
        position: relative;
        margin-bottom: 15px;
    }

    .veen .wrapper label {
        position: absolute;
        top: -7px;
        font-size: 12px;
        white-space: nowrap;
        background: #fff;
        text-align: left;
        left: 15px;
        padding: 0 5px;
        color: #999;
        pointer-events: none;
    }

    .veen .wrapper h3 {
        margin-bottom: 25px;
    }

    .veen .wrapper input {
        height: 40px;
        padding: 5px 15px;
        width: 100%;
        border: solid 1px #999;
    }

    .veen .wrapper input:focus {
        outline: none;
        border-color: #ff4931;
    }

    .veen>.wrapper.move {
        left: 45%;
    }

    .veen>.wrapper.move input:focus {
        border-color: #e0b722;
    }

    /* Social Login Buttons */
    .social-login {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    .social-login p {
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
    }
    .social-btn {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .social-btn a {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
        border: 1px solid #ddd;
        color: #333;
        background: #fafafa;
    }
    .social-btn a:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .social-btn .google-btn { border-color: #4285f4; color: #4285f4; }
    .social-btn .google-btn:hover { background: #4285f4; color: #fff; }
    .social-btn .facebook-btn { border-color: #1877f2; color: #1877f2; }
    .social-btn .facebook-btn:hover { background: #1877f2; color: #fff; }

    .forgot-link {
        display: block;
        text-align: right;
        font-size: 12px;
        color: #1a73e8;
        text-decoration: none;
        margin-top: -5px;
        margin-bottom: 10px;
    }
    .forgot-link:hover { text-decoration: underline; }

    @media (max-width: 767px) {
        .veen {
            padding: 5px;
            margin: 0;
            width: 100%;
            display: block;
        }

        .veen>.wrapper {
            position: relative;
            height: auto;
            top: 0;
            left: 0;
            width: 100%;
        }

        .veen>div {
            display: inline-block;
        }

        .splits {
            width: 50%;
            background: #fff;
            float: left;
        }

        .splits button {
            width: 100%;
            border-radius: 0;
            background: #505050;
            border: 0;
            opacity: .7;
        }

        .splits button.active {
            opacity: 1;
        }

        .splits button.active {
            opacity: 1;
            background: #ff4931;
        }

        .splits.rgstr-btn button.active {
            background: #e0b722;
        }

        .splits p {
            display: none;
        }

        .veen>.wrapper.move {
            left: 0%;
        }
    }

    input:-webkit-autofill,
    textarea:-webkit-autofill,
    select:-webkit-autofill {
        box-shadow: inset 0 0 0 50px #fff
    }
</style>

<div class="body">
    <div class="veen">
        <div class="login-btn splits">
            <p>Already an user?</p>
            <button class="active">Login</button>
        </div>
        <div class="rgstr-btn splits">
            <p>Don't have an account?</p>
            <button>Register</button>
        </div>
        <div class="wrapper">
            <!-- login from-->
           <form id="login" tabindex="500" action="{{route('customer.login.submit')}}" method="POST">
                @csrf
                <h3>Login</h3>
                <div class="mail">
                    <input type="text" name="login" required>
                    <label>Email or Phone Number</label>
                </div>
                <div class="passwd">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <a href="{{ route('customer.password.forgot') }}" class="forgot-link">Forgot Password?</a>
                <div class="submit">
                    <button class="dark" type="submit">Login</button>
                </div>

                {{-- Social Login --}}
                <div class="social-login">
                    <p>Or login with</p>
                    <div class="social-btn">
                        <a href="{{ route('customer.auth.google') }}" class="google-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Google
                        </a>
                    </div>
                </div>
            </form>

            <!--register from -->

            <form id="register" tabindex="502" action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3>Register</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="name">
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    <label>Full Name</label>
                </div>
                <div class="mail">
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    <label>E-Mail</label>
                </div>
                <div class="uid">
                    <input type="text" name="phone" value="{{ old('phone') }}" required>
                    <label>phone </label>
                </div>
                <div class="passwd">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="passwd">
                    <input type="password" name="password_confirmation" required>
                    <label>Confirm Password</label>
                </div>
                <div class="submit">
                    <button class="dark">Register</button>
                </div>

                {{-- Social Login --}}
                <div class="social-login">
                    <p>Or register with</p>
                    <div class="social-btn">
                        <a href="{{ route('customer.auth.google') }}" class="google-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Google
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".veen .rgstr-btn button").click(function() {
            $('.veen .wrapper').addClass('move');
            $('.body').css('background', '#e0b722');
            $(".veen .login-btn button").removeClass('active');
            $(this).addClass('active');

        });
        $(".veen .login-btn button").click(function() {
            $('.veen .wrapper').removeClass('move');
            $('.body').css('background', '#ff4931');
            $(".veen .rgstr-btn button").removeClass('active');
            $(this).addClass('active');
        });
    });
</script>



@endsection
