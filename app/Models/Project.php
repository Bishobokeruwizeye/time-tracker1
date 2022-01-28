<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeEntry;

class Project extends Model {
    use HasFactory;

    public function client() {
      return $this->belongsTo(Client::class);
    }

    public function time_entry(){
        return $this->belongsToMany(TimeEntry::class);
    }
}
