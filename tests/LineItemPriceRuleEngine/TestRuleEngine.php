<?php
namespace ICircle\Tests\LineItemPriceRuleEngine;

use PHPUnit\Framework\TestCase;
use ICircle\Tests\LineItemPriceRuleEngine\Mocks\RulesProvider;
use ICircle\LineItemPriceRuleEngine\RuleEngine;
use ICircle\Tests\LineItemPriceRuleEngine\Mocks\LineItem;
use PhpPlatform\Mock\Config\MockSettings;
use ICircle\LineItemPriceRuleEngine\Package;

class TestRuleEngine extends TestCase {
    
    /**
     * @dataProvider dataProviderRun
     */
    function testRun($lineItemParams,$rules,$expectedLineItem,$expectedException = null){
        
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
    }
    
    function dataProviderRun(){
        return [
            'Simple Test' =>[
                [100,'INR','',2,'INR'],
                ['ReplaceRule'],
                ['unitPrice'=>[100,'INR',''],'quantity'=>[2,'INR'],'total'=>[200,'INR']]
            ]
        ];
    }
}