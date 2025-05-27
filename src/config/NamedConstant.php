<?php
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
