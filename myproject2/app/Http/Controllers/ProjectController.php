<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use DB;
class ProjectController extends Controller
{

    public function index() {
        return Project::all();
    }

    public function show(Project $project) {
        return $project;
    }

    public function store(Request $request) {
        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project){
        $project->update($request->all());
        return response()->json($project, 200);
    }

    public function delete(Project $project){
        $project->delete();

        return response()->json(null, 204);
    }
    public function statistics_user($user){
        //return
        //DB::query("SELECT status,Count(*) count,AssignedTo from (SELECT status,AssignedTo from tasks where AssignedTo = $user) s GROUP by AssignedTo,status");
        $res = DB::table('tasks')
        ->where('tasks.AssignedTo', '=', $user)
        ->join('users', 'users.id', '=', 'tasks.AssignedTo')
        ->select('users.name','status',DB::raw('count("id") as count' ))
        ->groupBy('users.name',"status")
        ->get();
        return response()->json($res, 200);
    }
    public function statistics_user1($user){
        //return
        //DB::query("SELECT status,Count(*) count,AssignedTo from (SELECT status,AssignedTo from tasks where AssignedTo = $user) s GROUP by AssignedTo,status");
        $res = DB::table('tasks')
        ->Join('tasks',function($join) {
                            $join->on('tasks.user_id','=','tasks.user_id')
                                ->orWhere('tasks.status','created');
                        })
        ->where('tasks.user_id',1)
        ->select(DB::raw('count(tasks.task_id)'))
        ->get();
        return response()->json($res, 200);
    }

    public function statistics(){
    // $users = DB::query("SELECT status,Count(*) count,AssignedTo from (SELECT status,AssignedTo from tasks) s GROUP by AssignedTo,status");
    //    $users = DB::table('tasks')
    //                 //->select('status', 'Count(id)', 'AssignedTo')
    //                 ->select(DB::raw(' * '))
    //                 ->get();
    $res = DB::table('tasks')
    ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    ->select('users.name','status',DB::raw('count("id") as count' ))
    ->groupBy('users.name',"status")
    ->get();

        return response()->json($res, 200);
    }
}
