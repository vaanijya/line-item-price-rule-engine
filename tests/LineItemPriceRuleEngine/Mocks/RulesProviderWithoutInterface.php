<?php
namespace ICircle\Tests\LineItemPriceRuleEngine\Mocks;

class RulesProviderWithoutInterface {
    
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