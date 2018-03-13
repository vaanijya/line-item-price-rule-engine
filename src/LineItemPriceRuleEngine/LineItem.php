<?php

namespace Vaanijya\LineItemPriceRuleEngine;

use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;

/**
 * This class represents a Line Item and contains all Price Modifiers applied during Rule execution
 */
abstract class LineItem {
    
    private $unitPrice = 0;
    private $currencyOfUnitPrice = null;
    private $unitOfMeasure = null;
    
    private $quantity  = 0;
    private $unitOfMeasureOfQuantity = null;
    
    private $totalPrice = 0;
    private $currencyOfTotalPrice = null;
    
    /**
     * @var PriceModifier[]
     */
    private $priceModifiers = [];
    
    const PRICE_MODIFIER_OPERATOR_ADD = 'add';
    const PRICE_MODIFIER_OPERATOR_SUBTRACT = 'subtract';
    const PRICE_MODIFIER_OPERATOR_REPLACE = 'replace';
    
    // all setters are protected , values needs to be set by inherited class
    
    /**
     * @param float $unitPrice
     * @return LineItem
     */
    protected function setUnitPrice($unitPrice) {
        $this->unitPrice = $unitPrice;
        return $this;
    }
    
    /**
     * @param string $currencyOfUnitPrice
     * @return LineItem
     */
    protected function setCurrencyOfUnitPrice($currencyOfUnitPrice) {
        $this->currencyOfUnitPrice = $currencyOfUnitPrice;
        $this->currencyOfTotalPrice = $currencyOfUnitPrice;
        return $this;
    }
    
    /**
     * @param string $unitOfMeasure
     * @return LineItem
     */
    protected function setUnitOfMeasure($unitOfMeasure) {
        $this->unitOfMeasure = $unitOfMeasure;
        return $this;
    }
    
    /**
     * @param float $quantity
     * @return LineItem
     */
    protected function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }
    
    /**
     * @param string $unitOfMeasureOfQuantity
     * @return LineItem
     */
    protected function setUnitOfMeasureOfQuantity($unitOfMeasureOfQuantity) {
        $this->unitOfMeasureOfQuantity = $unitOfMeasureOfQuantity;
        return $this;
    }
    

    
    // all getters are public
    
    /**
     * @return float unitPrice
     */
    public function getUnitPrice() {
        return $this->unitPrice;
    }
    
    /**
     * @return float quantity
     */
    public function getQuantity() {
        return $this->quantity;
    }
    
    /**
     * @return string unitOfMeasure
     */
    public function getUnitOfMeasure() {
        return $this->unitOfMeasure;
    }
    
    /**
     * @return string unitOfMeasureOfQuantity
     */
    public function getUnitOfMeasureOfQuantity() {
        return $this->unitOfMeasureOfQuantity;
    }
    
    /**
     * @return float totalPrice
     */
    public function getTotalPrice() {
        return $this->totalPrice;
    }
    
    /**
     * @return string currencyOfUnitPrice
     */
    public function getCurrencyOfUnitPrice() {
        return $this->currencyOfUnitPrice;
    }
    
    /**
     * @return string currencyOfTotalPrice
     */
    public function getCurrencyOfTotalPrice() {
        return $this->currencyOfTotalPrice;
    }
    
    /**
     * @param PriceModifier $priceModifier
     * 
     * @return LineItem
     */
    public function addPriceModifier($priceModifier,$newCurencyForTotalPrice = null){
        if(!($priceModifier instanceof PriceModifier)){
            throw new ProgrammingError('$priceModifier should be an instance of ICircle\LineItemPriceRuleEngine\PriceModifier');
        }
        $ruleId = $priceModifier->getRuleId();
        if(array_key_exists($ruleId, $this->priceModifiers)){
            throw new ProgrammingError("PriceModifier with ruleId $ruleId is already Added");
        }
        
        switch ($priceModifier->getOperator()){
            case self::PRICE_MODIFIER_OPERATOR_ADD: 
                $this->totalPrice = $this->totalPrice + $priceModifier->getAmount();
                break;
            case self::PRICE_MODIFIER_OPERATOR_SUBTRACT:
                $this->totalPrice = $this->totalPrice - $priceModifier->getAmount();
                break;
            case self::PRICE_MODIFIER_OPERATOR_REPLACE:
                $this->totalPrice = $priceModifier->getAmount();
                if(isset($newCurencyForTotalPrice)){
                    $this->currencyOfTotalPrice = $newCurencyForTotalPrice;
                }
                break;
            default:
                throw new ProgrammingError('Unsupported Operator in PriceModifier');
        }
        
        $this->priceModifiers[$ruleId] = $priceModifier;
        
        return $this;
    }
    
    /**
     * @param int $ruleId
     * @return PriceModifier
     */
    public function getPriceModifier($ruleId){
        if(array_key_exists($ruleId, $this->priceModifiers)){
            return $this->priceModifiers[$ruleId];
        }else{
            null;
        }
    }
    
    /**
     * @return PriceModifier[]
     */
    public function getPriceModifiers(){
        return $this->priceModifiers;
    }
    
}