<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable =[
        'title','description','location','job_type','employer_id','status'
    ];

    public function employer(){
        return $this->belongsTo(User::class,'employer_id');
    }
}
