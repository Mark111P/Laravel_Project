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
<script>
    function changeSpan(vote){
        let votes = '{{$voting->votes}}'.split('|');
        for(let i = 0; i < votes.length; i++){
            if (votes[i] == vote){
                document.getElementById('span_' + votes[i]).textContent = '(Voted)';
            }
            else {
                document.getElementById('span_' + votes[i]).textContent = '';
            }
        }
    }

    async function buttonClick(){
        let vote = document.querySelector('input[name="vote"]:checked').value;
        let login = '{{$login}}';
        let voting_id = '{{$voting->id}}';

        if (vote.length > 0) {
            let url = "{{route('checkVote')}}?login=" + login + "&voting_id=" + voting_id + "&vote=" + vote;
            let response = await fetch(url);
            if (response.ok) {
                let obj = await response.json();
                switch (obj['status']) {
                    case 'added': {
                        document.getElementById('error').textContent = 'Vote added';

                        changeSpan(obj['vote']);
                        document.getElementById('vote_' + obj['vote']).checked;
                    }
                        break;

                    case 'updated': {
                        document.getElementById('error').textContent = 'Vote changed';

                        changeSpan(obj['vote']);
                        document.getElementById('vote_' + obj['vote']).checked;
                    }
                        break;

                    case 'wrongVote': {
                        document.getElementById('error').textContent = 'Wrong vote';
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
            document.getElementById('error').textContent = 'Choose vote';
        }
    }
    function inputChange(){
        document.getElementById('error').textContent = '';
    }
</script>
<form class="votingForm" onsubmit="return false">
    <div class="titleDiv">Voting</div>

    <span>Name</span><input type="text" value="{{$voting->name}}" disabled>
    <span>Votes</span>

    <div id="votes">
        @foreach(explode('|', $voting->votes) as $vote)
            <div class="voteDiv">
                {{$vote}}
                @if($user_vote == $vote)
                    <span id="span_{{$vote}}">(Voted)</span>
                    <input id="vote_{{$vote}}" type="radio" name="vote" value="{{$vote}}" checked oninput="inputChange()">
                @else
                    <span id="span_{{$vote}}"></span>
                    <input id="vote_{{$vote}}" type="radio" name="vote" value="{{$vote}}" oninput="inputChange()">
                @endif
            </div>
        @endforeach
    </div>

    <span>Start at</span><input type="text" value="{{$voting->start_at}}" disabled>
    <span>End at</span><input type="text" value="{{$voting->end_at}}" disabled>
    <div id="error" class="errorDiv"></div>
    <a href="{{route('home')}}">Home</a>

    @if(time() > strtotime($voting->start_at) && time() < strtotime($voting->end_at))
        <button class="votingButton" onclick="buttonClick()">Vote</button>
    @else
        <button class="disabledButton" disabled>Vote</button>
    @endif
</form>
</body>
</html>
