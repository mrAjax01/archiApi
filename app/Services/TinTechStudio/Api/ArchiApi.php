<?php


namespace App\Services\TinTechStudio\Api;


class ArchiApi extends TinTechApi
{
    public function __construct()
    {
        parent::__construct();

        $this->setBaseUrl('https://buh.salonarchi.com:8443/TinTechStudio');

        $this->setAuth('Администратор', '_Tint');
    }
}
