<?php
namespace rhossis\mathfinance\MathFinance\abstractclass\Pear;

/**

 * Driver file contains Math_Numerical_RootFinding_Bisection class to provide

 * Newton-Raphson method root finding calculation.

 *

 * PHP versions 4 and 5

 *

 * LICENSE:

 * Copyright (c) 2008 Firman Wandayandi <firman@php.net>

 *

 * This source file is subject to the BSD License license that is bundled

 * with this package in the file LICENSE.txt.

 * It is also available through the world-wide-web at this URL:

 * http://www.opensource.org/licenses/bsd-license.php

 * If you did not receive a copy of the license and are unable to

 * obtain it through the world-wide-web, please send an email

 * to pear-dev@list.php.net so we can send you a copy immediately.

 *

 * @category   Math

 * @package    Math_Numerical_RootFinding

 * @subpackage Methods

 * @author     Firman Wandayandi <firman@php.net>

 * @copyright  2004-2008 Firman Wandayandi

 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License

 * @link       http://pear.php.net/package/Math_Numerical_RootFinding

 * @version    CVS: $Id: NewtonRaphson.php 272241 2008-12-29 16:32:46Z firman $

 */

 

/**

 * Math_Numerical_RootFinding_Common

 */

//require_once("Common.php");


/**

 * Newton-Raphson method class.

 *

 * @category   Math

 * @package    Math_Numerical_RootFinding

 * @subpackage Methods

 * @author     Firman Wandayandi <firman@php.net>

 * @copyright  2004-2008 Firman Wandayandi

 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License

 * @link       http://pear.php.net/package/Math_Numerical_RootFinding

 * @version    Release: @package_version@

 */

class Math_Numerical_RootFinding_NewtonRaphson

extends Math_Numerical_RootFinding_Common

{

    // {{{ Constructor

 

    /**

     * Constructor.

     *

     * @param array $options (optional) Options.

     *

     * @access public

     * @see $this->Math_Numerical_RootFinding_Common()

     */

    function __construct($options = null)

    {

        parent::__construct($options);

    }

 

    // }}}

    // {{{ infoCompute()

 

    /**

     * Print out parameters description for compute() function.

     *

     * @access public

     * @return void 

     */

    function infoCompute()

    {

        print "<h2>False Position::compute()</h2>\n" .

 

              "<em>float</em> | <em>PEAR_Error</em> " .

              "<strong>compute</strong>(<u>\$fxFunction</u>, " .

 

              "<u>\$dfxFunction</u>, <u>\$xR</u>)<br />\n" .

 

              "<h3>Description</h3>\n" .

 

              "<em>callback</em> <u>\$fxFunction</u> Callback f(x) equation " .

              "function or object/method tuple.<br>\n" .

 

              "<em>callback</em> <u>\$dfxFunction</u> Callback f'(x) equation " .

              "function or object/method tuple.<br>\n" .

 

              "<em>float</em> <u>\$xR</u> Initial guess.<br>\n";

    }

 

    // }}}

    // {{{ compute()

 

    /**

     * Netwon-Raphson method.

     *

     * @param callback $fxFunction  Callback f(x) equation function or object/method

     *                               tuple.

     * @param callback $dfxFunction Callback f'(x) equation function or object/method

     *                               tuple.

     * @param float    $xR          Initial guess.

     *

     * @return float|PEAR_ErrorRoot value on success or PEAR_Error on failure.

     * @access public

     * @see $this->validateEqFunction()

     * @see $this->getEqResult()

     * @see $this->isDivergentRow()

     * @see Math_Numerical_RootFinding_Newtonraphson2::compute()

     */

    function compute($fxFunction, $dfxFunction, $xR)

    {

        // evaluate f(x) equation function before begin anything

        $err = $this->validateEqFunction(

                 $fxFunction, $xR

               );

        if ($err === false) {

            return $err;

        }

        
        // evaluate df(x) equation function before begin anything

        $err = $this->validateEqFunction(

                 $dfxFunction, $xR

               );

        if ($err === false) {

            return $err;

        }

 

        // Sets maximum iteration and tolerance from options.

        $maxIteration = $this->options['max_iteration'];

        $errTolerance = $this->options['err_tolerance'];

 

        // Sets variable for saving errors during iteration, for divergent

        // detection.

        $epsErrors = array();

 

        for ($i = 1; $i < $maxIteration; $i++) {

            // Calculate f(x[i]), where: x[i] = $xR.

            $fxR = $this->getEqResult($fxFunction, $xR);

 

            // Calculate f'(x[i]), where: x[i] = $xR.

            $dxR = $this->getEqResult($dfxFunction, $xR);

 

            // Avoid division by zero.

            if ($dxR == 0) {

                //return PEAR::raiseError('Iteration skipped, division by zero');
                return false;

            }

 

            // Newton-Raphson's formula.

            $xN = $xR - ($fxR / $dxR);

 

            // xR is the root.

            if ($xN == 0) {

                $this->root = $xR;

                break;

            }

 

            // Compute error.

            $this->epsError = abs(($xN - $xR) / $xN);

            $epsErrors[]    = $this->epsError;

 

            // Detect for divergent rows.

            if ($this->isDivergentRows($epsErrors) &&

                $this->options['divergent_skip']) {
                //die(print_r($epsErrors));

                /*return PEAR::raiseError(

                         'Iteration skipped, divergent rows detected'

                       );*/
                return false;

                break;

            }

 

            // Check for error tolerance, if lower than or equal with

            // $errTolerance it is the root.

            if ($this->epsError <= $errTolerance) {

                $this->root = $xR;

                break;

            }

 

            // Switch x[i+1] -> x[i], where: x[i] = $xR and x[i+1] = $xN.

            $xR = $xN;

        }

        $this->iterationCount = $i;
        return $this->root;

    }

 

    // }}}

}
