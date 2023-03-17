<?php

namespace App\Jobs;

use App\Models\CallCenterModel;
use Carbon\Carbon;
use Core\CallCenter\Objects\CallObject;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CallObject $callObject;

    /**
     * Create a new job instance.
     */
    public function __construct(CallObject $object)
    {
        $this->queue = "log_call";
        $this->delay = now()->addSeconds(5);

        $this->callObject = $object;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = json_encode([
            'phone' => $this->callObject->getPhone(),
            'extension' => $this->callObject->getExtension(),
            'uuid' => $this->callObject->getCallId(),
            'type' => $this->callObject->getType() === 'in' ? 'inbound' : 'outbound',
            'time' => $this->callObject->getTime(),
            'duration' => $this->callObject->getDuration() ?: 0,
            'status' => strtolower($this->callObject->getStatus()),
            'recording_url' => $this->callObject->getRecordingFile(),
            'secret' => 'BjGJrQ80WOLtsyUkwXeADKl8dULdRVMPHswk',
        ]);
        $request = new Request('POST', 'https://brandco.getflycrm.com/api/callcenter/cdr', $headers, $body);
        $res = $client->sendAsync($request)->wait();

        Log::info("=>> Call Job success Edit ");

        $content = $res->getBody()->getContents();
        Log::info($content);
        DB::table('logs_call')->where('id', $this->callObject->getId())->update([
            'json_attributes' => $content,
//            'updated_at' => Carbon::now(),
        ]);
    }
}
