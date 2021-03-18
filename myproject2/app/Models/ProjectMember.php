<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectMember extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','project_id'];

    public function project()
    {

      return $this->belongsTo('App\Project','Project_id');

    }
}
