# Veeroute PHP SDK

## Установка
  * склонируйте проект: `git clone git@github.com:AOutStartups/veeroute_php_sdk.git`
  * инициализируйте composer: `composer update` из папки с проектом. Если нет composer, инструкция по установке: https://getcomposer.org/doc/00-intro.md

## Методы
В данной версии поддерживается:
* авторизация
* работа с заказами
    * сохранение
    * обновление
    * удаление

Все точки при создании привязываются к уникальному `orderReference`, который задаете вы. Он не должен повторяться. При обновлении точки вы должны вызвать тот же метод, что и при создании (`setOrders`), но уже с существующим `orderReference`. В таком случае, вы перезапишите информацию в точке с заданным `orderReference`. 

Подробное описание всех возможных методов api: https://veeroute.zendesk.com/hc/ru/categories/200466271-REST-API-v-2-2-%D0%A1%D0%BF%D0%B5%D1%86%D0%B8%D1%84%D0%B8%D0%BA%D0%B0%D1%86%D0%B8%D1%8F

## Настройки
* в файле `veeroute_base.php` необходимо указать url (`$URL`), на который будете делать запрос:
   * для тестового аккаунта - `trial.veeroute.com`.
   * для рабочего аккаунта - `prof.veeroute.com`

## Примеры
### Пример добавления заказов
```
  require_once(__DIR__.'/../veeroute.php');
  
  class exampleClass {
  
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
    
    private $login = '<Ваш логин>';
    private $password = '<Ваш пароль>';
    private $portal = '<Ваш аккаунт>';
    
      public function testSave() {

        $vr = new \veeroute_lib\veeroute($this->login, $this->password, $this->portal);
        $resp = $vr->setOrders($this->data);

        print_r($resp);
        exit();
    
    }
    
  }
  
  
  $ex = new exampleClass();
  $ex->testSave();
```

Все примеры есть в папке `tests`
