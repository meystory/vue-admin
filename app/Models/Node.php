<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Node extends Model
{
    protected $table = 'nodes';
    protected $primaryKey = 'node_id';
    protected $fillable = [
        'title', 'action', 'parent_id', 'is_show','linecons','level','sort',
    ];


}
