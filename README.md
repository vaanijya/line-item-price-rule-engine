# Rule Engine for calculating the Total Price of a Line Item 

[![pipeline status](https://gitlab.com/codecov-ic-lipre/line-item-price-rule-engine/badges/v0.1/pipeline.svg)](https://gitlab.com/codecov-ic-lipre/line-item-price-rule-engine/commits/v0.1)

[![coverage report](https://gitlab.com/codecov-ic-lipre/line-item-price-rule-engine/badges/v0.1/coverage.svg)](https://gitlab.com/codecov-ic-lipre/line-item-price-rule-engine/commits/v0.1)

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

