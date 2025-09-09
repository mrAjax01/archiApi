<?php


namespace App\Services\TinTechStudio\Api;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;

abstract class TinTechApi
{
    private GuzzleHttp\Client $client;

    private CookieJar $cookies;

    private string $url;

    private int $timeout = 30;

    private string $method = 'GET';

    private string $api_path = '/hs/tintAPI/V1/';

    private array $params;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();

        $this->params = [
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'User-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36'
            ],
            'timeout' => 30,
            'http_errors' => false,
            'cookies' => new CookieJar(),
            'verify' => false,
            'auth' => []
        ];
    }

    public function setTimeout(int $sec)
    {
        $this->timeout = $sec;
    }

    public function getWorkStationsList()
    {
        return $this->getResponse($this->api_path . '/getWorkStationsList');
    }

    public function getAvailableZonesList(string $name)
    {
        return $this->getResponse($this->api_path . '/getAvailableZonesList?workStation=' . $name);
    }

    public function getColorsList()
    {
        return $this->getResponse($this->api_path . '/getColorsList');
    }

    public function getColorCardsList()
    {
        return $this->getResponse($this->api_path . '/getColorCardsList');
    }

    public function getColorsInColorCardList(string $name)
    {
        return $this->getResponse($this->api_path . '/getColorsInColorCardList?colorCardName=' . $name);
    }

    public function getProductsInZoneList(string $zone)
    {
        return $this->getResponse($this->api_path . '/getProductsInZoneList?zone=' . $zone);
    }

    public function getColorFormula(string $system, string $product, string $color, string $zone)
    {
        return $this->getResponse($this->api_path . '/getColorFormula?tintSystem=' . $system . '&product=' . $product . '&color=' . $color . '&zone=' . $zone);
    }

    protected function setBaseUrl(string $url)
    {
        $this->url = $url;
    }

    protected function setAuth(string $login, string $pass)
    {
        $this->params['auth'] = [$login, $pass];
    }

    private function getResponse(string $url = ''): object
    {
        $url = rtrim($this->url, '/') . '/' . ltrim($url, '/');

        $res = $this->client->request($this->method, $url, $this->params);

        try {
            $resp = json_decode((string)$res->getBody());

            if($resp->error)
                return (object)[
                    'status' => 'error',
                    'code' => $res->getStatusCode(),
                    'header' => $res->getHeader('content-type')[0],
                    'error' => $resp->errorText
                ];

            return (object)[
                'status' => 'ok',
                'code' => $res->getStatusCode(),
                'header' => $res->getHeader('content-type')[0],
                'body' => $resp->result
            ];
        } catch (\Exception $e) {
            return (object)[
                'status' => 'error',
                'code' => $res->getStatusCode(),
                'header' => $res->getHeader('content-type')[0],
                'error' => $e->getMessage()
            ];
        }
    }
}
