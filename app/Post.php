<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Plmrlnsnts\Commentator\HasComments;

class Post extends Model
{
    use HasComments;
}
