<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{

    public function index(Request $request) {
        $query = Work::whereBetween("start_time",[$request->start_date,$request->stop_date]);
        if($request->project_id) {
            $query = $query->where([
                "project_id" => $request->project_id
            ]);
        }
        $works =  $query->get();

        $projects = Project::get();
        return view("works",["works" => $works,"start_date" => $request->start_date,"stop_date" => $request->stop_date,"projects" => $projects,"project_id" => $request->project_id]);

    }

    public function start(Request $request) {

       $work = Work::where([
        "stop_time" => NULL
       ])
       ->first();
       if($work) {
        return view("work-stop",["work"=>$work]);
       }
       $projects = Project::get();
       return view("work-start",compact("projects"));
    }

    public function store(Request $request) {
        $work = Work::where([
            "stop_time" => NULL
           ])
           ->first();
           if($work) {
            return redirect()->route("works.start");
           }



        $work = Work::create([
            "start_time" => now(),
            "project_id" => $request->project_id
        ]);

            return view("work-stop",["work"=>$work]);

    }
    public function stop(Request $request) {
        $work = Work::where([
            "stop_time" => NULL
           ])
           ->first();

           $work->stop_time = now();
           $work->work_description = $request->work_description;
           $work->save();

           return redirect()->route("works.start");

    }

    public function customStop(Request $request) {

        $work = Work::where([
         "stop_time" => NULL
        ])
        ->first();
        if($work) {
         return view("work-custom-stop",["work"=>$work]);
        }

        return view("work-start");
     }
     public function customStopStore(Request $request) {
        $work = Work::where([
            "stop_time" => NULL
           ])
           ->first();

           $work->stop_time = $request->stop_time;
           $work->work_description = $request->work_description;
           $work->reason_of_stop = $request->reason_of_stop;
           $work->save();

           return redirect()->route("works.start");

    }
}
