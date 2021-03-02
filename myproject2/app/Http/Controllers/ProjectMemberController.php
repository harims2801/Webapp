<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\User;
use App\Models\Project;

class ProjectMemberController extends Controller
{
    public function index() {
        return ProjectMember::all();
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

    public function update(Request $request, $project, $user){
        $member = ProjectMember::where('project_id',$project) ->where('user_id',$user) ->update($request->all());
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
