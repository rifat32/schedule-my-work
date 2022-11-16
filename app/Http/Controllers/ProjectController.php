<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index() {
    $projects = Project::paginate(25);
    return view("projects",["projects" => $projects]);
   }
   public function create() {
    return view("projects-create");
   }
   public function store(Request $request) {
    Project::create(["name"=> $request->name]);
    return redirect()->route('projects.list');
   }

}
