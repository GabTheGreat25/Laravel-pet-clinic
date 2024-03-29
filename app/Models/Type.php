<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ["deleted_at"];

    protected $table = "type";

    protected $fillable = ["type"];

    protected $primaryKey = "id";

    protected $guarded = ["id"];
}
