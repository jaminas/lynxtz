<?php 

namespace App\Tests;

class ArticleCest
{
    public function CreateWithoutParamsTest(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/articles');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeResponseContainsJson(["errors" => []]);
    }
    
    public function CreateRight1Test(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/articles', ['title' => 'title 1', 'text' => 'some text']);
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }

    public function CreateRight2Test(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/articles', ['title' => 'title 2', 'text' => 'some text']);
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }

    public function RemoveTest(ApiTester $I)
    {      
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/articles/1');
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeHttpHeader("Content-Type", "application/json");
        $I->seeHttpHeaderOnce("Content-Type");
        $I->seeResponseContainsJson(["status" => "ok"]);
    }
}
