<?php

namespace App\Http\Controllers;

use App\Models\TeamUser;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return response()->json($teams);
    }

    public function myTeams(Request $request)
    {
        $user = auth()->user();

        $teams = Team::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return response()->json($teams);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();

        $team = Team::create($validatedData);
        $team->save();

        $user->currently_selected_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team);

        return response()->json($team, 201);
    }

    public function switchTeam(Request $request){
        
        $team_id = $request->get('team_id');
        $user = auth()->user();

        $user->currently_selected_team_id = $team_id;
        $user->save();

        return response()->json("Success");

    }

    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json($team);
    }

    public function teamInfo(Request $request){
        $user = auth()->user();
        $team = Team::findOrFail($user->currently_selected_team_id);
        return response()->json($team);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();

        $team = Team::findOrFail($user->currently_selected_team_id);
        $team->update($validatedData);

        return response()->json($team, 200);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(null, 204);
    }

    public function teamMembers(Request $request)
    {

        $team_id = auth()->user()->currently_selected_team_id;
        $team_members = TeamUser::with('user')->where('team_id', '=', $team_id)->get();

        return response()->json($team_members, 200);

    }

    public function inviteLink(Request $request){

        $user = auth()->user();
        $team_id = $request->get('team_id');
        $team = Team::findOrFail($team_id);
        $invite_code = $request->get('code');

        if ($invite_code == $team->invite_code){
            $user->teams()->attach($team);
            $user->currently_selected_team_id = $team->id;
            $user->save();

            return response()->json("Success");

        }else{
            abort(403, 'Access denied.');
        }

    }

}
