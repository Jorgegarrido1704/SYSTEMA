<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="indexstyle.css">
    <link rel="shortcut icon" href="../main/fth.ico" type="image/x-icon">
</head>
<body>
    <div align="center" id="title">
        <h1>CVST By <span style="color:red;">Jorge Garrido</span></h1>
        <div id="frm">
            <form name="f1" action="{{ route('store') }}" onsubmit="return validation()" method="POST">
                @csrf
                <p>
                    <label>UserName:</label>
                    <input type="text" id="user" name="user" />
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" id="pass" name="password" />
                </p>
                <p align="center">
                    <input type="submit" id="btn" value="Login" />
                </p>
            </form>
        </div>
    </div>

    <script>
        function validation() {
            var id = document.f1.user.value;
            var ps = document.f1.pass.value;
            if (id.trim() === "" && ps.trim() === "") {
                alert("Username and Password fields are empty");
                return false;
            } else if (id.trim() === "") {
                alert("Username is empty");
                return false;
            } else if (ps.trim() === "") {
                alert("Password field is empty");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
