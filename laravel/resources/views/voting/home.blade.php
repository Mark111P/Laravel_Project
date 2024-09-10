<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/voting.css')}}">
    <title>Home</title>
</head>
<body>

<div class="topDiv">
    <span class="loginSpan">Your login: <span>{{$_COOKIE['login']}}</span></span>
    <form action="{{route('logout')}}">
        <button class="myButton">Logout</button>
    </form>
</div>
<div class="votingsDiv">
    <div class="titleDiv">Votings</div>
    @foreach($votings as $voting)
        <div class="votingDiv">
            <span>{{$voting->name}}</span>
            <form action="{{route('vote')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$voting->id}}">
                <button class="myButton">Show</button>
            </form>
        </div>
    @endforeach
</div>
</body>
</html>
