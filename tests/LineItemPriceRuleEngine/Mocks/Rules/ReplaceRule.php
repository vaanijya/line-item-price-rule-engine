<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\Rule;
use Vaanijya\LineItemPriceRuleEngine\LineItem;
use Vaanijya\LineItemPriceRuleEngine\PriceModifier;

class ReplaceRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \Vaanijya\LineItemPriceRuleEngine\Rule::exec()
    */
    public function exec($lineItem) {
        $priceModifier = new PriceModifier();
        
        $priceModifier->setRuleId(1);
        $priceModifier->setTitle('Replace Rule');
        $priceModifier->setOperator(LineItem::PRICE_MODIFIER_OPERATOR_REPLACE);
        $priceModifier->setAmount(200);
        $lineItem->addPriceModifier($priceModifier,'SGD');
    }
}