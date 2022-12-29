<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $fillable = [
        "start_time",
        "project_id"
    ];

    public function project() {
        return $this->hasOne(Project::class,"id","project_id");
    }
}
