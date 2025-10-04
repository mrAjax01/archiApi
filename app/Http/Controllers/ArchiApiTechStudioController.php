<?php

/*
 * http://lara.local/archi-api-tech-studio
*/

namespace App\Http\Controllers;

use App\Models\AvailableZones;
use App\Models\ColorCardsList;
use App\Models\ColorsInCards;
use App\Models\ColorsList;
use App\Models\Products;
use App\Models\WorkStations;
use App\Services\TinTechStudio\Api\ArchiApi;
use Illuminate\Http\Request;
use function PHPUnit\Framework\containsIdentical;

class ArchiApiTechStudioController extends Controller
{
    private function saveWs(object $result): void
    {
        $ws_db = new WorkStations();
        $ws_db->clientGuid = $result->clientGuid;
        $ws_db->workStation = $result->workStation;
        $ws_db->workStationColorSystem = $result->workStationColorSystem;
        $ws_db->workStationTintingMachineType = $result->workStationTintingMachineType;

        $ws_db->save();
    }

    private function saveZones(int $id, object $result): void
    {
        $zones_db = new AvailableZones();
        $zones_db->ws_id = $id;
        $zones_db->zones = $result->zones;

        $zones_db->save();
    }

    private function saveUpdateColor(object $result, ColorsList $cl = null): void
    {
        $cl_db = is_null($cl) ? new ColorsList() : $cl;
        $cl_db->colorCode = $result->colorCode;
        $cl_db->colorName = $result->colorName;
        $cl_db->colorHex = $result->colorHex;
        $cl_db->glaze = $result->glaze;
        $cl_db->LABCH_D65 = $result->LABCH_D65;
        $cl_db->LRV = $result->LRV;
        $cl_db->done = true;
        $cl_db->updated = is_null($cl) ? false : true;

        $cl_db->save();
    }

    private function saveUpdateProd(object $result, Products $prod = null): void
    {
        $prod_db = is_null($prod) ? new Products() : $prod;
        $prod_db->productName = $result->productName;
        $prod_db->val = $result->bases;
        $prod_db->done = true;
        $prod_db->updated = is_null($prod) ? false : true;

        $prod_db->save();
    }

    public function show()
    {
/*
        $api = new ArchiApi();

        try{
            $result = $api->getWorkStationsList()->body[0];
        }catch (\Exception $e){
            dd($e->getMessage());
        }

        $ws = WorkStations::where('clientGuid', $result->clientGuid)->get()->first();

        if(is_null($ws)) {
            WorkStations::query()->delete();
            $this->saveWs($result);
        }else{
            $diff = false;
            $ws_arr = $ws->toArray();

            foreach ((array)$result as $key => $value) {
                if($ws_arr[$key] == $value) continue;
                $diff = true;
            }

            if($diff) {
                WorkStations::query()->delete();
                $this->saveWs($result);
            }
        }

*/

/*
        $api = new ArchiApi();

        $ws = WorkStations::get()->first();

        try{
            $result = $api->getAvailableZonesList($ws->workStation)->body;
        }catch (\Exception $e){
            dd($e->getMessage());
        }

        $zones = AvailableZones::where('ws_id', $ws->id)->get()->first();

        if(is_null($zones)) {
            $this->saveZones($ws->id, $result);
        }else{
            $diff = false;
            $zones_arr = $zones->toArray();

            if($zones_arr['zones'] !== serialize($result->zones)) $diff = true;

            if($diff) {
                $zones->delete();
                $this->saveZones($ws->id, $result);
            }
        }
*/


/*
        $api = new ArchiApi();

        try{
            $full_arr = $api->getColorCardsList()->body;
        }catch (\Exception $e){
            dd($e->getMessage());
        }

        $arrs = array_chunk($full_arr, 100);

        ColorCardsList::where('done', true)->update(['done' => false]);

        foreach ($arrs as $arr) {

            foreach ($arr as $item) {
                $color_card_list = ColorCardsList::where('colorCardName', $item->colorCardName)->get()->first();

                if(is_null($color_card_list)){
                    $color_card_list = new ColorCardsList();
                    $color_card_list->colorCardName = $item->colorCardName;
                }

                $color_card_list->done = true;
                $color_card_list->save();
            }

        }

        ColorCardsList::where('done', false)->delete();
        ColorCardsList::where('done', true)->update(['done' => false]);

*/

/*
        $api = new ArchiApi();

        try{
            $colors = $api->getColorsList()->body;
        }catch (\Exception $e){
            dd($e->getMessage());
        }

        ColorsList::where('done', true)->update(['done' => false]);

        $arrs = array_chunk($colors, 1000);

        foreach ($arrs as $arr) {

            foreach ($arr as $item) {
                $color = ColorsList::where('colorCode', $item->colorCode)->get()->first();

                if(is_null($color)) {
                    $this->saveUpdateColor($item);
                    continue;
                }

                $diff = false;

                $tmp_color = $color->toArray();

                $tmp_item = (array)$item;
                if(empty(trim($tmp_item["colorName"]))) $tmp_item["colorName"] = $tmp_item["colorCode"];
                $tmp_item["LABCH_D65"] = serialize($tmp_item["LABCH_D65"]);
                $tmp_item["glaze"] = $tmp_item["glaze"] ? 1 : 0;

                foreach ($tmp_item as $key => $val) {
                    if($tmp_color[$key] !== $val) $diff = true;
                }

                if(empty(trim($item->colorName))) $item->colorName = $item->colorCode;

                if($diff) $this->saveUpdateColor($item, $color);

                $color->done = true;
                $color->save();
            }


            break;
        }

        ColorsList::where('done', false)->delete();
*/

/*

        $api = new ArchiApi();

        $color_card_lists = ColorCardsList::all();

        //foreach ($color_card_lists as $card) {



            $card = $color_card_lists[5];
            try{
                $colors = $api->getColorsInColorCardList($card->colorCardName)->body;
            }catch (\Exception $e){
                dd($e->getMessage());
            }

            $card = ColorCardsList::where('colorCardName', $colors->colorCardName)->get()->first();

            //if(empty($card)) continue;

            $id = $card->id;

            foreach ($colors->colorsInCard as $item) {
                $color = ColorsList::where('colorCode', $item->colorCode)->get()->first();
                if(empty($color)) continue;

                $link = ColorsInCards::where([
                    'cl_id' => $id,
                    'c_id' => $color->id
                ])->get()->first();

                if(!empty($link)) continue;

                $link = new ColorsInCards();
                $link->cl_id = $id;
                $link->c_id = $color->id;

                $link->save();
            }




        //}
*/

/*
        $api = new ArchiApi();

        try{
            $prods = $api->getProductsInZoneList(AvailableZones::where('ws_id', WorkStations::get()->first()->id)->get()->first()->zones[0])->body;
        }catch (\Exception $e){
            dd($e->getMessage());
        }

        $archi_prods = [];

        foreach ($prods as $prod) {
            if (stripos($prod->productName, 'archipaint') === false) continue;

            $archi_prods[] = $prod;
        }

        Products::where('done', true)->update(['done' => false]);
        Products::where('updated', true)->update(['updated' => false]);

        foreach ($archi_prods as $prod) {
            $product = Products::where('productName', $prod->productName)->get()->first();

            if(is_null($product)) {
                $this->saveUpdateProd($prod);
                continue;
            }

            if(serialize($prod->bases) !== $product->toArray()['val']) $this->saveUpdateProd($prod, $product);

            $product->done = true;
            $product->save();
        }

        Products::where('done', false)->delete();

*/





        $api = new ArchiApi();

        $ws = WorkStations::get()->first();

        if(!$ws) throw new \Exception('Нет рабочих станций');

        $zones = AvailableZones::where('ws_id', $ws->id)->get()->first();

        if(!$zones) throw new \Exception('Нет доступных зон');

        $prods = Products::all();

        if(!count($prods)) throw new \Exception('Нет доступных товаров');

        $colors = ColorsList::all();

        if(!count($colors)) throw new \Exception('Нет доступных цветов');

        foreach ($zones->zones as $zone) {
            foreach ($prods as $prod) {
                foreach ($colors as $color) {
                    try{
                        $response = $api->getColorFormula($ws->workStationColorSystem, $prod->productName, $color->colorCode, $zone);

                        if(!empty($response->error) && $response->error == 'Не найдена формула') continue;

                        $formula = $response->body;

                        dd($formula);
                    }catch (\Exception $e){
                        dd($e->getMessage());
                    }
                }
            }
        }





        dd($api->getColorFormula('Omnitint', 'Archipaint Premium Matt', 'BH01E', 'Hygge_custom1')->body);




        dd($archi_prods);

        dd('done');






        dd($api->getColorFormula('Omnitint', 'Archipaint Premium Matt', 'BH01E', 'Hygge_custom1'));
    }




}
