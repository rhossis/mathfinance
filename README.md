# math
Package for financial math functions

## Description

This package contains assorted methods for Fixed income instrument calculations

## Installing

### Install application via Composer

    require "rhossis/mathfinance" : "^4.0.0"

## Usage

### Overview

The math class contains several Financial math calculations. The methods
inherited from the Pear math class implement the same interface as Microsoft
Excel functions

### Named Constants

    //precision of math calculations
    if (!(defined('MATHFINANCE_PRECISION'))) {
        define('MATHFINANCE_PRECISION', 1E-6);
    }

    //payment types
    if (!(defined('MATHFINANCE_PAYEND'))) {
        define('MATHFINANCE_PAYEND', 0);
    }

    if (!(defined('MATHFINANCE_PAYBEGIN'))) {
        define('MATHFINANCE_PAYBEGIN', 1);
    }

    //day count methods
    if (!(defined('MATHFINANCE_COUNTNASD'))) {
        define('MATHFINANCE_COUNTNASD', 0);
    }

    if (!(defined('MATHFINANCE_COUNTACTUALACTUAL'))) {
        define('MATHFINANCE_COUNTACTUALACTUAL', 1);
    }

    if (!(defined('MATHFINANCE_COUNTACTUAL360'))) {
        define('MATHFINANCE_COUNTACTUAL360', 2);
    }

    if (!(defined('MATHFINANCE_COUNTACTUAL365'))) {
        define('MATHFINANCE_COUNTACTUAL365', 3);
    }

    if (!(defined('MATHFINANCE_COUNTEUROPEAN'))) {
        define('MATHFINANCE_COUNTEUROPEAN', 4);
    }

    //new series with more options
    if (!(defined('MATHFINANCE_COUNTNEW_GERMAN'))) {
        define('MATHFINANCE_COUNTNEW_GERMAN', 1);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_GERMANSPEC'))) {
        define('MATHFINANCE_COUNTNEW_GERMANSPEC', 2);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_ENGLISH'))) {
        define('MATHFINANCE_COUNTNEW_ENGLISH', 3);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_FRENCH'))) {
        define('MATHFINANCE_COUNTNEW_FRENCH', 4);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_US'))) {
        define('MATHFINANCE_COUNTNEW_US', 5);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_ISMAYEAR'))) {
        define('MATHFINANCE_COUNTNEW_ISMAYEAR', 6);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_ISMA99N'))) {
        define('MATHFINANCE_COUNTNEW_ISMA99N', 7);
    }

    if (!(defined('MATHFINANCE_COUNTNEW_ISMA99U'))) {
        define('MATHFINANCE_COUNTNEW_ISMA99U', 8);
    }

    //day count method error flags
    if (!(defined('MATHFINANCE_ERROR_BADDCM'))) {
        define('MATHFINANCE_ERROR_BADDCM', 1);
    }

    if (!(defined('MATHFINANCE_ERROR_BADDATES'))) {
        define('MATHFINANCE_ERROR_BADDATES', 2);
    }

    //Math Finance. Accrued interest constants
    if (!(defined('MATHFINANCE_SWX_BOND_AI_GERMAN'))) {
        define('MATHFINANCE_SWX_BOND_AI_GERMAN', 1);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN'))) {
        define('MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN', 2);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_ENGLISH'))) {
        define('MATHFINANCE_SWX_BOND_AI_ENGLISH', 3);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_FRENCH'))) {
        define('MATHFINANCE_SWX_BOND_AI_FRENCH', 4);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_US'))) {
        define('MATHFINANCE_SWX_BOND_AI_US', 5);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_ISMA_YEAR'))) {
        define('MATHFINANCE_SWX_BOND_AI_ISMA_YEAR', 6);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_ISMA_99N'))) {
        define('MATHFINANCE_SWX_BOND_AI_ISMA_99N', 7);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_ISMA_99U'))) {
        define('MATHFINANCE_SWX_BOND_AI_ISMA_99U', 8);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_KENYA'))) {
        define('MATHFINANCE_SWX_BOND_AI_KENYA', 9);
    }

    if (!(defined('MATHFINANCE_SWX_BOND_AI_CBK_KENYA'))) {
        define('MATHFINANCE_SWX_BOND_AI_CBK_KENYA', 10);
    }


### Using the Math package

#### Calculating Accrued Interest on Bonds
    use rhossis\mathfinance\MathFinance\abstractclass\Swx\BondAccruedInterest;

    //Bond coupon data
    $d1M1Y1 = '2013-12-31';
    $d2M2Y2 = '2014-06-30';
    $d3M3Y3 = '2014-12-31';
    $fValue = 1;
    $maturityDate = '2014-12-31';

    $bondObj = new BondAccruedInterest();

    $dCM = \MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN; //day count method
    $interestFactor = $bondObj->accruedInterestFactor($dCM, $d1M1Y1, $d2M2Y2, $d3M3Y3, $fValue, $maturityDate);

### Computing Financial Math
    use rhossis\mathfinance\MathFinance\MathFinance.php;

    effectiveRate($nominal_rate, $npery);
    
    nominalRate($effect_rate, $npery);
    
    presentValue($rate, $nper, $pmt, $fv = 0, $type = 0);
    
    futureValue($rate, $nper, $pmt, $pv = 0, $type = 0);
    
    payment($rate, $nper, $pv, $fv = 0, $type = 0);
    
    periods($rate, $pmt, $pv, $fv = 0, $type = 0);
    
    rate($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1);
    
    interestPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
    
    principalPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
    
    interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type);
    
    netPresentValue($rate, $values);
    
    internalRateOfReturn($values, $guess = 0.1);
    
    modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate);
    
    daysDifference($date1, $date2, $basis);
    
    daysPerYear($year, $basis);
    
    tBillYield($settlement, $maturity, $pr);
    
    tBillPrice($settlement, $maturity, $discount);
    
    tBillEquivalentYield($settlement, $maturity, $discount);
    
    discountRate($settlement, $maturity, $pr, $redemption, $basis = 0);
    
    priceDiscount($settlement, $maturity, $discount, $redemption, $basis = 0);
    
    depreciationFixedDeclining($cost, $salvage, $life, $period, $month = 12);
    
    depreciationStraightLine($cost, $salvage, $life);

### Testing

PHPUnit Tests are provided with the package

### Contribute

* Email @rhossis or contact via Skype
* You will be added as author for contributions

### License

PROPRIETARY
