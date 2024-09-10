<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Login</title>
</head>
<body>
<script>
    async function buttonClick(){
        let login = document.getElementById('login').value;
        let password = document.getElementById('password').value;

        if (login.length > 0 && password.length > 0) {
            let url = "{{route('checkLogin')}}?login=" + login + "&password=" + password;
            let response = await fetch(url);
            if (response.ok) {
                let obj = await response.json();
                switch (obj['status']) {
                    case 'ok': {
                        let d = new Date();
                        d.setTime(d.getTime() + 60*60*1000);
                        let expires = "expires=" + d.toUTCString();
                        document.cookie = "login=" + obj['login'] + "; " + expires + "; path=/";
                        if (obj['role'] === 'user') {
                            window.location.href = "{{route('home')}}";
                        }
                        else if (obj['role'] === 'admin'){
                            window.location.href = "{{route('admin')}}";
                        }
                    }
                        break;

                    case 'loginError': {
                        document.getElementById('error').textContent = 'Wrong login';
                    }
                        break;

                    case 'passwordError': {
                        document.getElementById('error').textContent = 'Wrong password';
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
            document.getElementById('error').textContent = 'Fill all the fields';
        }
    }
    function inputChange(){
        document.getElementById('error').textContent = '';
    }
</script>
    <form class="loginForm" method="POST" onsubmit="return false">
        <div class="titleDiv">Login</div>
        <span>Login</span><input id="login" type="text" name="login" placeholder="Your login" oninput="inputChange()">
        <span>Password</span><input id="password" type="password" name="password" placeholder="Password" oninput="inputChange()">
        <div id="error" class="errorDiv"></div>
        <a href="{{route('register')}}">Register</a>
        <button class="loginButton" onclick="buttonClick()">Submit</button>
    </form>
</body>
</html>
