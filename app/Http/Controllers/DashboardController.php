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
        $todoTasksCount = Task::where('team_id', '=', $team_id)->where('status', '=', Task::STATUS_TODO)->count();
        $inProgressTasksCount = Task::where('team_id', '=', $team_id)->where('status', '=', Task::STATUS_IN_PROGRESS)->count();
        $doneTasksCount = Task::where('team_id', '=', $team_id)->where('status', '=', Task::STATUS_DONE)->count();

        $data = [
            "teamMembersCount" => $teamMemberCount,
            "contactCount" => $contactCount,
            "leadCount" => $leadCount,
            "taskCount" => $taskCount,
            "todoTasksCount" => $todoTasksCount,
            "inProgressTasksCount" => $inProgressTasksCount,
            "doneTasksCount" => $doneTasksCount
        ];

        return response()->json($data);

    }
}
