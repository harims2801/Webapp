<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use DB;

class TaskController extends Controller
{
    public function index() {
        return Task::all();
    }

    public function store(Request $request) {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task){
        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function delete(Task $task){
        $task->delete();
        return response()->json(null, 204);
    }

    public function project_tasks($project){
        return Task::where('project_id',$project) ->get();
    }

    public function show(Task $task) {
        return $task;
    }
    public function show_user_tasks($user_id){
       $res =  DB::table('tasks')
        ->where('AssignedTo',$user_id)
        ->get();
        return response()->json($res, 200);
    }

}
