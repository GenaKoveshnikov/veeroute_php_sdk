<?php

namespace veeroute_lib;

require_once(__DIR__.'/veeroute_base.php');


class veeroute extends \veeroute_lib\veerouteBase {

    public function __construct($login=null, $password=null, $portal=null) {

        if(!isset($this->access_token) && isset($login)) {
            #set access token
            if(isset($password) && isset($portal)) {
                $this->setUserData($login, $password, $portal);
                $this->authorization();
            } else {
                throw new \Exception('error in class: '.__CLASS__.'; we haven\'t all need variables: password or portal');
            }
        }
    }


    public function setOrders($data=null) {
        $data = $this->toXml($data, $this->access_token);

        $orders = new \veeroute_lib\orders();
        $status = $orders->set($data);

        return $status;

    }

    public function deleteOrders($data=null) {
        $data = $this->toXml($data, $this->access_token);

        $orders = new \veeroute_lib\orders();
        $status = $orders->delete($data);

        return $status;
    }





} 