<?php
namespace ICircle\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use ICircle\LineItemPriceRuleEngine\PriceModifier;
use ICircle\LineItemPriceRuleEngine\LineItem;
use ICircle\LineItemPriceRuleEngine\Rule;

class RuleAddingNonPriceModifier implements Rule{
    
    public function exec($lineItem) {
        $nonPriceModifier = get_class();
        $priceModifier = new $nonPriceModifier();
        
        $lineItem->addPriceModifier($priceModifier,'SGD');
    }
    
}