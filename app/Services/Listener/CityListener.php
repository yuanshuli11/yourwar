<?php 

namespace App\Services\Listener;
use App\Model\City\City;
use App\Model\City\CityBuilding;


/**
* ArticleListener
*/
class CityListener {

    public static function Listener()
    {
        City::created(function($city) {
            $newcity = CityBuilding::newcity($city->id);
          

        });
        City::updated(function($city) {


        });
        City::deleted(function($city) {


        });




    }
}