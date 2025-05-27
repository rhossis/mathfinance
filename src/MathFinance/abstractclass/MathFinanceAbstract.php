<?php
//declare namespace
namespace rhossis\mathfinance\MathFinance\abstractclass;

use \rhossis\mathfinance\MathFinance\abstractclass\FunctionParameters;
use \Pear\Math_Numerical_RootFinding_NewtonRaphson;

/**
 * MathFinanceAbstract: Abstract Class of financial functions
 *
 * Assorted financial functions for interest rates, bonds, amortizations and
 * time value of money calculations (annuities)
 * Same interface as Excel financial functions.
 *
 * PHP versions 5.4+
 *
 * @category   Math
 * @package    MathFinance
 * @author     Original Author <alejandro.pedraza@dataenlace.com>
 * @author     <cogana@gmail.com>
 * @copyright  2025 CYRIL OGANA
 */
abstract class MathFinanceAbstract
{
    /*******************************************************************
    ** Interest Rates Conversion Functions                         *****
    *******************************************************************/
    /**
    * Returns the effective interest rate given the nominal rate and the number of compounding payments per year
    * Excel equivalent: EFFECT
    *
    * @param float      Nominal interest rate
    * @param int        Number of compounding payments per year
    * @return float     
    * @static
    * @access private
    */
    final protected function _effectiveRate($nominal_rate, $npery) {
        $npery = (int)$npery;
        if ($npery < 0) {
            //todo: exception handling class for cymapgt
           return ('Number of compounding payments per year is not positive');
        }

        $effect = pow((1 + $nominal_rate / $npery), $npery) - 1;
        return $effect;
    }

    /**
    * Returns the nominal interest rate given the effective rate and the number of compounding payments per year
    * Excel equivalent: NOMINAL
    *
    * @param float      Effective interest rate
    * @param int        Number of compounding payments per year
    * @return float     
    * @static
    * @access private
    */
    final protected function _nominalRate($effect_rate, $npery){
        $npery = (int)$npery;
        if ($npery < 0) {
            //@TODO: exception class here
            return ('Number of compounding payments per year is not positive');
        }

        $nominal = $npery * (pow($effect_rate + 1, 1/$npery) - 1);
        return $nominal;
    }


    /*******************************************************************
    ** TVM (annuities) Functions                                   *****
    *******************************************************************/

    /**
    * Returns the Present Value of a cash flow with constant payments and interest rate (annuities)
    * Excel equivalent: PV
    *
    *   TVM functions solve for a term in the following formula:
    *   pv(1+r)^n + pmt(1+r.type)((1+r)^n - 1)/r) +fv = 0
    *
    *
    * @param float      Interest rate per period 
    * @param int        Number of periods
    * @param float      Periodic payment (annuity)
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float     
    * @static
    * @access private
    */
    final protected function  _presentValue($rate, $nper, $pmt, $fv = 0, $type = 0){
        if ($nper < 0) {
            return('Number of periods must be positive');
        }
        if ($type != MATHFINANCE_PAYEND
            && $type != MATHFINANCE_PAYBEGIN) {
            //@TODO: exceptions here??
            return('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        if ($rate) {
            $pv = (-$pmt * (1 + $rate * $type) * ((pow(1 + $rate, $nper) - 1) / $rate) - $fv) / pow(1 + $rate, $nper);
        } else {
            $pv = -$fv - $pmt * $nper;
        }
        return $pv;
    }

    /**
    * Returns the Future Value of a cash flow with constant payments and interest rate (annuities)
    * Excel equivalent: FV
    *
    * @param float      Interest rate per period 
    * @param int        Number of periods
    * @param float      Periodic payment (annuity)
    * @param float      Present Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float     
    * @static
    * @access private
    */
    final protected function _futureValue($rate, $nper, $pmt, $pv = 0, $type = 0){
        if ($nper < 0) {
            return ('Number of periods must be positive');
        }
        if ($type != MATHFINANCE_PAYEND
            && $type != MATHFINANCE_PAYBEGIN) {
            return('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        if ($rate) {
            $fv = -$pv * pow(1 + $rate, $nper) - $pmt * (1 + $rate * $type) * (pow(1 + $rate, $nper) - 1) / $rate;
        } else {
            $fv = -$pv - $pmt * $nper;
        }
        return $fv;
    }

    /**
    * Returns the constant payment (annuity) for a cash flow with a constant interest rate
    * Excel equivalent: PMT
    *
    * @param float      Interest rate per period 
    * @param int        Number of periods
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float     
    * @static
    * @access private
    */
    final protected function _payment($rate, $nper, $pv, $fv = 0, $type = 0){
        if ($nper < 0) {
            return ('Number of periods must be positive');
        }
        if ($type != MATHFINANCE_PAYEND
            && $type != MATHFINANCE_PAYBEGIN) {
            return ('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        if ($rate) {
            $pmt = (-$fv - $pv * pow(1 + $rate, $nper)) / (1 + $rate * $type) / ((pow(1 + $rate, $nper) - 1) / $rate);
        } else {
            $pmt = (-$pv - $fv) / $nper;
        }
        return $pmt;
    }

    /**
    * Returns the number of periods for a cash flow with constant periodic payments (annuities), and interest rate
    * Excel equivalent: NPER
    *
    * @param float      Interest rate per period 
    * @param float      Periodic payment (annuity)
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float
    * @static
    * @access private
    */
    final protected function _periods($rate, $pmt, $pv, $fv = 0, $type = 0) {
        if ($type != MATHFINANCE_PAYEND 
            && $type != MATHFINANCE_PAYBEGIN) {
            return ('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        if ($rate) {
            if ($pmt == 0 && $pv == 0) {
                die('Payment and Present Value can\'t be both zero when the rate is not zero');
            }
            $nper = log(($pmt * (1 + $rate * $type) / $rate - $fv) / ($pv + $pmt * (1 + $rate * $type) / $rate))
                     / log(1 + $rate);
        } else {
            if ($pmt == 0) {
                die('Rate and Payment can\'t be both zero');
            }
            $nper = (-$pv -$fv) / $pmt;
        }
        return $nper;
    }

    /**
    * Returns the periodic interest rate for a cash flow with constant periodic payments (annuities)
    * Excel equivalent: RATE
    *
    * @param int        Number of periods
    * @param float      Periodic payment (annuity)
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @param float      guess for the interest rate
    * @return float     
    * @static
    * @access public
    */
    final protected function _rate($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1) {
        // To solve the equation
        //require_once "Math/Numerical/RootFinding/NewtonRaphson.php";
        // To preserve some variables in the Newton-Raphson callback functions
        //require_once 'Pear/Math/Finance_FunctionParameters.php';

        if ($type != MATHFINANCE_PAYBEGIN 
            && $type != MATHFINANCE_PAYEND) {
            return('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }
        
        // Utilization of a Singleton class to preserve given values of other variables in the callback functions
        $parameters = array(
            'nper'  => $nper,
            'pmt'   => $pmt,
            'pv'    => $pv,
            'fv'    => $fv,
            'type'  => $type,
        );
        
        //$parameters_init  = new ;

        $parameters_class = FunctionParameters::getInstance($parameters, True);
        //die(print_r($parameters_class::$parameters));
        
        $newtonRaphson = new Math_Numerical_RootFinding_NewtonRaphson(array('err_tolerance' => MATHFINANCE_PRECISION));

        return $newtonRaphson->compute(array('\rhossis\mathfinance\MathFinance\abstractclass\MathFinanceAbstract', '_tvm'), array('\rhossis\mathfinance\MathFinance\abstractclass\MathFinanceAbstract', '_dtvm'), $guess);
    }

    /**
    * Callback function only used by Newton-Raphson algorithm. Returns value of function to be solved.
    *
    * Uses a previously instanced Singleton class to retrieve given values of other variables in the function
    *
    * @param float      Interest rate
    * @return float     
    * @static
    * @access private
    */
    function _tvm($rate)
    {
        //require_once 'Math/Finance_FunctionParameters.php';

	$parameters_class = FunctionParameters::getInstance();
        $nper   = $parameters_class::$parameters['nper'];
        $pmt    = $parameters_class::$parameters['pmt'];
        $pv     = $parameters_class::$parameters['pv'];
        $fv     = $parameters_class::$parameters['fv'];
        $type   = $parameters_class::$parameters['type'];

        return $pv * pow(1 + $rate, $nper) + $pmt * (1 + $rate * $type) * (pow(1 + $rate, $nper) - 1) / $rate + $fv;
    }

    /**
    * Callback function only used by Newton-Raphson algorithm. Returns value of derivative of function to be solved.
    *
    * Uses a previously instanced Singleton class to retrieve given values of other variables in the function
    *
    * @return float     
    * @static
    * @access private
    */
    function _dtvm($rate)
    {
       // require_once 'Math/Finance_FunctionParameters.php';

	$parameters_class = FunctionParameters::getInstance();
        $nper   = $parameters_class::$parameters['nper'];
        $pmt    = $parameters_class::$parameters['pmt'];
        $pv     = $parameters_class::$parameters['pv'];
        $type   = $parameters_class::$parameters['type'];

        return $nper * $pv * pow(1 + $rate, $nper - 1)
                 + $pmt *
                     ($type * (pow(1 + $rate, $nper) - 1) / $rate
                     + (1 + $rate * $type) * ($nper * $rate * pow(1 + $rate, $nper - 1) - pow(1 + $rate, $nper) + 1) / pow($rate,2));
    }

    /**
    * Returns the interest payment for a given period for a cash flow with constant periodic payments (annuities)
    * and interest rate.
    * Excel equivalent: IMPT
    *
    * @param float      Interest rate per period 
    * @param int        Period for which the interest payment will be calculated
    * @param int        Number of periods
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float     
    * @static
    * @access public
    */
    final protected function _interestPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0)
    {
        if ($type != MATHFINANCE_PAYEND 
            && $type != MATHFINANCE_PAYBEGIN) {
            return ('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        $interestAndPrincipal = $this->_interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type);
        return $interestAndPrincipal[0];
    }

    /**
    * Returns the principal payment for a given period for a cash flow with constant periodic payments (annuities)
    * and interest rate
    * Excel equivalent: PPMT
    *
    * @param float      Interest rate per period 
    * @param int        Period for which the principal payment will be calculated
    * @param int        Number of periods
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return float     
    * @static
    * @access public
    */
    final protected function _principalPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0)
    {
        if ($type != MATHFINANCE_PAYEND
           && $type != MATHFINANCE_PAYBEGIN) {
            return('Payment type must be FINANCE_PAY_END or FINANCE_PAY_BEGIN');
        }

        $interestAndPrincipal = $this->_interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type);
        return $interestAndPrincipal[1];
    }

    /**
    * Returns the interest and principal payment for a given period for a cash flow with constant 
    * periodic payments (annuities) and interest rate
    *
    * @param float      Interest rate per period 
    * @param int        Number of periods
    * @param float      Present Value
    * @param float      Future Value
    * @param int        Payment type:
                            FINANCE_PAY_END (default):    at the end of each period
                            FINANCE_PAY_BEGIN:            at the beginning of each period
    * @return array
    * @static
    * @access private
    */
    final protected function _interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type)
    {
        $pmt = $this->payment($rate, $nper, $pv, $fv, $type);
        //echo "pmt: $pmt\n\n";
        $capital = $pv;
        for ($i = 1; $i<= $per; $i++) {
            // in first period of advanced payments no interests are paid
            $interest = ($type && $i == 1)? 0 : -$capital * $rate;
            $principal = $pmt - $interest;
            $capital += $principal;
            //echo "$i\t$capital\t$interest\t$principal\n";
        }
        return array($interest, $principal);
    }

    /*******************************************************************
    ** Cash Flow Functions                                        *****
    *******************************************************************/

    /**
    * Returns the Net Present Value of a cash flow series given a discount rate
    * Excel equivalent: NPV
    *
    * @param float      Discount interest rate
    * @param array      Cash flow series
    * @return float     
    * @static
    * @access public
    */

    final protected function _netPresentValue($rate, $values)
    {
        if (!is_array($values)) {
            return('The cash flow series most be an array');
        }
    
        return $this->_npv($rate, $values);
    }

    /**
    * Returns the internal rate of return of a cash flow series
    * Excel equivalent: IRR
    *
    * @param array      Cash flow series
    * @param float      guess for the interest rate
    * @return float     
    * @static
    * @access public
    */
    final protected function _internalRateOfReturn($values, $guess = 0.1)
    {
        // To solve the equation
        // require_once 'Math/Numerical/RootFinding/NewtonRaphson.php';
        // To preserve some variables in the Newton-Raphson callback functions
        //require_once 'Math/Finance_FunctionParameters.php';

        if (!is_array($values)) {
            return('The cash flow series must be an array');
        }
        if (min($values) * max($values) >= 0) {
            return('Cash flow must contain at least one positive value and one negative value');
        }

        $parameters_class = FunctionParameters::getInstance(array('values' => $values), True);
        $newtonRaphson = new Math_Numerical_RootFinding_Newtonraphson(array('err_tolerance' => MATHFINANCE_PRECISION));
        return $newtonRaphson->compute(array('Math_Finance', '_npv'), array('Math_Finance', '_dnpv'), $guess);
    }

    /**
    * Function used by NPV() and as a callback by Newton-Raphson algorithm.
    * Returns value of Net Present Value of a cash flow series.
    *
    * Uses a previously instanced Singleton class to retrieve given values of other variables in the function
    *
    * @param float      Discount interest rate
    * @param array      Cash flow series
    * @return float     
    * @static
    * @access private
    */
    function _npv($rate, $values = array())
    {
        //require_once 'Math/Finance_FunctionParameters.php';
        if (!$values) {
            // called from IRR
		    $parameters_class = FunctionParameters::getInstance();
            $values = $parameters_class->parameters['values'];
        }

        $npv = 0;
        $nper = count($values);
        for ($i = 1; $i <= $nper; $i++) {
            $npv += $values[$i-1]/ pow(1 + $rate, $i);
        }
        return $npv;
    }

    /**
    * Callback function used by by Newton-Raphson algorithm to calculate IRR.
    * Returns value of derivative function to be solved.
    *
    * Uses a previously instanced Singleton class to retrieve given values of other variables in the function
    *
    * @param float      Discount interest rate
    * @param array      Cash flow series
    * @return float     
    * @static
    * @access private
    */
    function _dnpv($rate, $values = array())
    {
        require_once 'Math/Finance_FunctionParameters.php';

        if (!$values) {
            // called from IRR
		    $parameters_class = FunctionParameters::getInstance();
            $values = $parameters_class->parameters['values'];
        }

        $dnpv = 0;
        $nper = count($values);
        for ($i = 1; $i <= $nper; $i++) {
            $dnpv += $values[$i-1] * (-$i) * pow(1 + $rate, $i - 1) / pow(1 + $rate, 2 * $i);
        }
        return $dnpv;
    }

    /**
    * Returns the internal rate of return of a cash flow series, considering both financial and reinvestment rates
    * Excel equivalent: MIRR
    *
    * @param array      Cash flow series
    * @param float      Interest rate on the money used in the cash flow
    * @param float      Interest rate received when reinvested
    * @return float     
    * @static
    * @access private
    */
    final protected  function _modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate)
    {
        if (!is_array($values)) {
           return('The cash flow series most be an array');
        }
        if (min($values) * max($values) >= 0) {
            return('Cash flow must contain at least one positive value and one negative value');
        }

        $positive_flows = $negative_flows = array();
        foreach ($values as $value) {
            if ($value >= 0) {
                $positive_flows[] = $value;
                $negative_flows[] = 0;
            } else {
                $positive_flows[] = 0;
                $negative_flows[] = $value;
            }
        }

        $nper = count($values);

        return pow(-Math_Finance::netPresentValue($reinvest_rate, $positive_flows) * pow(1 + $reinvest_rate, $nper)
                / Math_Finance::netPresentValue($finance_rate, $negative_flows) / (1 + $finance_rate), 1/($nper - 1)) - 1;
    }

    /*******************************************************************
    ** Bonds Functions                                             *****
    *******************************************************************/

    /**
    * Returns the difference of days between two dates based on a daycount basis
    *
    * @param int        First date (UNIX timestamp)
    * @param int        Second date (UNIX timestamp)
    * @param int        Type of day count basis:
                            FINANCE_COUNT_NASD(default):    US(NASD) 30/360
                            FINANCE_COUNT_ACTUAL_ACTUAL:    Actual/actual
                            FINANCE_COUNT_ACTUAL_360:       Actual/360
                            FINANCE_COUNT_ACTUAL_365:       Actual/365
                            FINANCE_COUNT_EUROPEAN:         European 30/360
    * @return int
    * @static
    * @access public
    */
    final protected function _daysDifference($date1, $date2, $basis)
    {
        $y1 = date('Y', strtotime($date1));
        $m1 = date('n', strtotime($date1));
        $d1 = date('j', strtotime($date1));
        $y2 = date('Y', strtotime($date2));
        $m2 = date('n', strtotime($date2));
        $d2 = date('j', strtotime($date2));
        
        switch ($basis) {
            case MATHFINANCE_COUNTNASD:
                if ($d2 == 31 && ($d1 == 30 || $d1 == 31)) {
                    $d2 = 30;
                }
                if ($d1 == 31) {
                    $d1 = 30;
                }
                return ($y2 - $y1) * 360 + ($m2 - $m1) * 30 + $d2 - $d1;
            case MATHFINANCE_COUNTACTUALACTUAL:
                return (strtotime($date2) - strtotime($date1)) / 86400;   
            case MATHFINANCE_COUNTACTUAL360:
                return (strtotime($date2) - strtotime($date1)) / 86400;                
            case MATHFINANCE_COUNTACTUAL365:
                return (strtotime($date2) - strtotime($date1)) / 86400;
            case MATHFINANCE_COUNTEUROPEAN: // European 30/360
                return ($y2 - $y1) * 360 + ($m2 - $m1) * 30 + $d2 - $d1;
        }
    }

    /**
    * Returns the number of days in the year based on a daycount basis
    *
    * @param int        Year
    * @param int        Type of day count basis:
                            FINANCE_COUNT_NASD(default):    US(NASD) 30/360
                            FINANCE_COUNT_ACTUAL_ACTUAL:    Actual/actual
                            FINANCE_COUNT_ACTUAL_360:       Actual/360
                            FINANCE_COUNT_ACTUAL_365:       Actual/365
                            FINANCE_COUNT_EUROPEAN:         European 30/360
    * @return int
    * @static
    * @access public
    */
    final protected function _daysPerYear($year, $basis)
    {
        switch ($basis) {
            case \MATHFINANCE_COUNTNASD:
                return 360;
            case \MATHFINANCE_COUNTACTUALACTUAL:
                return checkdate(2, 29, $year)? 366 : 365;
            case \MATHFINANCE_COUNTACTUAL360:
                return 360;
            case \MATHFINANCE_COUNTACTUAL365:
                return 365;
            case \MATHFINANCE_COUNTEUROPEAN:
                return 360;
        }
    }

    /**
    * Returns the yield for a treasury bill
    * Excel equivalent: TBILLYIELD
    *
    * @param int        Settlement date (UNIX timestamp)
    * @param int        Maturity date (UNIX timestamp)
    * @param float      TBill price per $100 face value
    * @return float     
    * @st atic
    * @access public
    */
    final protected function _tBillYield($settlement, $maturity, $pr)
    {
        if (strtotime($settlement) >= strtotime($maturity)) {
            return('Maturity must happen before settlement!');
        }

        $dsm = (strtotime($maturity) - strtotime($settlement)) / 86400;   // transform to days

        if ($dsm > 364) {
            return("maturity can't be more than one year after settlement");
        }

        return (100 - $pr) * 364 / $pr / $dsm;
    }

    /**
    * Returns the price per $100 face value for a Treasury bill
    * Excel equivalent: TBILLPRICE
    *
    * @param int        Settlement date (UNIX timestamp)
    * @param int        Maturity date (UNIX timestamp)
    * @param float      T-Bill discount rate
    * @return float     
    * @static
    * @access public
    */
   final protected function _tBillPrice($settlement, $maturity, $discount)
    {
        if (strtotime($settlement) >= strtotime($maturity)) {
            return('Maturity must happen before settlement!');
        }

        $dsm = (strtotime($maturity) - strtotime($settlement)) / 86400;   // transform to days

        if ($dsm > 364) {
            return("maturity can't be more than one year after settlement");
        }

        return 100 * (1 - $discount * $dsm / 364);
    }

    /**
    * Returns the bond-equivalent yield for a Treasury bill
    * Excel equivalent: TBILLEQ
    *
    * @param int        Settlement date (UNIX timestamp)
    * @param int        Maturity date (UNIX timestamp)
    * @param float      T-Bill discount rate
    * @return float     
    * @static
    * @access public
    */
    final protected function _tBillEquivalentYield($settlement, $maturity, $discount)
    {
        if (strtotime($settlement) >= strtotime($maturity)) {
            return('Maturity must happen before settlement!');
        }

        $dsm = $this->_daysDifference($settlement, $maturity, MATHFINANCE_COUNTACTUAL365);

        if ($dsm <= 182) {
            // for one half year or less, the bond-equivalent-yield is equivalent to an actual/365 interest rate
            return 365 * $discount / (360 - $discount * $dsm);
        } elseif ($dsm == 366 
                  && ((date('m', strtotime($settlement)) <= 2 && checkdate(2, 29, date('Y', strtotime($settlement)))) 
                  || (date('m', strtotime($settlement)) > 2 && checkdate(2, 29, date('Y', strtotime($maturity)))))) {
            return 2 * (sqrt(1 - $discount * 366 / ($discount * 366 - 360)) - 1);
        } elseif ($dsm > 365) {
            return("maturity can't be more than one year after settlement");
        } else {
            // thanks to Zhang Qingpo (zhangqingpo@yahoo.com.cn) for solving this riddle :)
            return (-$dsm + sqrt(pow($dsm, 2) - (2 * $dsm - 365) * $discount * $dsm * 365 / ($discount * $dsm - 360))) / ($dsm - 365 / 2);
        }
    }

    /**
    * Returns the discount rate for a bond
    * Excel equivalent: DISC
    *
    * @param int        Settlement date (UNIX timestamp)
    * @param int        Maturity date (UNIX timestamp)
    * @param float      The bond's price per $100 face value
    * @param float      The bond's redemption value per $100 face value
    * @param int        Type of day count basis:
                            FINANCE_COUNT_NASD(default):    US(NASD) 30/360
                            FINANCE_COUNT_ACTUAL_ACTUAL:    Actual/actual
                            FINANCE_COUNT_ACTUAL_360:       Actual/360
                            FINANCE_COUNT_ACTUAL_365:       Actual/365
                            FINANCE_COUNT_EUROPEAN:         European 30/360
    * @return float     
    * @static
    * @access public
    */
    final protected function _discountRate($settlement, $maturity, $pr, $redemption, $basis = 0)
    {
        $days_per_year = $this->_daysPerYear(date('Y', $settlement), $basis);
        $dsm = $this->_daysDifference($settlement, $maturity, $basis);
        return ($redemption - $pr) * $days_per_year / $redemption / $dsm;
    }

    /**
    * Returns the price per $100 face value of a discounted bond
    * Excel equivalent: PRICEDISC
    *
    * @param int        Settlement date (UNIX timestamp)
    * @param int        Maturity date (UNIX timestamp)
    * @param float      The bond's discount rate
    * @param float      The bond's redemption value per $100 face value
    * @param int        Type of day count basis:
                            FINANCE_COUNT_NASD(default):    US(NASD) 30/360
                            FINANCE_COUNT_ACTUAL_ACTUAL:    Actual/actual
                            FINANCE_COUNT_ACTUAL_360:       Actual/360
                            FINANCE_COUNT_ACTUAL_365:       Actual/365
                            FINANCE_COUNT_EUROPEAN:         European 30/360
    * @return float     
    * @static
    * @access public
    */
    final protected function _priceDiscount($settlement, $maturity, $discount, $redemption, $basis = 0)
    {
        $days_per_year = $this->_daysPerYear(date('Y', strtotime($settlement)), $basis);
        $dsm = $this->_daysDifference($settlement, $maturity, $basis);

        return $redemption - $discount * $redemption * $dsm / $days_per_year;
    }


    /*******************************************************************
    ** Depreciation Functions                                      *****
    *******************************************************************/

    /**
    * Returns the depreciation of an asset using the fixed-declining balance method
    * Excel equivalent: DB
    *
    * @param float      The initial cost of the asset
    * @param float      Salvage value of the asset
    * @param int        Number of depreciation periods (same unit as $life)
    * @param int        Number of months in the first year, defaults to 12
    * @return float     
    * @static
    * @access public
    */
    final protected function _depreciationFixedDeclining($cost, $salvage, $life, $period, $month = 12)
    {
        $cost       = (float) $cost;
        $salvage    = (float) $salvage;
        $life       = (int)   $life;
        $period     = (int)   $period;
        $month      = (int)   $month;
        if ($cost < 0 || $life < 0) {
            return('cost and life must be absolute positive numbers');
        }
        if ($period < 1) {
            return('period must be greater or equal than one');
        }

        $rate = 1 - pow(($salvage / $cost), (1 / $life));
        $rate = round($rate, 3);

        $acc_depreciation = 0;
        for ($i = 1; $i <= $period; $i++) {
            if ($i == 1) {
                $depreciation_period = $cost * $rate * $month / 12;
            } elseif ($i == ($life + 1)) {
                $depreciation_period = ($cost - $acc_depreciation) * $rate * (12 - $month) / 12;
            } else {
                $depreciation_period = ($cost - $acc_depreciation) * $rate;
            }
            $acc_depreciation += $depreciation_period;
        }

        return $depreciation_period;
    }

    /**
    * Returns the straight-line depreciation of an asset for each period
    * Excel equivalent: SLN
    *
    * @param float      The initial cost of the asset
    * @param float      Salvage value of the asset
    * @param int        Number of depreciation periods
    * @return float     
    * @static
    * @access public
    */
    final protected function _depreciationStraightLine($cost, $salvage, $life)
    {
        $life       = (int) $life;
        if ($cost < 0 || $life < 0) {
            return

            ('cost and life must be absolute positive numbers');
        }

        return (($cost - $salvage) / $life);
    }

    /**
    * Returns the depreciation for an asset in a given period using the sum-of-years' digits method
    * Excel equivalent: SYD
    *
    * @param float      The initial cost of the asset
    * @param float      Salvage value of the asset
    * @param int        Number of depreciation periods
    * @param int        Period (must be in the same unit as $life)
    * @return float     
    * @static
    * @access public
    */
    final protected function _depreciationSYD($cost, $salvage, $life, $per)
    {
        return (($cost - $salvage) * ($life - $per + 1) * 2 / ($life) / ($life +1));
    }
    
    /*The methods below must be implemented by any class extending the MathFinanceAbstract class
      These classes must call the MathFinance protected classes to achieve desired function.
      These are necessitated by the fact that the methods are final because we do not want them
      to be overriden, and are also protected
      Setters must be called from within the object
      *******************************************************************************************/
    abstract public function effectiveRate($nominal_rate, $npery);
    abstract public function nominalRate($effect_rate, $npery);
    abstract public function presentValue($rate, $nper, $pmt, $fv = 0, $type = 0);
    abstract public function futureValue($rate, $nper, $pmt, $pv = 0, $type = 0);
    abstract public function payment($rate, $nper, $pv, $fv = 0, $type = 0);
    abstract public function periods($rate, $pmt, $pv, $fv = 0, $type = 0);
    abstract public function rate($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1);
    abstract public function interestPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
    abstract public function principalPayment($rate, $per, $nper, $pv, $fv = 0, $type = 0);
    abstract public function interestAndPrincipal($rate, $per, $nper, $pv, $fv, $type);
    abstract public function netPresentValue($rate, $values);
    abstract public function internalRateOfReturn($values, $guess = 0.1);
    abstract public function modifiedInternalRateOfReturn($values, $finance_rate, $reinvest_rate);
    abstract public function daysDifference($date1, $date2, $basis);
    abstract public function daysPerYear($year, $basis);
    abstract public function tBillYield($settlement, $maturity, $pr);
    abstract public function tBillPrice($settlement, $maturity, $discount);
    abstract public function tBillEquivalentYield($settlement, $maturity, $discount);
    abstract public function discountRate($settlement, $maturity, $pr, $redemption, $basis = 0);
    abstract public function priceDiscount($settlement, $maturity, $discount, $redemption, $basis = 0);
    abstract public function depreciationFixedDeclining($cost, $salvage, $life, $period, $month = 12);
    abstract public function depreciationStraightLine($cost, $salvage, $life);
}