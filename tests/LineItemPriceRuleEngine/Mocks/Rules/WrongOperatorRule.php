<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks\Rules;

use Vaanijya\LineItemPriceRuleEngine\Rule;
use Vaanijya\LineItemPriceRuleEngine\LineItem;
use Vaanijya\LineItemPriceRuleEngine\PriceModifier;

class WrongOperatorRule implements Rule{

    /**
    * {@inheritDoc}
    * @see \Vaanijya\LineItemPriceRuleEngine\Rule::exec()
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