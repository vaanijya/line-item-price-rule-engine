<?php

namespace Vaanijya\LineItemPriceRuleEngine;

/**
 * This Interface needs to be implemented by the Actual Rules Provider class , and that class needs to be configured in config.json
 */
interface RulesProvider {
    
    /**
     * This method should return array of rules for the supplied Line Item
     * 
     * @param LineItem $lineItem
     * @return Rule[]
     */
    static function getRules($lineItem);
}