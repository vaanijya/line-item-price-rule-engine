<?php

namespace ICircle\LineItemPriceRuleEngine;

/**
 * A rule must implement this interface
 */
interface Rule {
    
    /**
     * This method should execute the rule
     * A rule can add 0 or more PriceModifiers to the supplied LineItem
     *
     * @param LineItem $lineItem
     */
    function exec($lineItem);
    
}