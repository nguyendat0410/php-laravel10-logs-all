<?php

namespace Core\CallCenter;

use App\Jobs\CallJob;
use App\Models\CallCenterModel;
use App\Models\FlagModel;
use Carbon\Carbon;
use Core\CallCenter\Objects\CallObject;
use Core\CallCenter\Objects\VfoneObject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CallCenter
{
    public function logs()
    {
        $vFone = new VfoneProvider();
        $types = ['out'];

        Log::info("break line ". PHP_EOL);
        DB::enableQueryLog();
        Log::info("Start time get call ". now());
        $time = FlagModel::firstWhere('name', 'LOG_TIME');

        if (strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $time->value)->format('Y-m-d 23:59:59')) >= strtotime('2023-02-28 23:59:59')) {
            // Add queue work run
            $calls = CallCenterModel::where(['updated_at' => null])->limit(500)->get()->toArray();

            foreach ($calls as $call) {
                $row = new CallObject($call);
                CallJob::dispatch(new CallObject($call));

                DB::table('logs_call')->where('id', $row->getId())->update([
                    'updated_at' => Carbon::now(),
                ]);
            }

            Log::info('Job Success !!! '. $time->value);
            return true;
        }

        // Craw log
        try {
            $params = [
                'page' => 1,
                'limit' => 1000,
                'starttime' => strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $time->value)->format('Y-m-d 00:00:00')),
                'endtime' => strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $time->value)->format('Y-m-d 23:59:59')),
//                'starttime' => strtotime('2023-02-01 00:00:00'),
//                'endtime' => strtotime('2023-02-28 23:59:59'),
                // "route" must be one of [in, out, local, forward]
                'route' => '',
                // "status" must be one of [answer, noanswer, busy, fail]
                'status' => 'answer'
            ];
            $logs = [];
            foreach ($types as $type) {
                $params['route'] = $type;
                Log::info("Params foreach ". json_encode($params));

                $newLogs = $vFone->getLogs($params);
                if (!empty($newLogs)) {
                    $logs = array_merge($logs, $newLogs);
                }
            }
            Log::info("Logs/ call ". json_encode($logs));
            $inserts = [];
            foreach ($logs as $callLog) {
                $log = new VfoneObject($callLog);

                if ($log->getCallid() !== 'unknown') {
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
            }

            if (!empty($inserts)) {
                Log::info("Logs format");
                $chunks = array_chunk($inserts, 100);
                foreach ($chunks as $c){
                    CallCenterModel::insert($c);
                }
                Log::info("Logs inserted");
            }

            // Update time
            Log::info("DB Update");
            $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $time->value)->addDay()->toDateTimeString();
            DB::table('log_flag')->updateOrInsert([
                "name" => "LOG_TIME"
            ], [
                "value" => $dateTime
            ]);
            Log::info("End update time " . $dateTime);
        } catch (\Exception $e) {
            Log::error("Catch parent");
            Log::error($e->getMessage());
        }
    }
}
