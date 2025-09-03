<?php

/*
 * http://lara.local/archi-api-tech-studio
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;

class ArchiApiTechStudioController extends Controller
{
    private GuzzleHttp\Client $client;

    private CookieJar $cookies;

    private string $url = 'https://buh.salonarchi.com:8443/TinTechStudio';

    private array $api_path = [
        'getWorkStationsList' => '/hs/tintAPI/V1/getWorkStationsList',
        'getAvailableZonesList' => '/hs/tintAPI/V1/getAvailableZonesList',
        'getColorsList' => '/hs/tintAPI/V1/getColorsList',
        'getColorCardsList' => '/hs/tintAPI/V1/getColorCardsList',
        'getColorsInColorCardList' => '/hs/tintAPI/V1/getColorsInColorCardList',
        'getProductsInZoneList' => '/hs/tintAPI/V1/getProductsInZoneList',
        'getCustomersList' => '/hs/tintAPI/V1/getCustomersList',
        'createCustomer' => '/hs/tintAPI/V1/createCustomer',
        'getColorFormula' => '/hs/tintAPI/V1/getColorFormula',

        'createOrder' => '/hs/tintAPI/V1/createOrder',
        'cancelOrder' => '/hs/tintAPI/V1/cancelOrder',
        'getOrdersList' => '/hs/tintAPI/V1/getOrdersList',
        'getOrderStatus' => '/hs/tintAPI/V1/getOrderStatus',
    ];

    private string $method = 'GET';

    private float $time = 0;

    private int $timeout = 30;

    private array $headers = [
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'User-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36'
    ];

    public function __construct(int $timeout = 20)
    {
        $this->client = new GuzzleHttp\Client();

        $this->cookies = new CookieJar;

        $this->timeout = $timeout;
    }

    public function show()
    {
        $arr = [
            'headers' => $this->headers,
            'timeout' => $this->timeout,
            'http_errors' => false,
            'cookies' => $this->cookies,
            'verify' => false,
            'auth' => ['Администратор', '_Tint'],
            'form_params' => [

            ]
        ];

        $url = $this->url . $this->api_path['getColorCardsList'];

        $res = $this->client->request($this->method, $url, $arr);

        $resp_arr = json_decode((string)$res->getBody());
        dd($res->getStatusCode(), $resp_arr);
    }



    public function getResponse($verbose = false): object
    {


        try {


            return (object)[
                'code' => $res->getStatusCode(),
                'header' => $res->getHeader('content-type')[0],
                'body' => (string)$res->getBody(),
                'time' => $this->time
            ];
        } catch (\Exception $e) {

            return (object)[
                'code' => 0,
                'header' => '',
                'body' => $e->getMessage(),
                'time' => 0,
                'error' => $e->getMessage()
            ];
        }
    }
}
