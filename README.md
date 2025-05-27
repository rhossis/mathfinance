# 🧮 math
Package for financial math functions

## 📘 Description

This package contains assorted methods for fixed income instrument calculations, enabling developers to perform accurate and reliable financial math operations such as interest calculations, depreciation, bond valuation, and more.

---

## 💾 Installing

### 📦 Install application via Composer

```bash
require "rhossis/mathfinance" : "^4.0.0"
```

---

## 🚀 Usage

### 📖 Overview

The math class provides several financial math functions. These methods largely mirror Microsoft Excel functions and extend the legacy PEAR math classes. The package also comes with a bond interest calculation class, which is compliant
with interest calculations used in various exchanges worldwide, such as Central Bank of Kenyas 364 days calculation.

---

### 🧱 Named Constants

```php
// Precision level
define('MATHFINANCE_PRECISION', 1E-6);

// Payment types
define('MATHFINANCE_PAYEND', 0);
define('MATHFINANCE_PAYBEGIN', 1);

// Day count methods
define('MATHFINANCE_COUNTNASD', 0);
define('MATHFINANCE_COUNTACTUALACTUAL', 1);
define('MATHFINANCE_COUNTACTUAL360', 2);
define('MATHFINANCE_COUNTACTUAL365', 3);
define('MATHFINANCE_COUNTEUROPEAN', 4);

// Extended day count methods
define('MATHFINANCE_COUNTNEW_GERMAN', 1);
define('MATHFINANCE_COUNTNEW_GERMANSPEC', 2);
define('MATHFINANCE_COUNTNEW_ENGLISH', 3);
define('MATHFINANCE_COUNTNEW_FRENCH', 4);
define('MATHFINANCE_COUNTNEW_US', 5);
define('MATHFINANCE_COUNTNEW_ISMAYEAR', 6);
define('MATHFINANCE_COUNTNEW_ISMA99N', 7);
define('MATHFINANCE_COUNTNEW_ISMA99U', 8);

// Error flags
define('MATHFINANCE_ERROR_BADDCM', 1);
define('MATHFINANCE_ERROR_BADDATES', 2);

// Accrued interest calculation constants
define('MATHFINANCE_SWX_BOND_AI_GERMAN', 1);
define('MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN', 2);
define('MATHFINANCE_SWX_BOND_AI_ENGLISH', 3);
define('MATHFINANCE_SWX_BOND_AI_FRENCH', 4);
define('MATHFINANCE_SWX_BOND_AI_US', 5);
define('MATHFINANCE_SWX_BOND_AI_ISMA_YEAR', 6);
define('MATHFINANCE_SWX_BOND_AI_ISMA_99N', 7);
define('MATHFINANCE_SWX_BOND_AI_ISMA_99U', 8);
define('MATHFINANCE_SWX_BOND_AI_KENYA', 9);
define('MATHFINANCE_SWX_BOND_AI_CBK_KENYA', 10);
```

---

### 🧮 Using the Math Package

#### 🔁 Calculating Accrued Interest on Bonds

```php
use rhossis\mathfinance\MathFinance\abstractclass\Swx\BondAccruedInterest;

$d1M1Y1 = '2013-12-31';
$d2M2Y2 = '2014-06-30';
$d3M3Y3 = '2014-12-31';
$fValue = 1;
$maturityDate = '2014-12-31';

$bondObj = new BondAccruedInterest();
$dCM = MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN;

$interestFactor = $bondObj->accruedInterestFactor($dCM, $d1M1Y1, $d2M2Y2, $d3M3Y3, $fValue, $maturityDate);
```

---

### 📈 Bond Interest Calculation Guide

> A detailed guide to the formulas and logic for computing bond interest for fixed income instruments including actual/actual, 30/360, and RFR-based methods.

[📘 View Full Guide](BOND_INTEREST_CALCULATION_GUIDE.md)

---

### 🔢 Computing Financial Math

```php
$mfo = new rhossis\mathfinance\MathFinance();
$mfo->effectiveRate($nominal_rate, $npery);
$mfo->nominalRate($effect_rate, $npery);
$mfo->presentValue($rate, $nper, $pmt, $fv = 0, $type = 0);
$mfo->futureValue($rate, $nper, $pmt, $pv = 0, $type = 0);
$mfo->payment($rate, $nper, $pv, $fv = 0, $type = 0);
$mfo->periods($rate, $pmt, $pv, $fv = 0, $type = 0);
$mfo->rate($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1);
$mfo->interestPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
$mfo->principalPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
$mfo->interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type);
$mfo->netPresentValue($rate, $values);
$mfo->internalRateOfReturn($values, $guess = 0.1);
$mfo->modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate);
$mfo->daysDifference($date1, $date2, $basis);
$mfo->daysPerYear($year, $basis);
$mfo->tBillYield($settlement, $maturity, $pr);
$mfo->tBillPrice($settlement, $maturity, $discount);
$mfo->tBillEquivalentYield($settlement, $maturity, $discount);
$mfo->discountRate($settlement, $maturity, $pr, $redemption, $basis = 0);
$mfo->priceDiscount($settlement, $maturity, $discount, $redemption, $basis = 0);
$mfo->depreciationFixedDeclining($cost, $salvage, $life, $period, $month = 12);
$mfo->depreciationStraightLine($cost, $salvage, $life);
```

---

### 🧪 Testing

Unit tests are provided using PHPUnit.

---

### 🤝 Contribute

- Fork the project :)
- Email [@rhossis].
- Contributors will be credited in the project.

---

### ⚖️ License

**BSD-3-Clause**
