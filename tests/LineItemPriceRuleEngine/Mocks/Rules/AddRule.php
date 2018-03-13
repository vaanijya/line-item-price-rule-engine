<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\Rule;
use Vaanijya\LineItemPriceRuleEngine\LineItem;
use Vaanijya\LineItemPriceRuleEngine\PriceModifier;

class AddRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \Vaanijya\LineItemPriceRuleEngine\Rule::exec()
    */
    public function exec($lineItem) {
        $priceModifier = new PriceModifier();
        
        $priceModifier->setRuleId(2);
        $priceModifier->setTitle('Add Rule');
        $priceModifier->setOperator(LineItem::PRICE_MODIFIER_OPERATOR_ADD);
        $priceModifier->setAmount(20);
        $lineItem->addPriceModifier($priceModifier);
    }
}