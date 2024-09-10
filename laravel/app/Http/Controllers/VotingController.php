<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voting;
use App\Models\Vote;

class VotingController extends Controller
{
    public function home(){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'user') {
                setcookie('login', $_COOKIE['login'], time() + 3600, "/");
                $votings = Voting::all();
                return view('voting.home', compact('votings'));
            }
            else{
                return redirect()->route('admin');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function vote(Request $request){
        if (isset($_COOKIE['login'])) {
            if (User::all()->where('login', $_COOKIE['login'])->value('role') == 'user') {
                $voting = Voting::all()->find($request->id);
                $user_id = User::all()->where('login', $_COOKIE['login'])->value('id');
                $user_vote = Vote::all()->where('voting_id', $voting->id)->where('user_id', $user_id)->value('vote');
                $login = $_COOKIE['login'];
                return view('voting.vote', compact('voting', 'user_vote', 'login'));
            }
            else{
                return redirect()->route('admin');
            }
        }
        else{
            return redirect()->route('login');
        }
    }
}
