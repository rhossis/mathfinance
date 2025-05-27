<?php
//declare namespace
namespace rhossis\mathfinance\MathFinance;

use \rhossis\mathfinance\MathFinance\abstractclass\MathFinanceAbstract;

/**
 * MathFinance: CYMAPGT Class of financial functions
 *
 * Assorted financial functions for interest rates, bonds, amortizations and
 * time value of money calculations (annuities)
 * Same interface as Excel financial functions.
 *
 * PHP versions 5.4+
 *
 * @category   Math
 * @package    MathFinance
 * @author     <cogana@gmail.com>
 * @copyright  2013 CYMAPGT
 */
class MathFinance extends MathFinanceAbstract
{
    public function daysDifference($date1, $date2, $basis) {
        return parent::_daysDifference($date1, $date2, $basis);
    }

    public function daysPerYear($year, $basis) {
        return parent::_daysPerYear($year, $basis);
    }

    public function depreciationFixedDeclining($cost, $salvage, $life, $period, $month = 12) {
        return parent::_depreciationFixedDeclining($cost, $salvage, $life, $period, $month);
    }

    public function depreciationStraightLine($cost, $salvage, $life) {
        return parent::_depreciationStraightLine($cost, $salvage, $life);
    }

    public function discountRate($settlement, $maturity, $pr, $redemption, $basis = 0) {
        return parent::_discountRate($settlement, $maturity, $pr, $redemption, $basis);
    }

    public function effectiveRate($nominal_rate, $npery) {
        return parent::_effectiveRate($nominal_rate, $npery);
    }

    public function futureValue($rate, $nper, $pmt, $pv = 0, $type = 0) {
        return parent::_futureValue($rate, $nper, $pmt, $pv, $type);
    }

    public function interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type) {
        return parent::_interestAndPrincipal($rate,$per,$nper,$pv,$fv,$type);
    }

    public function interestPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0) {
        return parent::_interestPayment($rate, $per, $nper, $pv, $fv, $type);
    }

    public function internalRateOfReturn($values, $guess = 0.1) {
        return parent::_internalRateOfReturn($values, $guess);
    }

    public function modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate) {
        return parent::_modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate);
    }

    public function netPresentValue($rate, $values) {
        return parent::_netPresentValue($rate, $values);
    }

    public function nominalRate($effect_rate, $npery) {
        return parent::_nominalRate($effect_rate, $npery);
    }

    public function payment($rate, $nper, $pv, $fv = 0, $type = 0) {
        return parent::_payment($rate, $nper, $pv, $fv, $type);
    }

    public function periods($rate, $pmt, $pv, $fv = 0, $type = 0) {
        return parent::_periods($rate, $pmt, $pv, $fv, $type);
    }

    public function presentValue($rate, $nper, $pmt, $fv = 0, $type = 0) {
        return parent::_presentValue($rate, $nper, $pmt, $fv, $type);
    }

    public function priceDiscount($settlement, $maturity, $discount, $redemption, $basis = 0) {
        return parent::_priceDiscount($settlement, $maturity, $discount, $redemption, $basis);
    }

    public function principalPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0) {
        return parent::_principalPayment($rate, $per, $nper, $pv, $fv, $type);
    }

    public function rate($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1) {
        return parent::_rate($nper, $pmt, $pv, $fv, $type, $guess);
    }

    public function tBillEquivalentYield($settlement, $maturity, $discount) {
        return parent::_tBillEquivalentYield($settlement, $maturity, $discount);
    }

    public function tBillPrice($settlement, $maturity, $discount) {
        return parent::_tBillPrice($settlement, $maturity, $discount);
    }

    public function tBillYield($settlement, $maturity, $pr) {
        return parent::_tBillYield($settlement, $maturity, $pr);
    }
}