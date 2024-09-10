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
<script>
    async function buttonClick(){

        let name = document.getElementById('name').value.trim();
        let start = document.getElementById('start').value.trim();
        let end = document.getElementById('end').value.trim();

        let votesArr = [];

        let votesElement = document.getElementById('votes');
        let votes = votesElement.children;

        for (let i = 0; i < votes.length; i++){
            if (votes[i].value.trim().length > 0){
                votesArr.push(votes[i].value.trim());
                if (votes[i].value.includes('|')){
                    document.getElementById('error').textContent = 'Dont use |';
                    return false;
                }
            }
        }

        votes = votesArr.join('|');

        if (name.length < 1 || start.length < 1 || end.length < 1 || votes.length < 1){
            document.getElementById('error').textContent = 'Fill all the fields';
        }
        else if(votesArr.length != [...new Set(votesArr)].length){
            document.getElementById('error').textContent = 'Only unique votes';
        }
        else if(!/^\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/gm.test(start) || !/^\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/gm.test(end)){
            document.getElementById('error').textContent = 'Wrong start or end';
        }
        else if(new Date(start) > new Date(end)){
            document.getElementById('error').textContent = 'Start > End';
        }
        else if(new Date() > new Date(end)){
            document.getElementById('error').textContent = 'End date already was';
        }
        else{
            let url = "{{route('checkVoting')}}?name=" + name + "&start=" + start + "&end=" + end + "&votes=" + votes;
            let response = await fetch(url);
            if (response.ok) {
                let obj = await response.json();
                switch (obj['status']) {
                    case 'ok': {
                        window.location.href = "{{route('admin')}}";
                    }
                        break;

                    case 'nameError': {
                        document.getElementById('error').textContent = 'Wrong name';
                    }
                        break;

                    case 'error': {
                        document.getElementById('error').textContent = 'Error';
                    }
                        break;
                }
            }
        }
    }
    function inputChange(){
        document.getElementById('error').textContent = '';
    }
    function inputVoteChange(){
        inputChange();

        let votesElement = document.getElementById('votes');
        let votes = votesElement.children;

        for (let i = 0; i < votes.length; i++){
            if (votes[i].value.length < 1){
                votes[i].remove();
                i--;
            }
        }

        if (votes.length < 7) {
            let vote = document.createElement('input');
            vote.className = 'voteInput';
            vote.type = 'text';
            vote.name = 'vote';
            vote.placeholder = 'Vote variant';
            vote.addEventListener('input', inputVoteChange);
            votesElement.append(vote);
        }
    }
</script>
<body class="formBody">
<form class="votingForm" method="POST" onsubmit="return false">
    <div class="titleDiv">Voting</div>
    <span>Name</span><input id="name" type="text" name="name" placeholder="Voting name" oninput="inputChange()">
    <span>Votes</span>

    <div id="votes">
        <input class="voteInput" type="text" name="vote" placeholder="Vote variant" oninput="inputVoteChange()">
    </div>

    <span>Start at</span><input id="start" type="text" name="start" placeholder="2000-12-31 23:59:59" oninput="inputChange()">
    <span>End at</span><input id="end" type="text" name="end" placeholder="2000-12-31 23:59:59" oninput="inputChange()">
    <div id="error" class="errorDiv"></div>
    <a href="{{route('admin')}}">Home</a>
    <button class="votingButton" onclick="buttonClick()">Submit</button>
</form>
</body>
</html>
