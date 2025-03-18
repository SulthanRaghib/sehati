<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="{{ url('_partials/css/bootstrap.css') }}" />

    <link rel="shortcut icon" href="{{ url('_partials/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ url('_partials/css/app.css') }}" />
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" height="48"
                                    class="mb-4" />
                                <h3>Login</h3>
                                <p>Sign in to your account to continue</p>
                            </div>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="form-group position-relative has-icon-right">
                                    <label for="email">Email</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="email" name="email" />
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                    {{-- get pesan error --}}
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-right">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password" />
                                        {{-- buat icon eye dengan id togglePassword --}}
                                        <div class="form-control-icon">
                                            <button type="button" id="togglePassword" class="btn btn-icon-sm p-0">
                                                <i data-feather="eye-off"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- get pesan error --}}
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="clearfix">
                                    <button class="btn btn-primary float-right">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // toggle password
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function(e) {
            // toggle icon eye
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = `<i data-feather="${type === 'password' ? 'eye-off' : 'eye'}"></i>`;
            // jalankan kembali feather icons
            feather.replace();
        });
    </script>

    <script src="{{ url('_partials/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ url('_partials/js/app.js') }}"></script>

    <script src="{{ url('_partials/js/main.js') }}"></script>
</body>

</html>
