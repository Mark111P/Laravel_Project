<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vote;
use App\Models\Voting;

class VotingApiController extends Controller
{
    public function checkVote(Request $request){
        $login = $request->get('login');

        $user_id = User::all()->where('login', $login)->value('id');
        $voting_id = $request->get('voting_id');
        $voteName = $request->get('vote');

        $response = [];

        if (in_array($voteName, explode('|', Voting::all()->where('id', $voting_id )->value('votes')))) {
            if (count(Vote::all()->where('user_id', $user_id)->where('voting_id', $voting_id)) == 0) {
                $vote = new Vote();
                $vote->user_id = $user_id;
                $vote->voting_id = $voting_id;
                $vote->vote = $voteName;
                $vote->save();

                $response['status'] = 'added';
                $response['vote'] = $voteName;
            }
            else{
                Vote::where('user_id', $user_id)->where('voting_id', $voting_id)->update(['vote' => $voteName]);

                $response['status'] = 'updated';
                $response['vote'] = $voteName;
            }
        }
        else{
            $response['status'] = 'wrongVote';
        }

        return json_encode($response);
    }
}
