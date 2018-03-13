# Rule Engine for calculating the Total Price of a Line Item 

[![Build Status](https://travis-ci.org/vaanijya/line-item-price-rule-engine.svg?branch=v0.1)](https://travis-ci.org/vaanijya/line-item-price-rule-engine)

Run the rule engine by suppliing the line item to calculate the all price modifications for that line item

Rules Provider must be supplied as configuration

## How to use
```php
ICircle\LineItemPriceRuleEngine\RuleEngine::run(ICircle\LineItemPriceRuleEngine\LineItem $lineItem);
```
## Configuration
```JSON
{
    "rulesProvider":"MyPackage\\MyRulesProvider"
}
```

`MyPackage\\MyRulesProvider` is expected to implement `ICircle\LineItemPriceRuleEngine\RulesProvider` Interface

