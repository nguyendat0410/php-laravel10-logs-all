<?php
namespace Core\CallCenter;

use Core\BaseRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class VfoneProvider extends BaseRequest
{
    const TOKEN = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjIsIm5hbWUiOiJhZG1pbiIsImlhdCI6MTY3ODI2NjI0NSwiZXhwIjoxNzY0NjY2MjQ1fQ.JNV06Zd8LLgEzHyvbfHPIErw2GGMUKa53kwj0Yv8kY0";
    public function __construct()
    {
        parent::__construct([
            'base_uri' => 'https://brandco.vfone.vn:65483',
            'timeout' => 60,
        ]);
    }

    public function getLogs(array $params = [])
    {
        $limit = 1000;
        $logs = $this->callAPI($params);
        $responseData = !empty($logs['list_history']) ? $logs['list_history'] : [];
        if ($logs) {
            $totalRecord = $logs['total_record'];

            if ($totalRecord > 0) {
                $totalPage = ($totalRecord % $limit) == 0 ? ($totalRecord / $limit) : intval($totalRecord / $limit) + 1 ;

                if ($totalPage > 1) {
                    for ($i = 2; $i <= $totalPage; $i++) {
                        $params['page'] = $i;

                        $newLogs = $this->callAPI($params);

                        if (isset($newLogs['list_history']) && !empty($newLogs['list_history'])) {
                            $responseData = array_merge($responseData, $newLogs['list_history']);
                        }
                    }
                }
            }
        }

        return $responseData;
    }

    private function callAPI(array $params)
    {
        $responseData = [];
        try {
            $response = $this->client->get('history/view', [
                RequestOptions::HEADERS => [
                    'Accept'        => 'application/json',
                    "Content-Type"  => "application/json",
                    "Authorization" => "Bearer ". self::TOKEN,
                ],
                RequestOptions::QUERY => $params,
            ]);

            $body = $response->getBody();

            $body = json_decode($body->getContents(), JSON_OBJECT_AS_ARRAY);

            if (!empty($body) && !empty($body['data']) && !empty($body['data'][0])) {
                Log::info("Total log = ". $body['data'][0]['total_record']);
                Log::info("Log page = {$params['page']} = ". count($body['data'][0]['list_history']));
                $responseData = $body['data'][0];
            }
        } catch (RequestException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents());
            Log::error($body);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
        }
        return $responseData;
    }
}
