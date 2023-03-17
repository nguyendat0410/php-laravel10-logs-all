<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FlagModel
 *
 * @property string $name Flag name
 * @property string $value Flag value
 * @method static \Illuminate\Database\Eloquent\Builder|FlagModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlagModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlagModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlagModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlagModel whereValue($value)
 * @mixin Eloquent
 */
class FlagModel extends Model
{
    use HasFactory;

    protected $table = 'log_flag';

    public $timestamps = false;

    public $fillable = ["name", "value"];
}
