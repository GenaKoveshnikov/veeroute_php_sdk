<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 17.03.15
 * Time: 20:17
 */


require_once(__DIR__.'/../veeroute.php');

class orderTest extends PHPUnit_Framework_TestCase {

    public $data = array(
        'orders'=>array(
            'order'=>array(
                array(
                    'orderReference'=>'Order #1',
                    'areaOfControl'=>'Центральное депо',
                    'date'=>'18.03.2015',
                    'location'=>array(
                        'name'=>'Тверская, 7',
                        'address'=>'Тверская, 7',
                        'latitude'=>55.757899,
                        'longitude'=>37.610791
                    ),
                    'dropWindows'=> array(
                        'dropWindow'=>array(
                            'start'=>'18.03.2015 12:00',
                            'end'=>'18.03.2015 15:00'
                        )
                    ),
                    'durationDrop'=>'00:15'
                ),
                array(
                    'orderReference'=>'Order #2',
                    'areaOfControl'=>'Центральное депо',
                    'date'=>'18.03.2015',
                    'location'=>array(
                        'name'=>'Театр им. Станиславского',
                        'address'=>'Тверская улица, 23'
                    ),
                    'dropWindows'=> array(
                        'dropWindow'=>array(
                            'start'=>'18.03.2015 19:00',
                            'end'=>'18.03.2015 23:00'
                        )
                    ),
                    'durationDrop'=>'00:15'
                )
            )
        )
    );

    public $deleteData = array(
        'orders'=>array(
            'order'=>array(
                array(
                    'orderReference'=>'Order #1',
                ),
                array(
                    'orderReference'=>'Order #2',
                )
            )
        )
    );


    private  $login = 'demo150';
    private $password = '97xUth';
    private $portal = 'demo150';
    private $mode = 'trial';


    public function testXml() {

        $vr = new \veeroute_lib\veeroute($this->login, $this->password, $this->portal, $this->mode);

        $resp = $vr->toXml($this->data);

        $sxe = simplexml_load_string($resp);

        ($sxe)? $status=true:$status=false;

        $this->assertTrue($status);

    }

    public function testSave() {


        $vr = new \veeroute_lib\veeroute($this->login, $this->password, $this->portal, $this->mode);
        $resp = $vr->setOrders($this->data);

        $data = $resp['orders']['order'];
        $status = true;

        for($i=0; $i < count($data); $i++) {

            if(!($data[$i]['status'] == 'Updated' || $data[$i]['status'] == 'Created')) {
                $status = false;
            }
        }

        $this->assertTrue($status);

    }


    public function testDelete() {
        $vr = new \veeroute_lib\veeroute($this->login, $this->password, $this->portal, $this->mode);
        $resp = $vr->deleteOrders($this->deleteData);
        $status = true;

        if(!isset($resp['orders'])) {
            var_dump($resp);
            die();
        }

        $data = $resp['orders']['order'];
        for($i=0; $i < count($data); $i++) {

            if($data[$i]['status'] != 'Deleted') {
                $status = false;
            }
        }

        $this->assertTrue($status);

    }

}
 