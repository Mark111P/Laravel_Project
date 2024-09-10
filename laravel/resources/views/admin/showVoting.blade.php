<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/voting.css')}}">
    <title>Voting</title>
</head>
<body class="formBody">
<form class="votingForm" action="{{route('admin')}}">
    <div class="titleDiv">Voting</div>

    <span>Name</span><input type="text" value="{{$voting->name}}" disabled>
    <span>Votes</span>

    <div id="votes">
        @foreach($votes as $vote => $count)
            <div class="voteDiv">{{$vote}} <span>({{$count}})</span></div>
        @endforeach
    </div>

    <span>Start at</span><input type="text" value="{{$voting->start_at}}" disabled>
    <span>End at</span><input type="text" value="{{$voting->end_at}}" disabled>
    <button class="votingButton">Home</button>
</form>
</body>
</html>
