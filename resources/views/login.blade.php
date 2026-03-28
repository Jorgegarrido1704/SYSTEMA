<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Login') }}</title>

    <link rel="stylesheet" href="css/indexstyle.css">
    <link rel="shortcut icon" href="../main/fth.ico" type="image/x-icon">

    <!-- Estilos rápidos -->
    <style>
        body {
            background: linear-gradient(135deg, #88a0c3, #970101e0);
            font-family: Arial, sans-serif;
            color: white;
        }

        #title {
            margin-top: 80px;
        }

        #frm {
            background: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #btn {
            width: 100%;
            padding: 10px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #btn:hover {
            background: #1d4ed8;
        }

        .lang-switch {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .lang-switch a {
            color: white;
            margin-left: 10px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Botón idioma -->
    <div class="lang-switch">
        <a href="{{ url('lang/es') }}">ES</a> |
        <a href="{{ url('lang/en') }}">EN</a>
    </div>

    <div align="center" id="title">
        <h1>
            {{ __('Welcome') }} {{ __('to') }} CVTS
            By <span style="color:red;">Jorge Garrido</span>
        </h1>

        <div id="frm">
            <form name="f1" action="{{ route('store') }}" onsubmit="return validation()" method="POST">
                @csrf

                <p>
                    <label>{{ __('UserName') }}:</label>
                    <input type="text" id="user" name="user" />
                </p>

                <p>
                    <label>{{ __('Password') }}:</label>
                    <input type="password" id="pass" name="password" />
                </p>

                <p align="center">
                    <input type="submit" id="btn" value="{{ __('Login') }}" />
                </p>

            </form>
        </div>
    </div>

    <script>
        function validation() {
            var id = document.f1.user.value;
            var ps = document.f1.pass.value;

            if (id.trim() === "" && ps.trim() === "") {
                alert("{{ __('EmptyUserPassword') }}");
                return false;
            } else if (id.trim() === "") {
                alert("{{ __('EmptyUser') }}");
                return false;
            } else if (ps.trim() === "") {
                alert("{{ __('EmptyPassword') }}");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>
