<?php
//declare namespace
namespace rhossis\mathfinance\MathFinance\abstractclass;

/**
 * Singleton class to preserve given values of other variables in the callback functions
 */
class FunctionParameters
{ 
    public static $parameters = array();
    
    private static $singleton;

    /**
    * Constructor. Should be private, so used little hack.
    *
    * @param bool       Whether constructor has been called from a method of the class
    * @param array      Parameters (variables values of the function) to be preserved
    * @access private
    */
    function __construct($called_from_get_instance = False, $parameters = array())
    {
		// PHP4 hack
		if (!$called_from_get_instance) {
            trigger_error("Cannot instantiate Math_Finance_FunctionParameters class directly (It's a Singleton)", E_USER_ERROR);
        }

        foreach ($parameters as $name => $value) {
            self::$parameters[$name] = $value;
        }
    }

    /**
    * Method to be called statically to create Singleton
    *
    * @param array      Parameters (variables values of the function) to be preserved
    * @param bool       Whether the Singleton should be reset
    * @static
    * @access public
    */
	public static function getInstance($parameters = array(), $reset = False)
	{
	//static $singleton;

        if ($reset) {
            self::$singleton = null;
        }

        if (!is_object(self::$singleton)) {
            self::$singleton = new \rhossis\mathfinance\MathFinance\abstractclass\FunctionParameters(True, $parameters);
	}

		return self::$singleton;
	}
}
