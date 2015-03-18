<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 17.03.15
 * Time: 19:10
 */

namespace veeroute_lib;


class request {

    public static function post($url, $params=null, $headers=null) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);

        if(isset($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $xml = curl_exec($curl);

        curl_close($curl);

        $data = self::toArray($xml);

        return $data;

    }

    private static function toArray($data) {

        $xml = simplexml_load_string($data, null, LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        return $array;
    }

} 