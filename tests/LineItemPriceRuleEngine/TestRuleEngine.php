<?php
namespace ICircle\Tests\LineItemPriceRuleEngine;

use PHPUnit\Framework\TestCase;
use ICircle\Tests\LineItemPriceRuleEngine\Mocks\RulesProvider;
use ICircle\LineItemPriceRuleEngine\RuleEngine;
use ICircle\Tests\LineItemPriceRuleEngine\Mocks\LineItem;
use PhpPlatform\Mock\Config\MockSettings;
use ICircle\LineItemPriceRuleEngine\Package;
use ICircle\LineItemPriceRuleEngine\LineItem as ALineItem;
use ICircle\Tests\LineItemPriceRuleEngine\Mocks\RulesProviderWithoutInterface;

class TestRuleEngine extends TestCase {
    
    private $error_log = null;
    function setUp(){
        $this->error_log = tempnam(sys_get_temp_dir(),'LIPRE');
        MockSettings::setSettings('php-platform/errors', 'logs', [
            "Persistence"=>$this->error_log,
            "Application"=>$this->error_log,
            "Http"=>$this->error_log,
            "System"=>$this->error_log
        ]);
    }
    
    function tearDown(){
        unlink($this->error_log);
    }
    
    /**
     * @dataProvider dataProviderRun
     * 
     * @todo assert the log lines 
     */
    function testRun($lineItemParams,$rules,$expectedLineItem,$expectedException = null,$expectedErrorLog = null){
        
        $lineItem = new LineItem($lineItemParams);
        
        RulesProvider::$rules = array_map(function($rule){return 'ICircle\Tests\LineItemPriceRuleEngine\Mocks\Rules\\'.$rule;}, $rules);
        
        MockSettings::setSettings(Package::Name, 'rulesProvider', RulesProvider::class);
        
        try{
            RuleEngine::run($lineItem);
        }catch (\Exception $e){
            $this->assertEquals($expectedException, $e->getMessage());
        }
        
        $this->assertEquals($expectedLineItem['unitPrice'][0], $lineItem->getUnitPrice());
        $this->assertEquals($expectedLineItem['unitPrice'][1], $lineItem->getCurrencyOfUnitPrice());
        $this->assertEquals($expectedLineItem['unitPrice'][2], $lineItem->getUnitOfMeasure());
        
        $this->assertEquals($expectedLineItem['quantity'][0], $lineItem->getQuantity());
        $this->assertEquals($expectedLineItem['quantity'][1], $lineItem->getUnitOfMeasureOfQuantity());
        
        $this->assertEquals($expectedLineItem['total'][0], $lineItem->getTotalPrice());
        $this->assertEquals($expectedLineItem['total'][1], $lineItem->getCurrencyOfTotalPrice());
        
        
        $this->assertCount(count($expectedLineItem['priceModifiers']), $lineItem->getPriceModifiers());
        
        foreach ($expectedLineItem['priceModifiers'] as $expectedPriceModifier){
            $actualPriceModifier = $lineItem->getPriceModifier($expectedPriceModifier[0]);
            
            $this->assertEquals($expectedPriceModifier[0], $actualPriceModifier->getRuleId());
            $this->assertEquals($expectedPriceModifier[1], $actualPriceModifier->getTitle());
            $this->assertEquals($expectedPriceModifier[2], $actualPriceModifier->getAmount());
            $this->assertEquals($expectedPriceModifier[3], $actualPriceModifier->getOperator());
        }
        
        if($expectedErrorLog != null){
            $this->assertContains($expectedErrorLog, file_get_contents($this->error_log));
        }
    }
    
    function dataProviderRun(){
        return [
            'Simple Test' =>[
                [100,'INR','',2,'INR'],
                ['ReplaceRule'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[200,'SGD'],
                    'priceModifiers' => [
                        [1,'Replace Rule',200,ALineItem::PRICE_MODIFIER_OPERATOR_REPLACE]
                    ]
                ]
            ],
            'test with multiple rules' =>[
                [100,'INR','',2,'INR'],
                ['ReplaceRule','AddRule','SubtractRule'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[189.7,'SGD'],
                    'priceModifiers' => [
                        [1,'Replace Rule',200,ALineItem::PRICE_MODIFIER_OPERATOR_REPLACE],
                        [2,'Add Rule',20,ALineItem::PRICE_MODIFIER_OPERATOR_ADD],
                        [3,'Subtract Rule',30.3,ALineItem::PRICE_MODIFIER_OPERATOR_SUBTRACT]
                    ]
                ]
            ],
            'test with repeating rule id' =>[
                [100,'INR','',2,'INR'],
                ['ReplaceRule','AddRule','ReplaceRule'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[220,'SGD'],
                    'priceModifiers' => [
                        [1,'Replace Rule',200,ALineItem::PRICE_MODIFIER_OPERATOR_REPLACE],
                        [2,'Add Rule',20,ALineItem::PRICE_MODIFIER_OPERATOR_ADD]
                    ]
                ],
                'Error in running Rule Engine',
                '[A] PriceModifier with ruleId 1 is already Added : PhpPlatform\Errors\Exceptions\Application\ProgrammingError'
            ],
            'test Rule adding non PriceModifier' =>[
                [100,'INR','',2,'INR'],
                ['RuleAddingNonPriceModifier'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[null,'INR'],
                    'priceModifiers' => []
                ],
                'Error in running Rule Engine',
                '[A] $priceModifier should be an instance of ICircle\LineItemPriceRuleEngine\PriceModifier : PhpPlatform\Errors\Exceptions\Application\ProgrammingError'
            ],
            'test Rule without implementing the Rule interface' =>[
                [100,'INR','',2,'INR'],
                ['RuleWithoutInterface'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[null,'INR'],
                    'priceModifiers' => []
                ],
                'Error in running Rule Engine',
                '[A] $rule is not an instace of ICircle\LineItemPriceRuleEngine\Rule : PhpPlatform\Errors\Exceptions\Application\ProgrammingError'
            ],
            'test Rule with wrong operator' =>[
                [100,'INR','',2,'INR'],
                ['WrongOperatorRule'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[null,'INR'],
                    'priceModifiers' => []
                ],
                'Error in running Rule Engine',
                '[A] Unsupported Operator in PriceModifier : PhpPlatform\Errors\Exceptions\Application\ProgrammingError'
            ]
        ];
    }
    
    function testRunWithWrongLineItem(){
        $lineItem = $this;
        $isException = false;
        try{
            RuleEngine::run($lineItem);
        }catch (\Exception $e){
            $this->assertEquals('Error in running Rule Engine', $e->getMessage());
            $isException = true;
        }
        $this->assertTrue($isException);
        $this->assertContains('[A] $lineItem is not an instace of ICircle\LineItemPriceRuleEngine\LineItem : PhpPlatform\Errors\Exceptions\Application\ProgrammingError', file_get_contents($this->error_log));
        
    }
    
    function testRunWithWrongRuleEngine(){
        $lineItem = new LineItem([100,'INR','',2,'INR']);
        
        // setting a RulesProvider without interface
        MockSettings::setSettings(Package::Name, 'rulesProvider', RulesProviderWithoutInterface::class);
        $isException = false;
        try{
            RuleEngine::run($lineItem);
        }catch (\Exception $e){
            $this->assertEquals('Error in running Rule Engine', $e->getMessage());
            $isException = true;
        }
        $this->assertTrue($isException);
        $this->assertContains('[A] ICircle\Tests\LineItemPriceRuleEngine\Mocks\RulesProviderWithoutInterface does not implement ICircle\LineItemPriceRuleEngine\RulesProvider : PhpPlatform\Errors\Exceptions\Application\ProgrammingError', file_get_contents($this->error_log));
        

        // setting no RulesProvider
        MockSettings::setSettings(Package::Name, 'rulesProvider', '');
        $isException = false;
        try{
            RuleEngine::run($lineItem);
        }catch (\Exception $e){
            $this->assertEquals('Error in running Rule Engine', $e->getMessage());
            $isException = true;
        }
        $this->assertTrue($isException);
        $this->assertContains('[A] ICircle\Tests\LineItemPriceRuleEngine\Mocks\RulesProviderWithoutInterface does not implement ICircle\LineItemPriceRuleEngine\RulesProvider : PhpPlatform\Errors\Exceptions\Application\ProgrammingError', file_get_contents($this->error_log));
        
    }
}