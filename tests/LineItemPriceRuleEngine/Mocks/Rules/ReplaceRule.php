<?php
namespace ICircle\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use ICircle\LineItemPriceRuleEngine\Rule;
use ICircle\LineItemPriceRuleEngine\LineItem;
use ICircle\LineItemPriceRuleEngine\PriceModifier;

class ReplaceRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \ICircle\LineItemPriceRuleEngine\Rule::exec()
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