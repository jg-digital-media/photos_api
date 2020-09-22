<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = "owners";

    protected $fillable = [
        "name",
        "copyright",
        "year"
    ];

    public function photos() {
        return $this->hasMany(Photo::class);
    }
    

}
