<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 18.03.15
 * Time: 16:39
 */


namespace veeroute_lib;

require_once(__DIR__.'/lib/auth.php');
require_once(__DIR__.'/lib/request.php');
require_once(__DIR__.'/lib/orders.php');
//require_once(__DIR__.'/external_lib/xml2array/verdant/Array2XML.php');

use Verdant;

if (!function_exists('curl_init')) {
    throw new \Exception('VeeRoute SDK needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new \Exception('VeeRoute SDK needs the JSON PHP extension.');
}


abstract class veerouteBase {

    public $URL = 'http://trial.veeroute.com/rest/2/';

    public $methods = array(
        'auth'=>'authentication',
        'orders'=>'distribution-api/orders/'
    );

    public $user_data = array(
        'user'=>null,
        'password'=>null,
        'accountID'=>null
    );

    public $access_token = null;


    public function getUrl($domain=null, $method=null, $args=null) {
        $url = null;
        if(isset($domain) && isset($method)) {
            $url = $domain.$method;
            if(isset($args)) {
                $url = $url.'?'.http_build_query($args);
            }
        } else {
            throw new \Exception('error in class: '.__CLASS__.'; we haven\'t all need variables: domain or method');
        }
        return $url;
    }

    public function authorization() {
        $user = $this->user_data;

        $auth = new auth();
        $auth->data = $this->user_data;
        $access_token = $auth->setSession();

        $this->access_token = $access_token;

    }

    public function setUserData($login, $password, $portal) {

        $this->user_data['user'] = $login;
        $this->user_data['password'] = $password;
        $this->user_data['accountID'] = $portal;

        return $this;
    }



    public function toXml($data, $access_token=null) {

        if(isset($access_token)) {
            $auth = new \veeroute_lib\auth();
            $auth_array = $auth->toArray($access_token);
            $data = array_merge($auth_array, $data);
        }

        $data = array('apiRequest'=>$data);

        $xml = \Verdant\Array2XML::createXML($data);

        return $xml->saveXML();

    }


    public static function errorSingle($data) {

        if(isset($data['error']) && is_array($data['error'])) {
            throw new \Exception('error in class: '.__CLASS__.'; error code: '.$data['error']['errorCode']. ', message: '.$data['error']['errorMessage']);
        }

    }

}
