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
    public function statistics_user_new($user){
        //return
        //DB::query("SELECT status,Count(*) count,AssignedTo from (SELECT status,AssignedTo from tasks where AssignedTo = $user) s GROUP by AssignedTo,status");
        // $res = DB::table('tasks')
        // ->join('users', 'users.id', '=', 'tasks.AssignedTo')
        // ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
        // ->where('tasks.AssignedTo',$user)
        // ->groupBy('users.name')
        // ->get();
        $this->update_stats();
        $username = DB::table('users')->where('id',$user)->pluck('name');
        $res = DB::table('stats')->where('user',$username) ->get();

        return response()->json($res, 200);
    }

    public function statistics(){

        //old method without temporary table

    // $users = DB::query("SELECT status,Count(*) count,AssignedTo from (SELECT status,AssignedTo from tasks) s GROUP by AssignedTo,status");
    //    $users = DB::table('tasks')
    //                 ->select(DB::raw(' * '))
    //                 ->get();

    // $res = DB::table('tasks')
    // ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    // ->select('users.name','status',DB::raw('count("id") as count' ))
    // ->groupBy('users.name',"status")
    // ->get();

    //new method with temporary table
    // DB::table('stats')->truncate();
    //     $users = DB::table('users')->pluck('id');
    //     foreach ($users as $user){

    //         $user_id = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('users.name');

    //         $assigned = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('assigned');

    //         $created = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('created');

    //         $pending = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('pending');

    //         $resolved = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('resolved');

    //         $resolved_on_time = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->where('tasks.meets_deadline',"1")
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('resolved');


    //         $resolved_out_time = DB::table('tasks')
    //         ->join('users', 'users.id', '=', 'tasks.AssignedTo')
    //         ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
    //         ->where('tasks.AssignedTo',$user)
    //         ->where('tasks.meets_deadline',"0")
    //         ->groupBy('users.name')
    //         //->get();
    //         ->pluck('resolved');

    //         // get string form object
    //         $arr = (string)$user_id;
    //         $arr = str_replace("[","",$arr);
    //         $arr = str_replace("]","",$arr);
    //         $arr = str_replace("\"","",$arr);
    //         $user = $arr;
    //         $arr = (string)$assigned;
    //         $arr = str_replace("[","",$arr);
    //         $arr = str_replace("]","",$arr);
    //         $assigned = $arr;
    //         $arr = (string)$created;
    //         $arr = str_replace("[","",$arr);
    //         $arr = str_replace("]","",$arr);
    //         $created = $arr;
    //         $arr = (string)$pending;
    //         $arr = str_replace("[","",$arr);
    //         $arr = str_replace("]","",$arr);
    //         $pending = $arr;
    //         $arr = (string)$resolved;
    //         $arr = str_replace("[","",$arr);
    //         $arr = str_replace("]","",$arr);
    //         $resolved = $arr;

    //         if ($user == "" && $assigned == "" && $created == "" && $pending == "" && $resolved == ""){
    //                 // do not push
    //         }else{

    //            DB::table('stats')
    //            ->insert(['user' => $user,
    //            'assigned' => $assigned,
    //            'created' => $created,
    //            'pending' => $pending,
    //            'resolved' => $resolved,
    //            'resolved_on_time' => $resolved_on_time,
    //            'resolved_out_of_time' => $resolved_out_time
    //            ]);

    //         }
    //     }

        $this->update_stats();
        $res = DB::table('stats')->get();
        return response()->json($res, 200);
    }

    protected function update_stats(){
        DB::table('stats')->truncate();
        $users = DB::table('users')->pluck('id');
        foreach ($users as $user){

            $user_id = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
            ->where('tasks.AssignedTo',$user)
            ->groupBy('users.name')
            //->get();
            ->pluck('users.name');

            $assigned = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
            ->where('tasks.AssignedTo',$user)
            ->groupBy('users.name')
            //->get();
            ->pluck('assigned');

            $created = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
            ->where('tasks.AssignedTo',$user)
            ->groupBy('users.name')
            //->get();
            ->pluck('created');

            $pending = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
            ->where('tasks.AssignedTo',$user)
            ->groupBy('users.name')
            //->get();
            ->pluck('pending');

            $resolved = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select('users.name',DB::raw('(select count(cr.id) created from tasks o join tasks cr on o.id=cr.id and cr.status = "created" where o.AssignedTo="'.$user.'") created, (select count(pd.id) pending from tasks o join tasks pd on o.id=pd.id and pd.status = "pending" where o.AssignedTo="'.$user.'") pending, (select count(rs.id) pending from tasks o join tasks rs on o.id=rs.id and rs.status = "resolved" where o.AssignedTo="'.$user.'") resolved, (select count(ad.id) pending from tasks o join tasks ad on o.id=ad.id and ad.status = "assigned" where o.AssignedTo="'.$user.'") assigned'))
            ->where('tasks.AssignedTo',$user)
            ->groupBy('users.name')
            //->get();
            ->pluck('resolved');

            $resolved_out_time = DB::table("tasks")
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select(DB::raw('select count(tasks.id)'))
            ->where('tasks.AssignedTo','=',$user)
            ->where('tasks.meets_deadline',"=","0")
            ->count();

            $resolved_on_time = DB::table("tasks")
            ->join('users', 'users.id', '=', 'tasks.AssignedTo')
            ->select(DB::raw('select count(tasks.id)'))
            ->where('tasks.AssignedTo','=',$user)
            ->where('tasks.meets_deadline',"=","1")
            ->count();

            // get string form object
            $arr = (string)$user_id;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $arr = str_replace("\"","",$arr);
            $user = $arr;
            $arr = (string)$assigned;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $assigned = $arr;
            $arr = (string)$created;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $created = $arr;
            $arr = (string)$pending;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $pending = $arr;
            $arr = (string)$resolved;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $resolved = $arr;
            $arr = (string)$resolved_on_time;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $resolved_on_time = $arr;
            $arr = (string)$resolved_out_time;
            $arr = str_replace("[","",$arr);
            $arr = str_replace("]","",$arr);
            $resolved_out_time = $arr;

            if ($assigned == "" && $pending == "" && $resolved == "" && $resolved_out_time == "" && $resolved_on_time == ""){
                // do not push
            }elseif($assigned == 0 && $pending == 0 && $resolved == 0 && $resolved_out_time == 0 && $resolved_on_time == 0){
                // do not update
            }else{
                if ($assigned == ""){$assigned = 0;}
                //if ($created == ""){$created = 0;}
                if ($pending == ""){$pending = 0;}
                if ($resolved == ""){$resolved = 0;}
                if ($resolved_on_time == ""){$resolved_on_time = 0;}
                if ($resolved_out_time == ""){$resolved_out_time = 0;}
               DB::table('stats')
               ->insert(['user' => $user,
               'assigned' => $assigned,
              //'created' => $created,
               'pending' => $pending,
               'resolved' => $resolved,
               'resolved_on_time' => $resolved_on_time,
               'resolved_out_of_time' => $resolved_out_time
               ]);

            }
        }
    }


}
