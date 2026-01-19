<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required| max:255',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
            'location' => 'nullable|string'
        ]);

        return Job::create([
            'employer_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'job_type' => $request->job_type,
            'location' => $request->location
        ]);
    }

    public function list(){
        return job::where('status','open')->latest()->get();
    }

    public function update(Request $request, $id){
        $request->validate([
            'status' => 'required|in:open,closed,rejected'
        ]);

        $status = Job::findorFail($id);
        $status->update(['status' => $request->status]);
        return $status;
    }

    public function employerView(Request $request){
        return Job::where('employer_id', $request->user()->id)->get();
    }
}
