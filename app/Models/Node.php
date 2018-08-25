<?php

namespace App\Models;

use App\Rewrites\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Node extends Model
{
	use SoftDeletes;
    protected $table = 'nodes';
    protected $primaryKey = 'node_id';
    protected $fillable = [
        'title', 'action', 'parent_id', 'is_show','linecons','level','sort',
    ];


}
