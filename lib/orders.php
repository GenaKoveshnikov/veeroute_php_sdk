<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 17.03.15
 * Time: 19:56
 */

namespace veeroute_lib;

class orders extends \veeroute_lib\veerouteBase {

    private $headers = array('Content-Type: application/xml');

    #create or update method
    public function set($data) {
        $method = 'distribution-api/orders/save';
        return $this->request($method, $data);
    }

    public function delete($data) {
        $method = 'distribution-api/orders/delete';
        return $this->request($method, $data);
    }

    private function request($method, $data) {

        $url = $this->getUrl($this->URL, $method);

        $response = \veeroute_lib\request::post($url, $data, $this->headers);

        return $response;

    }

} 