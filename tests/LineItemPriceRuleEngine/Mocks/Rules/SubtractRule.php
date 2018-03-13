<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\Rule;
use Vaanijya\LineItemPriceRuleEngine\LineItem;
use Vaanijya\LineItemPriceRuleEngine\PriceModifier;

class SubtractRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \Vaanijya\LineItemPriceRuleEngine\Rule::exec()
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