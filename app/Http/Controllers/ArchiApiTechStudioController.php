<?php

/*
 * http://lara.local/archi-api-tech-studio
*/

namespace App\Http\Controllers;

use App\Services\TinTechStudio\Api\ArchiApi;
use Illuminate\Http\Request;

class ArchiApiTechStudioController extends Controller
{
    public function show()
    {
        $api = new ArchiApi();


        dd($api->getWorkStationsList());
        dd($api->getAvailableZonesList('Колеровочная система Omnitint'));
        //dd($api->getColorsList()->body[0]);
        //dd($api->getColorCardsList());
        //dd($api->getColorsInColorCardList('Benjamin Moore Off-White Colors'));
        dd($api->getProductsInZoneList('Hygge_custom1'));


        dd($api->getColorFormula('Omnitint', 'Archipaint Elegante W', 'BH01E', 'Hygge_custom1'));
        $url = $this->url . $this->api_path['getColorCardsList'];

    }




}
