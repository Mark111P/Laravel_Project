<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    public function checkVoting(Request $request){
        $name = $request->get('name');
        $start = $request->get('start');
        $end = $request->get('end');
        $votes = $request->get('votes');

        $response = [];

        $votings = Voting::all();
        if (count($votings->where('name', $name)) == 0) {
            $voting = new Voting();
            $voting->name = $name;
            $voting->start_at = $start;
            $voting->end_at = $end;
            $voting->votes = $votes;
            $voting->save();

            $response['status'] = 'ok';
        }
        else{
            $response['status'] = 'nameError';
        }

        return json_encode($response);
    }

    public function changeVoting(Request $request){
        $name = $request->get('name');
        $start = $request->get('start');
        $end = $request->get('end');
        $votes = $request->get('votes');

        Voting::where('name', $name)->update(['start_at' => $start, 'end_at' => $end, 'votes' => $votes]);
        $response = ['status' => 'ok'];
        return json_encode($response);
    }
}
