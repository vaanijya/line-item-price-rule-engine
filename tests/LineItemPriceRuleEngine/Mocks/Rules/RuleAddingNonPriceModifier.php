<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\PriceModifier;
use Vaanijya\LineItemPriceRuleEngine\LineItem;
use Vaanijya\LineItemPriceRuleEngine\Rule;

class RuleAddingNonPriceModifier implements Rule{
    
    public function exec($lineItem) {
        $nonPriceModifier = get_class();
        $priceModifier = new $nonPriceModifier();
        
        $lineItem->addPriceModifier($priceModifier,'SGD');
    }
    
}