<?php
namespace Vaanijya\Tests\LineItemPriceRuleEngine\Mocks;

use Vaanijya\LineItemPriceRuleEngine\RulesProvider as IRulesProvider;

class RulesProvider implements IRulesProvider{
    
    static $rules = [];
    
    /**
    * {@inheritDoc}
    * @see \ICircle\LineItemPriceRuleEngine\RulesProvider::getRules()
    */
    static public function getRules($lineItem) {
        $rules = [];
        foreach (self::$rules as $ruleClassName){
            $rules[] = new $ruleClassName();
        }
        return $rules;
    }

}