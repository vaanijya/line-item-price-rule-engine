<?php

namespace ICircle\LineItemPriceRuleEngine;

use PhpPlatform\Config\Settings;
use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;

class RuleEngine {
    
    /**
     * @param LineItem $lineItem
     */
    static public function run($lineItem){
        try{
            // validate $lineItem
            if(!($lineItem instanceof LineItem)){
                throw new ProgrammingError('$lineItem is not an instace of '.LineItem::class);
            }
            
            // get the rulesProvider Instance
            $rulesProviderName = Settings::getSettings(Package::Name,'rulesProvider');
            $rulesProviderClass = new \ReflectionClass($rulesProviderName);
            
            if(!$rulesProviderClass->implementsInterface(RulesProvider::class)){
                throw new ProgrammingError("$rulesProviderName does not implement ".RulesProvider::class);
            }
            
            // get rules
            $getRulesMethod = $rulesProviderClass->getMethod('getRules');
            $rules = $getRulesMethod->invoke(null,$lineItem);
            
            // execute rules
            foreach ($rules as $rule){
                if(!($rule instanceof Rule)){
                    throw new ProgrammingError('$rule is not an instace of '.Rule::class);
                }
                $rule->exec($lineItem);
            }
            
        }catch (\Exception $e){
            throw new ProgrammingError('Error in running Rule Engine',$e);
        }
    }
}