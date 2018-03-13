<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\PriceModifier;
use Vaanijya\LineItemPriceRuleEngine\LineItem;

class RuleWithoutInterface {
    
    public function exec($lineItem) {
        $priceModifier = new PriceModifier();
        
        $priceModifier->setRuleId(4);
        $priceModifier->setTitle('Rule Without Interface');
        $priceModifier->setOperator(LineItem::PRICE_MODIFIER_OPERATOR_REPLACE);
        $priceModifier->setAmount(200);
        $lineItem->addPriceModifier($priceModifier,'SGD');
    }
    
}