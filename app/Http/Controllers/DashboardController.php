<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Task;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function getStats(Request $request){

        $team_id = auth()->user()->currently_selected_team_id;

        $teamMemberCount = User::where('currently_selected_team_id', '=', $team_id)->count();
        $contactCount = Contact::where('team_id', '=', $team_id)->count();
        $leadCount = Lead::where('team_id', '=', $team_id)->count();
        $taskCount = Task::where('team_id', '=', $team_id)->count();

        $data = [
            "teamMembersCount" => $teamMemberCount,
            "contactCount" => $contactCount,
            "leadCount" => $leadCount,
            "taskCount" => $taskCount,
        ];

        return response()->json($data);

    }
}