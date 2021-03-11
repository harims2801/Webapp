<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\User;
use App\Models\Project;
use update;
use DB;
//use Illuminate\Database\Eloquent\Collection;

class ProjectMemberController extends Controller
{
    public function index() {
        //return ProjectMember::all();
        return DB::table('project_members')
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->join('projects', 'project_members.project_id', '=', 'projects.id')
            //->select('project_members.id','project_members.project_id','projects.name as project_name','users.id as user_id', 'users.name as user_name')
            ->select('project_members.id','projects.name as project_name', 'users.name as user_name')
            ->get();
    }

    public function show(ProjectMember $member) {
        return $member;
    }

    public function show_project_members($project) {
        return ProjectMember::where('project_id',$project) ->get();

    }

    public function show_user_projects($project,$user) {
        //User::where('project_id',$project) -> first();
        return ProjectMember::where('project_id',$project) ->where('user_id',$user) ->get();
    }

    public function store(Request $request) {
        $projectmember = ProjectMember::create($request->all());

        return response()->json($projectmember, 201);
    }

    // public function update_member(Request $request, $project, $user){
    //     //$m = ProjectMember::where('project_id',$project) ->where('user_id',$user) ->get(); //->update($request->all());
    //     $m = ProjectMember::where('project_id',$project) ->where('user_id',$user) ->update(['project_role' => $request->get('project_role')]);    //$insert_array);
    //     return response()->json($m, 200);
    //     //return response()->json($member, 200);
    // }

    public function updateWithId(Request $request,ProjectMember $member){
        //$member = ProjectMember::where('project_id',$project) ->where('user_id',$user) ->update($request->all());
        $member->update($request->all());
        //$member->update();
        //$a = ProjectMember::find($m);
        //$a->fill($request->all())->save();
        //$member->update($request->all());
        return response()->json($member, 200);
    }
    public function delete($project, $user){
        ProjectMember::where('project_id',$project)-> where('user_id',$user) ->delete();
        //$member->delete();
        return response()->json(null, 204);
    }
}
