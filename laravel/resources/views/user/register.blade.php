<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Register</title>
</head>
<body>
<script>
    async function buttonClick(){
        let name = document.getElementById('name').value.trim();
        let login = document.getElementById('login').value.trim();
        let password = document.getElementById('password').value.trim();

        if (name.length >= 2 && login.length >= 3 && password.length >= 8) {
            let url = "{{route('checkRegister')}}?name=" + name + "&login=" + login + "&password=" + password;
            let response = await fetch(url);
            if (response.ok) {
                let obj = await response.json();
                console.log(obj);
                switch (obj['status']) {
                    case 'ok': {
                        document.getElementById('error').textContent = 'Registered';
                    }
                        break;

                    case 'loginError': {
                        document.getElementById('error').textContent = 'Wrong login';
                    }
                        break;

                    case 'error': {
                        document.getElementById('error').textContent = 'Error';
                    }
                        break;
                }
            }
        }
        else{
            document.getElementById('error').textContent = 'Too short info';
        }
    }
    function inputChange(){
        document.getElementById('error').textContent = '';
    }
</script>
<form class="loginForm" method="POST" onsubmit="return false">
    <div class="titleDiv">Register</div>
    <span>Name</span><input id="name" type="text" name="name" placeholder="Your name (2+)" oninput="inputChange()">
    <span>Login</span><input id="login" type="text" name="login" placeholder="Login (3+)" oninput="inputChange()">
    <span>Password</span><input id="password" type="password" name="password" placeholder="Password (8+)" oninput="inputChange()">
    <div id="error" class="errorDiv"></div>
    <a href="{{route('login')}}">Login</a>
    <button class="loginButton" onclick="buttonClick()">Submit</button>
</form>
</body>
</html>
