<?php

/**
 * $Rev: 4$
 * $Date: 2012-03-30 $
 * @author Eric Hepperle <eric.hepperle@bookit.com>
 * @date-created 2011-11-01
 * @description
 *  contains tools for developers to use in debugging and troubleshooting
 * 
 * @version 4.0
 * 
 */
class ViewUtilities {

    // CONSTANTS
    //
    const DS = DIRECTORY_SEPARATOR;      

    /**
     * formats $var for pretty display using print_r()
     *  and echos the formatted result.  can be used anywhere you'd use print_r.
     *
     * @return string $out
	 *
     * @param mixed $var variable passed in.  can be any displayable type;
     *  basically same rules as print_r.
	 *
     * @param string $varName what you want to display as the variable being traced.
     *         note: there is no built-in function to return a passed argument
	 *				 name -- that is something I will investigate further.
	 *
	 * @version 1.2 Added ability to set color scheme and ability to document
	 *	what file a particular debug statement is located in. (02/13/12 - Eric)
	 * ------
	 * Color Schemes:
	 * 1 = black text, olive background
	 * 2 = black on light-blue
	 * 3 = light-gray on manilla
	 * 4 = charcoal on beige
	 * 5 = yellow on purple
	 * 6 = lightGray on manilla
	 * 7 = darkGreen on lightGray
     */    
    public static function debug($var,$description='',$scheme='4') {       
        
        $description = $description!=NULL && $description!='' ? $description : date("Y-m-d, g:i a");
        
		// names correspond to <background color>_<text color>
		$colorSchemes = array(
			'1'		=> 'background:#b9b91b;color:black;', // olive_black
			'2'		=> 'background:#c3d5fd;color:black;', // lightBlue_black
			'3'		=> 'background:#ffffc4;color:#888a85;', // manilla_lightGray
			'4'		=> 'background:#f5f5dc;color:#333333;', // beige_charcoal
			'5'		=> 'background:purple;color:yellow;', // purple_yellow
			'6'		=> 'background:#ffffc4;color:black;', // manilla_black
			'7'		=> 'background:lightGray:color:#006400;' // lightGray_darkGreen
		);
		
		// keep track of where our debug statements are
		$trace = debug_backtrace();
      
      //echo "<pre>\$trace: ";
      //print_r($trace[1]);
      //echo "</pre>";
      
      // if we have values keep them, otherwise set to empty - This is required
      //  to keep our output from throwing the "Undefined offset" error.
      $traceParam_file = isset($trace[1]['file']) ? $trace[1]['file'] : '' ;
      $traceParam_line = isset($trace[1]['line']) ? $trace[1]['line'] : '' ;
      $traceParam_function = isset($trace[1]['function']) ? $trace[1]['function'] : '' ;
      $traceParam_class = isset($trace[1]['class']) ? $trace[1]['class'] : '' ;
      
		$debugInfo = array(
			'file'			=> $traceParam_file,
			'line'			=> $traceParam_line,
			'function'		=> $traceParam_function,
			'class'			=> $traceParam_class,
			'debugApp'		=> __FILE__
						
		);
		
        // set style as yellow text on olive background
        $out  = "<div id='divDebug' 
					style='$colorSchemes[$scheme];
							padding:10;
							margin:10;
							border-style:solid;
							border-width:2;
							border-color:red;
							word-wrap:break-word;'>";
		
		$out .= "<span style='color:#888a85;'>This Debug App is located in: <i>{$debugInfo['debugApp']}</i></span><br /><br />";
        $out .= "<span style='font-size:1.4em;font-weight:bold;'>DEBUG:</span> 
				<span style='color:black;font-size:1.2em;'>{$description}</span>";
					
//        $out .= "<br /><b>CALLED BY:</b> " . __FILE__ . "<br />";
            
        $classParamInfo = '';
        
        if (!empty($traceParam_class) && class_exists($traceParam_class,false)) {
        
            $classParamInfo = "<li><b>Class:</b> <span style='color:red;font-style:italic;'>{$debugInfo['class']}</span><li>";
        
        }        
               
		$out .= <<<OUT
			<div id='callerInfo' style='{$colorSchemes[$scheme]};
										font-family: arial, tahoma, sans-serif;
										width: 60%;
										padding: 10px;
										margin: 30px;
										
			'>
				<b><u>THIS DEBUG STATEMENT IS LOCATED IN:</u></b><br /><br />
				<ul style='list-style-type:none;'>
					<li><b>File:</b> <span style='color:red;font-style:italic;'>{$debugInfo['file']}</span></li>
					<li><b>Line:</b> <span style='color:red;font-style:italic;'>{$debugInfo['line']}</span></li>
					<li><b>Function:</b> <span style='color:red;font-style:italic;'>{$debugInfo['function']}</span><li>
               $classParamInfo
				</ul>
			</div>
OUT;
        $out .= "  <pre>";
        $out .= print_r($var,true);
        $out .= "</pre>";
        $out .= "</div>";
        
        echo $out;
                
    } // end function	

} // end class


?>