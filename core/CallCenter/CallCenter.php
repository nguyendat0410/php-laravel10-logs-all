<?php

namespace Core\CallCenter;

use App\Models\CallCenterModel;
use Carbon\Carbon;
use Core\CallCenter\Objects\VfoneObject;
use Illuminate\Support\Str;

class CallCenter
{
    public function logs(): void
    {
        $vFone = new VfoneProvider();
        $type = 'out';
        $params = [
            'page' => 1,
            'limit' => 100,
            'starttime' => strtotime('2023-02-01 00:00:00'),
            'endtime' => strtotime('2023-02-28 23:59:59'),
            // "route" must be one of [in, out, local, forward]
            'route' => $type,
            // "status" must be one of [answer, noanswer, busy, fail]
            'status' => 'answer'
        ];
        $logs = $vFone->getLogs($params);

        $inserts = [];
        try {
            foreach ($logs as $callLog) {
                $log = new VfoneObject($callLog);

                $inserts[] = [
                    'call_id' => $log->getCallid(),
                    'phone' => $type === 'out' ? $log->getCallee() : $log->getCaller(),
                    'extension' => $type === 'out' ? $log->getCaller() : $log->getCallee(),
                    'time' => $log->getCalldate(),
                    'duration' => !empty($log->getRecordingfile()) ? $log->getBillsec() : 0,
                    'status' => $log->getDisposition(),
                    'recording_file' => $log->getRecordingfile(),
                    'type' => $type,
                    'uuid' => Str::orderedUuid(),
                    'created_at' => Carbon::now(),
                ];
            }

            CallCenterModel::insert($inserts);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
