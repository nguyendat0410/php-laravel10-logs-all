<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCenterModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logs_call';

    public $timestamps = true;

    public $usesUniqueIds = true;
}
