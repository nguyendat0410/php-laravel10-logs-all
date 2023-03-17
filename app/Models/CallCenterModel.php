<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CallCenterModel
 *
 * @property int $id
 * @property string|null $uuid UUID example
 * @property string $call_id Id của tổng đài
 * @property string $phone Số điện thoại
 * @property string $extension Số máy lẻ
 * @property string $time Thời gian thực hiện cuộc gọi
 * @property int $duration Số giây nghe máy
 * @property string $status Trạng thái cuộc gọi
 * @property string $type Cuộc gọi vào (in), Cuộc gọi ra (out)
 * @property string $recording_file Đường dẫn file ghi âm
 * @property string $json_attributes Trường JSON
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereCallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereJsonAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereRecordingFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallCenterModel whereUuid($value)
 * @mixin Eloquent
 */
class CallCenterModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logs_call';

    public $timestamps = true;

    public $usesUniqueIds = true;
}
