<?php

use Illuminate\Support\Collection;

class Geocoding {

    public static function geocode($address) {
        // url encode the address
        $address = urlencode($address);
        // google map geocode api url (in Spain)
        $url = "http://maps.google.es/maps/api/geocode/json?sensor=false&address={$address}";
        // get the json response
        $resp_json = file_get_contents($url);
        // decode the json
        $resp = json_decode($resp_json, true);
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $loni = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];
            // verify if data is complete
            if($lati && $loni && $formatted_address){
                // put the data in the array
                $data_arr = array();
                array_push(
                    $data_arr,
                    $lati,
                    $loni,
                    $formatted_address
                );
                return $data_arr;
            }else{
                return false;
            }
        }else{
            return false;
        }
    } // function to geocode address, it will return false if unable to geocode address

    public static function findWithinDistance($lat_origin,$lon_origin,$distance_range,$locations_collection)
    {
        if ($distance_range=='rang2') {
            $min_distance = 0;
            $max_distance = 50;
        } else if ($distance_range=='rang1') {
            $min_distance = 0;
            $max_distance = 5;
        } else { //if rang0, any other case also defaults to rang0
            $min_distance = 0;
            $max_distance = 2;
        }
        //Latitud y Longitud vienen en grados sexagesimales desde el API de Google o la base de datos
        $R = 6371.01; //Radio de la Tierra, en km
        $r = $max_distance/$R; //1 radián (aproximación por exceso)
        $latr = deg2rad($lat_origin); //Pasamos a radianes
        $lonr = deg2rad($lon_origin);
        $min_lat = rad2deg($latr-$r); //Pasamos a grados
        $max_lat = rad2deg($latr+$r);
        $delta_lon = asin(sin($r)/cos($latr));
        $min_lon = rad2deg($lonr-$delta_lon);
        $max_lon = rad2deg($lonr+$delta_lon);


        $filtered_collection = $locations_collection->filter(function($location) use ($min_lat,$max_lat,$min_lon,$max_lon)
        {
            if ($location->lat >= $min_lat && $location->lat <= $max_lat && $location->lon >= $min_lon && $location->lon <= $max_lon)
                return true;
        }); //Primer filtro

        if (!$filtered_collection->isEmpty())
        {
            $filtered_collection = $filtered_collection->filter(function($location) use ($R,$latr,$lonr,$min_distance,$max_distance)
            {
                $distance = $R*acos(sin($latr)*sin(deg2rad($location->lat))+cos($latr)*cos(deg2rad($location->lat))*cos(deg2rad($location->lon)-$lonr));
                if ($distance >= $min_distance && $distance <= $max_distance) {
                    $dist_to_user = (ceil($distance) < 1) ? 1 : ceil($distance);
                    $location->dist_to_user = $dist_to_user;
                    return true;
                }
            }); //Segundo filtro
        }

        return $filtered_collection;
    } //Filtering function, check if elements inside a collection of locations are within a given distance

    public static function dbFindWithin($lat, $lon, $distance, $limit, $prof_o_acad)
    {
        $R = 6371.01; //radio de la tierra promedio (en km)
        $r = $distance/$R; //angulo en radianes que equivale a recorrer $distance kms sobre un círculo de radio el de la Tierra
        $latr = deg2rad($lat); //en rads
        $lonr = deg2rad($lon); //en rads
        $min_lat = rad2deg($latr-$r); //en sexag
        $max_lat = rad2deg($latr+$r); //en sexag
        $delta_lon = asin(sin($r)/cos($latr)); //en rads
        $min_lon = rad2deg($lonr-$delta_lon); //en sexag
        $max_lon = rad2deg($lonr+$delta_lon); //en sexag

        $select = "({$R}*ACOS(SIN({$latr})*SIN(RADIANS(lat))+COS({$latr})*COS(RADIANS(lat))*COS(RADIANS(lon)-{$lonr}))) AS distance";

        if ($prof_o_acad == 'profesor')
        {
            $results = DB::table('teachers')
                ->select(DB::raw('teachers.*, '.$select))
                ->where('lat','>=',$min_lat)
                ->where('lat','<=',$max_lat)
                ->where('lon','>=',$min_lon)
                ->where('lon','<=',$max_lon)
                ->having('distance','<=',$distance)
                ->orderBy('distance','asc')
                ->take($limit)
                ->get();
        }
        else
        {
            $results = DB::table('schools')
                ->select(DB::raw('schools.*, '.$select))
                ->where('lat','>=',$min_lat)
                ->where('lat','<=',$max_lat)
                ->where('lon','>=',$min_lon)
                ->where('lon','<=',$max_lon)
                ->having('distance','<=',$distance)
                ->orderBy('distance','asc')
                ->take($limit)
                ->get();
        }

        return $results;
    }

    public static function GMapCircle($Lat,$Lng,$Rad,$Detail=8){
        $R    = 6371;
        $pi   = pi();
        $Lat  = ($Lat * $pi) / 180;
        $Lng  = ($Lng * $pi) / 180;
        $d    = $Rad / $R;
        $points = array();
        for($i = 0; $i <= 360; $i+=$Detail):
            $brng = $i * $pi / 180;
            $pLat = asin(sin($Lat)*cos($d) + cos($Lat)*sin($d)*cos($brng));
            $pLng = (($Lng + atan2(sin($brng)*sin($d)*cos($Lat), cos($d)-sin($Lat)*sin($pLat))) * 180) / $pi;
            $pLat = ($pLat * 180) /$pi;
            $points[] = array($pLat,$pLng);
        endfor;
        require_once('PolylineEncoder.php');
        $PolyEnc   = new PolylineEncoder($points);
        $EncString = $PolyEnc->dpEncode();

        return $EncString['Points'];
    }

}