<?php 
namespace App\Tests;
    
class CategoryCest
{
    public function CreateWithoutParamsTest(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/categories');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeResponseContainsJson(["errors" => []]);
    }
    
    public function CreateRight1Test(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/categories', ['name' => 'title 1']);
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }

    public function CreateRight2Test(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/categories', ['name' => 'title 2']);
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }

    public function RemoveTest(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/categories/1');
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }
}
