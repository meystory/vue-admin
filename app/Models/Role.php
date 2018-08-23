<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Role extends Model
{	
	// use SoftDelete;
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_name', 'creator', 'use_status', 'created_at'
    ];

    public function nodes(){
    	return $this->belongsToMany(Node::class, 'role_node', 'role_id', 'node_id');
    }
}
