<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function home(){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'admin') {
                setcookie('login', $_COOKIE['login'], time() + 3600, "/");
                $votings = Voting::all();
                return view('admin.home', compact('votings'));
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function createVoting(){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'admin') {
                return view('admin.createVoting');
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function deleteVoting(Request $request){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'admin') {
                $votes = Vote::all()->where('voting_id', $request->id);
                foreach ($votes as $vote) {
                    $vote->delete();
                }
                $voting = Voting::all()->find($request->id);
                $voting->delete();
                return redirect()->route('admin');
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function updateVoting(Request $request){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'admin') {
                $voting = Voting::all()->find($request->id);
                return view('admin.updateVoting', compact('voting'));
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function showVoting(Request $request){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'admin') {
                $voting = Voting::all()->find($request->id);
                $votes = $this->getVotes($request->id);

                return view('admin.showVoting', compact('voting', 'votes'));
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    private function getVotes(string $votingId){
        $unique = explode('|', Voting::all()->where('id', $votingId)->value('votes'));
        $arr = [];
        foreach ($unique as $vote) {
            $count = count(Vote::all()->where('voting_id', $votingId)->where('vote', $vote));
            $arr[$vote] = $count;
        }
        arsort($arr);
        return $arr;
    }
}
