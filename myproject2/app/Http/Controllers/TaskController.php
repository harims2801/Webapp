<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use DB;
use DateTime;
class TaskController extends Controller
{
    public function index() {
        return Task::all();
    }

    public function store(Request $request) {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, $task){
        if ($request->get('status') == 'resolved'){

            $updated_time = new DateTime();

            $deadline = DB::table('tasks')->where('id',$task)->pluck('dead_line');

            $arr = (string)$deadline;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $arr = str_replace("\"","",$arr);
            $deadline = $arr;

            list($year,$month, $day) = explode('-', $deadline);
            $deadline = date_create($deadline);

            $diff = $this->days_diff($deadline,$updated_time);


            if ($diff < 0){
                $request->merge([
                    'meets_deadline' => '0'
                ]);
            }else{
                $request->merge([
                    'meets_deadline' => '1'
                ]);
            }
        };
        $request->merge([
            'id' => $task
        ]);
        $req = $request->except(['api_token']);
        Task::where('id',$task)->update($req);

        $res = DB::table('tasks')->where('id',$task)->get();
        return response()->json($res, 200);
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

    public function days_diff($d1, $d2) {
        $x1 = $this->days($d1);
        $x2 = $this->days($d2);

        if ($x1 && $x2) {
            return ($x1 - $x2);
        }else{
            return "$x2";
        }
    }

    public function days($x) {
        if (get_class($x) != 'DateTime') {
            return false;
        }

        $y = $x->format('Y') - 1;
        $days = $y * 365;
        $z = (int)($y / 4);
        $days += $z;
        $z = (int)($y / 100);
        $days -= $z;
        $z = (int)($y / 400);
        $days += $z;
        $days += $x->format('z');

        return $days;
    }


}
