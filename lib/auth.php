<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 17.03.15
 * Time: 18:15
 */

namespace veeroute_lib;


class auth extends \veeroute_lib\veerouteBase {

    public $data = null;

    public function setSession() {
        $method = 'authentication/createSession';

        $url = $this->getUrl($this->URL, $method, $this->data);
        $data = \veeroute_lib\request::post($url);

        #check errors (already single error message)
        $this->errorSingle($data);

        return $data['authResponse']['sessionID'];
    }


    public function toArray($access_token=null) {
        if(!isset($access_token)) {
            $access_token = $this->access_token;
        }
        return array('sessionID'=>$access_token);
    }


}

