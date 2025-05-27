<?php
namespace rhossis\mathfinance\MathFinance\abstractclass\Swx;

use rhossis\Exception\MathFinanceException;

/**
 * Class for accrued interest calculations
 *
 * Implementation of various accrued interest
 * calculations and day count methods
 *
 * PHP versions 5.4+
 *
 * @category   Math
 * @package    rhossis.mathfinance
 * @author     <cogana@gmail.com>
 * @copyright  2025 CYRIL OGANA
 */
class BondAccruedInterest 
{
    //variables to hold day, month and year values separately for 3 dates
    protected $dayOne    = 0;
    protected $dayOneX   = 0;
    protected $monthOne  = 0;
    protected $yearOne   = 0;
    
    protected $dayTwo    = 0;
    protected $dayTwoX   = 0;
    protected $monthTwo  = 0;
    protected $yearTwo   = 0;
    
    protected $dayThree    = 0;
    protected $monthThree  = 0;
    protected $yearThree   = 0;
    
    //"anchor" date: start date for notional...
    protected $anchorDate  = '';
    
    //periods
    protected $anchorDay   = 0;
    protected $anchorMonth = 0;
    protected $anchorYear  = 0;
    
    //"working dates" in notional period loop
    protected $workingDateMonth = 0;
    protected $workingDateYear = 0;
    
    //end date for notional period loop
    protected $endDate = '';
    
    //number of interest-bearing days
    protected $interestDays  = 0;
    protected $interestDaysX = 0;
    
    //length of a year (ISMA - Year)
    protected $yearLength  = 0;
    
    //regular coupon length in months
    protected $couponLength  = 0;
    
    //notional period length in days
    protected $notionalPeriodLength  = 0;
    protected $notionalPeriodLengthX = 0;
    
    //applicable coupon frequency
    protected $couponFrequency  = 0;
    protected $couponFrequencyX = 0;
    
    //various flags
    protected $flagPeriodic = false;
    protected $flagRegular  = false;
    
    //direction
    protected $direction = 0;
    
    //used for temporary serial date values
    protected $currC  = 0;
    protected $nextC  = 0;
    protected $tempD  = '';
    
    /**
     * Constructor
     */
    public function __construct(){
        
    }

    public function setDayOne($dayOne) {
        if (!(is_int($dayOne))) {
            throw new MathFinanceException('Day One must be an integer');
        }
        
        $this->dayOne = $dayOne;
    }
    
    public function getDayOne() {
        return $this->dayOne;
    }

    public function setDayOneX($dayOneX) {
        if (!(is_int($dayOneX))) {
            throw new MathFinanceException('Day One X must be an integer');
        }
        
        $this->dayOneX = $dayOneX;
    }
    
    public function getDayOneX() {
        return $this->dayOneX;
    }
    
    public function setMonthOne($monthOne) {
        if (!(is_int($monthOne))) {
            throw new MathFinanceException('Month One must be an integer');
        }
        
        $this->monthOne = $monthOne;
    }
    
    public function getMonthOne() {
        return $this->monthOne;
    }
    
    public function setYearOne($yearOne) {
        if (!(is_int($yearOne))) {
            throw new MathFinanceException('Year One must be an integer');
        }
        
        $this->yearOne = $yearOne;
    }
    
    public function getYearOne() {
        return $this->yearOne;
    }
     
    public function setDayTwo($dayTwo) {
        if (!(is_int($dayTwo))) {
            throw new MathFinanceException('Day Two must be an integer');
        }
        
        $this->dayTwo = $dayTwo;
    }
    
    public function getDayTwo() {
        return $this->dayTwo;
    }
    
    public function setDayTwoX($dayTwoX) {
        if (!(is_int($dayTwoX))) {
            throw new MathFinanceException('Day Two X must be an integer');
        }
        
        $this->dayTwoX = $dayTwoX;
    }
        
    public function getDayTwoX() {
        return $this->dayTwoX;
    }   
    
    public function setMonthTwo($monthTwo) {
        if (!(is_int($monthTwo))) {
            throw new MathFinanceException('Month Two X must be an integer');
        }
        
        $this->monthTwo = $monthTwo;
    }
      
    public function getMonthTwo() {
        return $this->monthTwo;
    }
    
    public function setYearTwo($yearTwo) {
        if (!(is_int($yearTwo))) {
            throw new MathFinanceException('Year Two must be an integer');
        }
        
        $this->yearTwo = $yearTwo;
    }
    
    public function getYearTwo() {
        return $this->yearTwo;
    }
    
    public function setDayThree($dayThree) {
        if (!(is_int($dayThree))) {
            throw new MathFinanceException('Day Three must be an integer');
        }
        
        $this->dayThree = $dayThree;
    }
        
    public function getDayThree() {
        return $this->dayThree;
    }
    
    public function setMonthThree($monthThree) {
        if (!(is_int($monthThree))) {
            throw new MathFinanceException('Month Three must be an integer');
        }
        
        $this->monthThree = $monthThree;
    }
    
    public function getMonthThree() {
        return $this->monthThree;
    }
    
    public function setYearThree($yearThree) {
        if (!(is_int($yearThree))) {
            throw new MathFinanceException('Year Three must be an integer');
        }
        
        $this->yearThree = $yearThree;
    }
    
    public function getYearThree() {
        return $this->yearThree;
    }
    
    public function setAnchorDate($anchorDate) {
        $this->anchorDate = new \DateTime($anchorDate);
    }
    
    public function getAnchorDate() {
        return $this->anchorDate;
    }
    
    public function setAnchorDay($anchorDay) {
        if (!(is_int($anchorDay))) {
            throw new MathFinanceException('Anchor Day must be an integer');
        }
        
        $this->anchorDay = $anchorDay;        
    }
    
    public function getAnchorDay() {
        return $this->anchorDay;
    }
    
    public function setAnchorMonth($anchorMonth) {
        if (!(is_int($anchorMonth))) {
            throw new MathFinanceException('Anchor Month must be an integer');
        }
    
        $this->anchorMonth = $anchorMonth;        
    }
    
    public function getAnchorMonth() {
        return $this->anchorMonth;
    }

    public function setAnchorYear($anchorYear) {
        if (!(is_int($anchorYear))) {
            throw new MathFinanceException('Anchor Year must be an integer');
        }
        
        $this->anchorYear = $anchorYear;        
    }
    
    public function getAnchorYear() {
        return $this->anchorYear;
    }

    public function setWorkingDateYear($workingDateYear) {
        if (!(is_int($workingDateYear))) {
            throw new MathFinanceException('Working Date Year must be an integer');
        }
        
        $this->workingDateYear = $workingDateYear;
    }
    
    public function getWorkingDateYear() {
        return $this->workingDateYear;
    }
    
    public function setWorkingDateMonth($workingDateMonth) {
        if (!(is_int($workingDateMonth))) {
            throw new MathFinanceException('Working Date Month must be an integer');
        }
        
        $this->workingDateMonth = $workingDateMonth;
    }
    
    public function getWorkingDateMonth() {
        return $this->workingDateMonth;
    }
    
    public function setEndDate($endDate) {
        $this->endDate = new \DateTime($endDate);
    }
    
    public function getEndDate() {
        return $this->endDate;
    }
    
    public function setInterestDays($interestDays) {
        if (!(is_int($interestDays))) {
            throw new MathFinanceException('Interest Days must be an integer');
        }
        
        $this->interestDays = $interestDays;
    }
    
    public function getInterestDays() {
        return $this->interestDays;
    }
    
    public function setInterestDaysX($interestDaysX) {
        if (!(is_int($interestDaysX))) {
            throw new MathFinanceException('Interest Days X must be an integer');
        }
        
        $this->interestDaysX = $interestDaysX;
    }
    
    public function getInterestDaysX() {
        return $this->interestDaysX;
    }
    
    public function setYearLength($yearLength) {
        if (!(is_double($yearLength))) {
            throw new MathFinanceException('Year length must be a double');
        }
        
        $this->yearLength = $yearLength;
    }
    
    public function getYearLength() {
        return $this->yearLength;
    }
    
    public function setCouponLength($couponLength) {
        if (!(is_int($couponLength))) {
            throw new MathFinanceException('Coupon Length must be an integer');
        }
        
        $this->couponLength = $couponLength;
    }
    
    public function getCouponLength() {
        return $this->couponLength;
    }
    
    public function setNotionalPeriodLength($notionalPeriodLength) {
        if (!(is_double($notionalPeriodLength))) {
            throw new MathFinanceException('Notional Period Length must be a double');
        }
        
        $this->notionalPeriodLength = $notionalPeriodLength;
    }
    
    public function getNotionalPeriodLength() {
        return $this->notionalPeriodLength;
    }
    
    public function setNotionalPeriodLengthX($notionalPeriodLengthX) {
        if ((!is_double($notionalPeriodLengthX))) {
            throw new MathFinanceException('Notional Period Length X must be a double');
        }
        
        $this->notionalPeriodLengthX = $notionalPeriodLengthX;
    }
    
    public function getNotionalPeriodLengthX() {
        return $this->notionalPeriodLengthX;
    }
    
    public function setCouponFrequency($couponFrequency) {
        if ((!is_double($couponFrequency))) {
            throw new MathFinanceException('Coupon Frequency must be a double');
        }
        
        $this->couponFrequency = $couponFrequency;
    }
    
    public function getCouponFrequency() {
        return $this->couponFrequency;
    }
    
    public function setCouponFrequencyX($couponFrequencyX) {
        if ((!is_double($couponFrequencyX))) {
            throw new MathFinanceException('Coupon Frequency X must be a double');
        }
        
        $this->couponFrequencyX = $couponFrequencyX;
    }
    
    public function getCouponFrequencyX() {
        return $this->couponFrequencyX;
    }
    
    public function setFlagPeriodic($flagPeriodic) {
        if ((!is_bool($flagPeriodic))) {
            throw new MathFinanceException('Flag Period must be boolean');
        }
        
        $this->flagPeriodic = $flagPeriodic;
    }
    
    public function getFlagPeriodic() {
        return $this->flagPeriodic;
    }
    
    public function setFlagRegular($flagRegular) {
        if (!(is_bool($flagRegular))) {
            throw new MathFinanceException('Flag Regular must be boolean');
        }
        
        $this->flagRegular = $flagRegular;
    }
    
    public function getFlagRegular() {
        return $this->flagRegular;
    }
    
    public function setDirection($direction) {
        if (!(is_int($direction))) {
            throw new MathFinanceException('Direction must be an integer');
        }
        
        $this->direction = $direction;
    }
    
    public function getDirection() {
        return $this->direction;
    }
    
    public function setCurrC($currC) {
        $this->currC = new \DateTime($currC);
    }
    
    public function getCurrC() {
        return $this->currC;
    }
    
    public function setNextC($nextC) {
        $this->nextC = new \DateTime($nextC);
    }
    
    public function getNextC() {
        return $this->nextC;
    }
    
    public function setTempD($tempD) {
        $this->tempD = new \DateTime($tempD);
    }
    
    public function getTempD() {
        return $this->tempD;
    }
    
    public function accruedInterestFactor(
        $dCM,
        $d1M1Y1,
        $d2M2Y2,
        $d3M3Y3,
        $fValue,
        $maturityDateStr
    ) {
        //Create DateTime objects
        $d1M1Y1Obj    = new \DateTime($d1M1Y1);
        $d2M2Y2Obj    = new \Datetime($d2M2Y2);
        $d3M3Y3Obj    = new \DateTime($d3M3Y3);
        $maturityDate = new \DateTime($maturityDateStr);
        
        $this->setCouponFrequency((double) $fValue);
        
        //Determine number of interest bearing days
        switch ($dCM) {
            case \MATHFINANCE_SWX_BOND_AI_GERMAN:
                $this->setDayOne((int) $d1M1Y1Obj->format('j'));
                $this->setMonthOne((int) $d1M1Y1Obj->format('n'));
                $this->setYearOne((int) $d1M1Y1Obj->format('Y'));
                
                $this->setDayTwo((int) $d2M2Y2Obj->format('j'));
                $this->setMonthTwo((int) $d2M2Y2Obj->format('n'));
                $this->setYearTwo((int) $d2M2Y2Obj->format('Y'));
                
                if ($this->getDayOne() == 31) {
                    $this->setDayOneX(30);
                } elseif ($this->isFebUltimo($d1M1Y1)) {
                    $this->setDayOneX(30);
                } else {
                    $this->setDayOneX(($this->getDayOne()));
                }
                
                if ($this->getDayTwo() == 31) {
                    $this->setDayTwoX(30);
                } elseif ($this->isFebUltimo($d2M2Y2)) {
                    $this->setDayTwoX(30);
                } else {
                    $this->setDayTwoX(($this->getDayTwo()));
                }
                
                $interestDays = (
                    ($this->getDayTwoX() - $this->getDayOneX())
                    + 30 * ($this->getMonthTwo() - $this->getMonthOne())
                    + 360 * ($this->getYearTwo() - $this->getYearOne())
                );
                //return $interestDays;
                $this->setInterestDays($interestDays);
                //return $this->getInterestDays();
                break;
            case \MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN:
                $this->setDayOne((int) $d1M1Y1Obj->format('j'));
                $this->setMonthOne((int) $d1M1Y1Obj->format('n'));
                $this->setYearOne((int) $d1M1Y1Obj->format('Y'));
                
                $this->setDayTwo((int) $d2M2Y2Obj->format('j'));
                $this->setMonthTwo((int) $d2M2Y2Obj->format('n'));
                $this->setYearTwo((int) $d2M2Y2Obj->format('Y'));
                
                if ($this->getDayOne() == 31) {
                    $this->setDayOneX(30);
                } else {
                    $this->setDayOneX($this->getDayOne());
                }
                
                if ($this->getDayTwo() == 31) {
                    $this->setDayTwoX(30);
                } else {
                    $this->setDayTwoX($this->getDayTwo());
                }
                
                $interestDays = (
                    ($this->getDayTwoX() - $this->getDayOneX())
                    + 30 * ($this->getMonthTwo() - $this->getMonthOne())
                    + 360 * ($this->getYearTwo() - $this->getYearOne())
                );
                
                $this->setInterestDays($interestDays);
                break;
            case \MATHFINANCE_SWX_BOND_AI_ENGLISH:
            case \MATHFINANCE_SWX_BOND_AI_FRENCH:
            case \MATHFINANCE_SWX_BOND_AI_ISMA_YEAR:
            case \MATHFINANCE_SWX_BOND_AI_ISMA_99N:
            case \MATHFINANCE_SWX_BOND_AI_ISMA_99U:
            case \MATHFINANCE_SWX_BOND_AI_KENYA:
            case \MATHFINANCE_SWX_BOND_AI_CBK_KENYA:
                $interestDays = $d2M2Y2Obj->diff($d1M1Y1Obj);
                $this->setInterestDays((int) $interestDays->format('%a'));
                break;
            case \MATHFINANCE_SWX_BOND_AI_US:
                $this->setDayOne((int) $d1M1Y1Obj->format('j'));
                $this->setMonthOne((int) $d1M1Y1Obj->format('n'));
                $this->setYearOne((int) $d1M1Y1Obj->format('Y'));
                
                $this->setDayTwo((int) $d2M2Y2Obj->format('j'));
                $this->setMonthTwo((int) $d2M2Y2Obj->format('n'));
                $this->setYearTwo((int) $d2M2Y2Obj->format('Y'));
                
                $this->setDayOneX($this->getDayOne());
                $this->setDayTwoX($this->getDayTwo());
                
                if ($this->isFebUltimo($d1M1Y1) && $this->isFebUltimo($d2M2Y2)) {
                    $this->setDayTwoX(30);
                }
                
                if ($this->isFebUltimo($d1M1Y1)) {
                    $this->setDayOneX(30);
                }
                
                if ($this->getDayOneX() == 31) {
                    $this->setDayOneX(31);
                }
                
                $interestDays = (
                    ($this->getDayTwoX() - $this->getDayOneX())
                    + 30 * ($this->getMonthTwo() - $this->getMonthOne())
                    + 360 * ($this->getYearTwo() - $this->getYearOne())
                );
                
                $this->setInterestDays($interestDays);               
                break;
            default:
                throw new MathFinanceException('Bad Day Count Method provided');
        }
        
        //Determine Basic Accrued Interest Factor
        switch ($dCM) {
            case \MATHFINANCE_SWX_BOND_AI_GERMAN:
            case \MATHFINANCE_SWX_BOND_AI_SPEC_GERMAN:
            case \MATHFINANCE_SWX_BOND_AI_FRENCH:
            case \MATHFINANCE_SWX_BOND_AI_US:
                return (double) ($this->getInterestDays() / 360);
            case \MATHFINANCE_SWX_BOND_AI_ENGLISH:
                return (double) ($this->getInterestDays() / 365);
            case \MATHFINANCE_SWX_BOND_AI_CBK_KENYA:
                return (double) ($this->getInterestDays() / 364);
            case \MATHFINANCE_SWX_BOND_AI_ISMA_YEAR:
            case \MATHFINANCE_SWX_BOND_AI_KENYA:
                $this->setDayOne((int) $d1M1Y1Obj->format('j'));
                $this->setMonthOne((int) $d1M1Y1Obj->format('n'));
                $this->setYearOne((int) $d1M1Y1Obj->format('Y'));
                
                $this->setDayThree((int) $d3M3Y3Obj->format('j'));
                $this->setMonthThree((int) $d3M3Y3Obj->format('n'));
                $this->setYearThree((int) $d3M3Y3Obj->format('Y'));
                
                if ($fValue == 1) {
                    $counter1Obj = $d3M3Y3Obj->diff($d1M1Y1Obj);
                    $counter1 = $counter1Obj->format('%a');

                    if ($counter1 == 365 || $counter1 == 366) {
                        $this->setYearLength((double) $counter1);
                    } else {
                        $this->setYearLength((double) 365);
                        
                        $counter2 = $this->getYearOne();
                        
                        while ($counter2 <= $this->getYearThree()) {
                            $this->setTempD(($this->getUltimo($counter2, 2)->format('Y-m-d')));
                            
                            $dayTempD = (int) $this->getTempD()->format('j');
                            
                            if ($dayTempD == 29
                                && $this->getTempD() > $d1M1Y1Obj
                                && $this->getTempD() <= $d3M3Y3Obj
                            ) {
                                $this->setYearLength((double) 366);
                                break;
                            }
                            
                            ++$counter2;
                        }
                    }
                } else {
                    if (
                        ($this->getYearThree() % 4 == 0
                        && $this->getYearThree() % 100 != 0)
                        || $this->getYearThree() % 400 == 0
                    ) {
                        $this->setYearLength((double) 366);
                    } else {
                        $this->setYearLength((double) 365);
                    }
                }
                
                return  $this->getInterestDays() / $this->getYearLength();
            case \MATHFINANCE_SWX_BOND_AI_ISMA_99N:
            case \MATHFINANCE_SWX_BOND_AI_ISMA_99U:
                $this->setDayOne((int) $d1M1Y1Obj->format('j'));
                $this->setMonthOne((int) $d1M1Y1Obj->format('n'));
                $this->setYearOne((int) $d1M1Y1Obj->format('Y'));
                
                $this->setDayThree((int) $d3M3Y3Obj->format('j'));
                $this->setMonthThree((int) $d3M3Y3Obj->format('n'));
                $this->setYearThree((int) $d3M3Y3Obj->format('Y'));
                
                $this->setFlagPeriodic(false);
                $this->setCouponLength(12);
                $this->setCouponFrequencyX(1.0);
                $this->setFlagRegular(false);

                if ($fValue > 1) {
                    if (((double) (12 / $this->getCouponFrequency()))
                        - ((int) (12 / $this->getCouponFrequency()))
                        == 0.0
                    ) {
                        $this->setFlagPeriodic(true);
                        $this->setCouponLength(((int)(12 / $this->getCouponFrequency())));
                        $this->setCouponFrequencyX($this->getCouponFrequency());
                        $this->setFlagRegular(false);
                        
                        if (
                            (($this->getYearThree() - $this->getYearOne()) * 12
                            + ($this->getMonthThree() - $this->getMonthOne()))
                            == $this->getCouponLength()
                        ) {
                            if ($dCM == \MATHFINANCE_SWX_BOND_AI_ISMA_99N) {
                                if ($this->getDayOne() == $this->getDayThree()) {
                                    $this->setFlagRegular(true);
                                } elseif(
                                    checkdate($this->getYearOne(), $this->getMonthOne(), $this->getDayThree()) === false
                                    && $this->isUltimo($d1M1Y1)
                                ) {
                                    $this->setFlagRegular(true);
                                } elseif (
                                    checkdate($this->getYearThree(), $this->getMonthThree(), $this->getDayOne()) === false
                                    && $this->isUltimo($d3M3Y3)
                                ) {
                                    $this->setFlagRegular(true);
                                }
                            } else {
                                if ($this->isUltimo($d1M1Y1) && $this->isUltimo($d3M3Y3)) {
                                    $this->setFlagRegular(true);
                                }
                            }
                        }                      
                    }
                }

                if ($this->getFlagRegular()) {
                    $this->setNotionalPeriodLength((double) $d3M3Y3Obj->diff($d1M1Y1Obj)->format('%a'));
                    return (1 / $this->getCouponFrequencyX() * ($this->getInterestDays() / $this->getNotionalPeriodLength()));
                } else {
                    (double) $aIFactor = 0.0;
                    if ($d3M3Y3Obj == $maturityDate) {
                        $this->setDirection(1);
                        $this->setAnchorDate($d1M1Y1);
                        $this->setAnchorYear((int) $d1M1Y1Obj->format('Y'));
                        $this->setAnchorMonth((int) $d1M1Y1Obj->format('n'));
                        $this->setAnchorDay((int) $d1M1Y1Obj->format('j'));
                        $this->setEndDate($d3M3Y3);
                    } else {
                        $this->setDirection(-1);
                        $this->setAnchorDate($d3M3Y3);
                        $this->setAnchorYear((int) $d3M3Y3Obj->format('Y'));
                        $this->setAnchorMonth((int) $d3M3Y3Obj->format('n'));
                        $this->setAnchorDay((int) $d3M3Y3Obj->format('j'));
                        $this->setEndDate($d1M1Y1);                        
                    }
                    
                    $this->setCurrC(($this->getAnchorYear(). '-' . $this->getAnchorMonth() . '-' . $this->getAnchorDay()));
                    $counter3 = 0;
                    //throw new \Exception(((int) ($this->getCurrC()->diff($this->getEndDate())->format('%a'))));
                    while (
                        ($this->getDirection() 
                        * ((int) ($this->getEndDate()->diff($this->getCurrC())->format('%R%a'))))
                        < 0
                    ) {
                        $counter3 += $this->getDirection();
                        $this->setWorkingDateYear(
                            $this->calculateNewYear(
                                $this->getAnchorYear(),
                                $this->getAnchorMonth(),
                                ($counter3 * $this->getCouponLength())
                            )
                        );
                        $this->setWorkingDateMonth(
                            $this->calculateNewMonth(
                                $this->getAnchorMonth(),
                                ($counter3 * $this->getCouponLength())
                            )
                        );
                        
                        if ($dCM == \MATHFINANCE_SWX_BOND_AI_ISMA_99N) {
                            if (checkdate($this->getWorkingDateYear(), $this->getWorkingDateMonth(), $this->getAnchorDay()) === false) {
                                $this->setNextC($this->getUltimo($this->getWorkingDateYear(), $this->getWorkingDateMonth())->format('Y-m-d'));
                            } else {
                                $this->setNextC(((($this->getWorkingDateYear() . '-' . $this->getWorkingDateMonth() . '-' . $this->getAnchorDay()))));
                            }
                        } else {
                            $this->setNextC($this->getUltimo($this->getWorkingDateYear(), $this->getWorkingDateMonth())->format('Y-m-d'));
                        }
                        
                        
                        $this->setInterestDaysX(
                            (
                                (int) ($this->compareDateMin(
                                    $d2M2Y2Obj,
                                    $this->compareDateMax($this->getNextC(), $this->getCurrC())
                                )->diff(
                                ($this->compareDateMax(
                                    $d1M1Y1Obj,
                                    $this->compareDateMin($this->getCurrC(), $this->getNextC())
                                )))->format('%a')
                            ))
                        );
                        
                        /*return ($this->compareDateMin(
                                    $d2M2Y2Obj,
                                    $this->compareDateMax($this->getNextC(), $this->getCurrC())
                                ));*/
                        $this->setNotionalPeriodLengthX((double) ($this->getDirection() * ((int) ($this->getNextC()->diff($this->getCurrC())->format('%a')))));
                        
                        if ($this->getInterestDaysX() > 0) {
                            $aIFactor += ($this->getInterestDaysX() / $this->getNotionalPeriodLengthX());
                        }
                        
                        $this->setCurrC($this->getNextC()->format('Y-m-d'));
                    }
                    
                    $aIFactor /= $this->getCouponFrequencyX();
                    return $aIFactor;
                }
                break;
        }
    }
    
    public function compareDateMin(\DateTime $dateA, \DateTime $dateB) {
        if ($dateA > $dateB) {
            return $dateB;
        } else {
            return $dateA;
        }
    }
    
    public function compareDateMax(\DateTime $dateA, \DateTime $dateB) {
        if ($dateA > $dateB){
            return $dateA;
        } else {
            return $dateB;
        }
    }
    
    public function getUltimo($yearNum, $monthNum) {
        $yearUltimo  = (int) ($yearNum + ($monthNum / 12));
        $monthUltimo = (int) (($monthNum % 12) + 1);
        $dayUltimo   = 1;
        
        $dateUltimo    = $yearUltimo . '-' . $monthUltimo . '-' . $dayUltimo;
        $dateUltimoObj = new \DateTime($dateUltimo);
        $dateUltimoObj->sub(new \DateInterval('P1D'));
        
        return $dateUltimoObj;       
    }
    
    public function isUltimo($dateA) {
        $dateAObj = new \DateTime($dateA);
        $dateAObj->add(new \DateInterval('P1D'));
        $dateADay = (int) $dateAObj->format('j');
        return ($dateADay == 1);
    }
    
    public function isFebUltimo($dateA) {
        $dateAObj = new \DateTime($dateA);
        $dateAObj->add(new \DateInterval('P1D'));
        $dateADay = (int) $dateAObj->format('j');
        $dateAMonth = (int) $dateAObj->format('n');
        return ($dateADay == 1 && $dateAMonth == 3);
    }
    
    public function calculateNewMonth($monthNum, $numMonths) {
        $resultMonths = $monthNum + $numMonths;
        
        if ($resultMonths > 0) {
            return ($resultMonths - 1) % 12 + 1;
        } else {
            return 12 + ($numMonths % 12);
        }
    }
    
    public function calculateNewYear($yearNum, $monthNum, $numMonths) {
        $resultMonths = $monthNum + $numMonths;
        
        if ($resultMonths > 0) {
            return $yearNum + ((int) (($resultMonths - 1) / 12));
        } else {
            return $yearNum  - 1 + ((int) ($resultMonths / 12));
        }
    }
}
