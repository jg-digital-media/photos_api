<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = "photos";

    protected $fillable =[
        "url",
        "caption",
        "owner_id"
    
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }
}
