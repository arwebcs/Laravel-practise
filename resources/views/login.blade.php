<!DOCTYPE html>

<html>

<head>
    <title>Laravel CRUD :: Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ URL::asset('css/demo.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/page-auth.css') }}" />
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/login" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder">Sneat</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Laravel CRUD</h4>
                        <p class="mb-4">Please sign-in to your account</p>
                        <div class="text-danger">
                            @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>

                        <form id="formAuthentication" class="mb-3" action="/getlogin" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" />
                                <b class="text-danger">@error("username"){{ $message }}@enderror</b>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="userpass" placeholder="Enter password" />
                                <b class="text-danger">@error("userpass"){{ $message }}@enderror</b>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->
    <script src="{{ URL::asset('js/helpers.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.js') }}"></script>
    <script src="{{ URL::asset('js/menu.js') }}"></script>
    <script src="{{ URL::asset('js/main.js') }}"></script>
</body>

</html>