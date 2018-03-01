<?php

namespace ICircle\LineItemPriceRuleEngine;

/**
 * This class represents the PriceModifier, 
 * set of properties that modifies the price of the amount 
 * example :- Tax , Discount, RoundOf, Shipping Charges ... etc
 */
class PriceModifier {
    
    /**
     * @var int
     */
    private $id = null;
    
    /**
     * @var string
     */
    private $title = null;
    
    /**
     * @var float
     */
    private $amount = null;
    
    /**
     * @var string
     */
    private $operator = null;
    
    /**
     * @var int
     */
    private $ruleId = null;
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return PriceModifier
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * @param string $title
     * @return PriceModifier
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    /**
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }
    
    /**
     * @param float $amount
     * @return PriceModifier
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getOperator() {
        return $this->operator;
    }
    
    /**
     * @param string $operator
     * @return PriceModifier
     */
    public function setOperator($operator) {
        $this->operator = $operator;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRuleId() {
        return $this->ruleId;
    }
    
    /**
     * @param int $ruleId
     * @return PriceModifier
     */
    public function setRuleId($ruleId) {
        $this->ruleId = $ruleId;
        return $this;
    }
    
}