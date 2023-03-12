<?php
namespace Core\CallCenter;

use Core\BaseRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

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

            if (!empty($body) && !empty($body['data']) && !empty($body['data'][0]) && !empty($body['data'][0]['list_history'])) {
                $responseData = $body['data'][0]['list_history'];
            }
        } catch (RequestException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents());
            dd($body);
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }

        return $responseData;
    }
}
