<?php

require_once(__DIR__.'/../veeroute.php');

use \veeroute_lib as VR;

class mainTest extends PHPUnit_Framework_TestCase {

    public function testAuth() {

        $login = 'demo150';
        $password = '97xUth';
        $portal = 'demo150';
        $mode = 'trial';

        $auth = new \veeroute_lib\auth();
        $auth->data = array('user'=>$login, 'password'=>$password, 'accountID'=>$portal);
        $access_token = $auth->setSession();

        $key_len = strlen($access_token);

        $this->assertEquals(32, $key_len);

    }

}
 