<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks;

use Vaanijya\LineItemPriceRuleEngine\LineItem as ALineItem;

class LineItem extends ALineItem{
    
    function __construct($params = null){
        $this->setUnitPrice($params[0]);
        $this->setCurrencyOfUnitPrice($params[1]);
        $this->setUnitOfMeasure($params[2]);
        $this->setQuantity($params[3]);
        $this->setUnitOfMeasureOfQuantity($params[4]);
    }
}