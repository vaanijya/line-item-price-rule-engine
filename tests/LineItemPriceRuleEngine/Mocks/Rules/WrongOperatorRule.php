<?php
namespace ICircle\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use ICircle\LineItemPriceRuleEngine\Rule;
use ICircle\LineItemPriceRuleEngine\LineItem;
use ICircle\LineItemPriceRuleEngine\PriceModifier;

class WrongOperatorRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \ICircle\LineItemPriceRuleEngine\Rule::exec()
    */
    public function exec($lineItem) {
        $priceModifier = new PriceModifier();
        
        $priceModifier->setRuleId(5);
        $priceModifier->setTitle('Wrong Operator Rule');
        $priceModifier->setOperator('percentage');
        $priceModifier->setAmount(20);
        $lineItem->addPriceModifier($priceModifier);
    }
}