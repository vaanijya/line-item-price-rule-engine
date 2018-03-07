<?php
namespace ICircle\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use ICircle\LineItemPriceRuleEngine\Rule;
use ICircle\LineItemPriceRuleEngine\LineItem;
use ICircle\LineItemPriceRuleEngine\PriceModifier;

class SubtractRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \ICircle\LineItemPriceRuleEngine\Rule::exec()
    */
    public function exec($lineItem) {
        $priceModifier = new PriceModifier();
        
        $priceModifier->setRuleId(3);
        $priceModifier->setTitle('Subtract Rule');
        $priceModifier->setOperator(LineItem::PRICE_MODIFIER_OPERATOR_SUBTRACT);
        $priceModifier->setAmount(30.3);
        $lineItem->addPriceModifier($priceModifier);
    }
}