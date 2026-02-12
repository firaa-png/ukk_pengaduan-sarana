<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Apply Poppins across login page */
        body, input, button, .login-card, .login-title { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; }

        body {
            background: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            /* give a bit more room so longer kelas names don't get clipped */
            max-width: 520px;
            margin: 0 auto;
        }
 
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 100px;
            height: auto;
            object-fit: contain;
        }

        .login-title {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 25px;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 20px;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #4e73df;
            border-bottom: 2px solid #4e73df;
            background: transparent;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #e1e5eb;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: border-color 0.3s;
            color: #495057; /* ensure selects and inputs have visible text color */
        }

        select.form-control {
            -webkit-appearance: menulist; /* ensure native dropdown arrow and consistent padding */
            -moz-appearance: menulist;
            appearance: menulist;
            box-sizing: border-box;
            /* make the select taller and use readable font size so the selected value isn't tiny */
            height: 44px;
            padding: 10px 36px 10px 12px;
            font-size: 15px;
            line-height: 1.25;
            color: #495057;
            background-position: right 12px center;
            background-repeat: no-repeat;
            overflow: visible;
            white-space: nowrap; /* keep selected value on single line */
            text-overflow: ellipsis;
        }

        /* Dropdown list options should allow wrapping for long kelas names */
        select.form-control option {
            white-space: normal;
            padding: 6px 8px;
        }

        @media (max-width: 576px) {
            select.form-control {
                font-size: 14px;
                height: 42px;
            }
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-login {
            background: #4e73df;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #2e59d9uba ;
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .tab-content {
            padding-top: 15px;
        }

        .login-tabs {
            margin-bottom: 25px;
        }

        .tab-buttons {
            display: flex;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 20px;
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            cursor: pointer;
            position: relative;
            outline: none;
        }

        .tab-btn.active {
            color: #4e73df;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #4e73df;
        }

        .login-form {
            display: none;
        }

        .login-form.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 15px;
                padding: 20px;
            }

            .logo-container img {
                width: 80px;
            }
        }
        /* removed password visibility toggle styles */
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('sbadmin2/img/logo-SMK8.png') }}" alt="Logo SMKN 8">
            </div>

            <h2 class="login-title">Login Sekarang</h2>

            <div class="login-tabs">
                <div class="tab-buttons">
                    <button type="button" class="tab-btn active">Login</button>
                </div>

                <div id="login-main" class="login-form active">
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="identifier" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required aria-label="Password">
                        </div>
                        <button type="submit" class="btn btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

    <script>
        // keep a small submit guard for the single form and password toggle
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('#login-main form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var id = this.querySelector('input[name="identifier"]').value;
                    var pw = this.querySelector('input[name="password"]').value;
                    if (!id || !pw) {
                        e.preventDefault();
                        alert('Silakan isi Username/NIS dan Password');
                    }
                });
            }

            // No password toggle — simple password input
        });
    </script>
</body>

</html>