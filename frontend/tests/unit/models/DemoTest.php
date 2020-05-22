<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\services\CommonService;

class DemoTest extends Unit
{

    // php unit test command for frontend module :
    // command : vendor/bin/codecept run -- -c frontend

    public function testBingo()
    {
        $greeting = 'code exception bingo';
        $ret_greeting = CommonService::greeting($greeting);
        expect($ret_greeting)->contains($greeting);
    }

    public function testCompareArray()
    {
        $company = [
            'name' => 'Panda Tech Ltd.',
            'founder' => 'Kevin',
            'tag' => ['i18n', 'IOT', 'hardware', 'Industrial Internet']
        ];
        $obj_company = CommonService::array_to_object($company);
        expect($obj_company)->equals($obj_company);
    }

}
