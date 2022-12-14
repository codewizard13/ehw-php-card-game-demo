<?php

/**
 * $Rev: 4$
 * $Date: 2012-03-30 $
 * $Id: $
 * $Author: eric.hepperle $
 * $HeadURL: https://bookit-dev.com/repos/lib/branches/eric.hepperle/classes/view_utilities/viewutilities.php $
 *
 * @author Eric Hepperle <eric.hepperle@bookit.com>
 * @date-created 2011-11-01
 * @description
 *  contains tools for developers to use in debugging and troubleshooting
 * 
 * @version 1.0
 * 
 * @requires
 *  Add:
 *		$al->addPath("classes/view_utilities");
 *  to your autoload.php file.
 * 
 *  (C:\Users\<your id>\Documents\NetBeansProjects\<your branch name>\lib\autoload.php)
 * 
 * @notes
 *  => Only debug() works currently.  generateHtmlTable worked, but then I
 *		started to refactor it and broke it.  Need to revisit this.
 */
class ViewUtilities {
    // CONSTANTS
    // ...
    const DS = DIRECTORY_SEPARATOR;
    
    /**
     * builds an html table with a specified number of rows and columns.
     *  if nothing specified, default is 3x3. this is the original working
     *  version.
     *
     * @param integer $numCols number of columns
     * @param integer $numRows number of rows
     * @return ArrayObject
     */      
    public static function generateHtmlTable($numCols="3",$numRows="3") {
        
        $htmlTable = "<table border='1'>\n";

        for ($i=1;$i<=$numRows;$i++) {

            for ($n=1;$n<=$numCols;$n++) {

                $newRow .= "<td>Row " . $i . ", Col " . $n . "</td>\n";
            }
            echo "<br />";

            $allRows .= "<tr>\n";
            $allRows .= $newRow;
            $allRows .= "</tr>\n";

            $newRow = ''; // clear row data before looping

        }

        $htmlTable .= $allRows;
        $htmlTable .= "</table>\n";

        return $htmlTable;
    }   
    
    
    
    /**
     * builds an html table with a specified number of rows and columns.
     *  if nothing specified, default is 3x3. this is the original working
     *  version.
     *
     * @param $optionsArray ArrayObject contains key value pairs that will be
     *          processed to determine the actual value of 
     * @param $numRows number of rows
     * @return ArrayObject
     */      
    public static function generateHtmlTable2($optionsArray) {
        
        $htmlTable = "<table border='1'>\n";

        for ($i=1;$i<=$numRows;$i++) {

            for ($n=1;$n<=$numCols;$n++) {

                $newRow .= "<td>Row " . $i . ", Col " . $n . "</td>\n";
            }
            echo "<br />";

            $allRows .= "<tr>\n";
            $allRows .= $newRow;
            $allRows .= "</tr>\n";

            $newRow = ''; // clear row data before looping

        }

        $htmlTable .= $allRows;
        $htmlTable .= "</table>\n";

        return $htmlTable;
        // unfinished ...
    }   

    /**
     * formats $var for pretty display using print_r
     *  and echos the formatted result.  can be used anywhere you'd use print_r.
     *
     * @return string $out
     * @param mixed $var variable passed in.  can be any displayable type;
     *  basically same rules as print_r.
     * @param string $varName what you want to display as the variable being traced.
     *         note: there is no built-in function to return a passed argument
	 *				 name -- that is something I will investigate further.
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
			'11'	=> 'background:#D8E091:color:#006400;', // lightGray_darkGreen
            '12'    => 'background:#A0D58D;color:black;', // light Green back, dark green border
            '13'    => 'background:orange;color:white',
            '14'    => 'background:purple;color:white'
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
                
    } 	

//    /**
//     * formats $var for pretty display using print_r
//     *  and echos the formatted result.  can be used anywhere you'd use print_r.
//     *
//     * @return string $out
//     * @param mixed $var variable passed in.  can be any displayable type;
//     *  basically same rules as print_r.
//     * @param string $varName what you want to display as the variable being traced.
//     *         note: there is no built-in function to return a passed argument
//	 *				 name -- that is something I will investigate further.
//     */    
//    public static function debug_orig($var,$description='') {       
//        
//        $description = $description!=NULL && $description!='' ? $description : date("Y-m-d, g:i a");
////        $description = date("Y-m-d");
//        
//        // set style as yellow text on olive background
//        $out  = "<div id='divDebug' 
//            style='background:#b9b91b;padding:10;margin:10;
//                border-style:solid;border-width:2;border-color:red;
//                word-wrap:break-word;'>";
//        $out .= "<span style='font-size:1.4em;font-weight:bold;'>DEBUG:</span> <span style='color:cornsilk;font-size:1.2em;'>{$description}</span>";
//        $out .= "<br /><b>CALLED BY:</b> " . __FILE__ . "<br />";
//        $out .= "  <pre>";
//        $out .= print_r($var,true);
//        $out .= "</pre>";
//        $out .= "</div>";
//        
//        echo $out;
//                
//    } 
    
    /**
     * lists all the functions and their usages for a given class.
     *  if no class, then class is this class.
     *
     * @param $className the name of the class to read functions from.
     * @return nothing echo's formatted results to the view
     */        
    public static function help () {
        
        
        echo "<hr />";
        
        self::debug(get_class_methods(get_class($this)),'');
        
        $functionsRaw = get_class_methods(get_class($this));
        
        foreach ($functionsRaw as $func) {
            echo "Function: " . $func . "<br />";
        }
        
        echo "This function is <b>" . __FUNCTION__ . "</b><br />";
        // * IN PROGRESS (2011-10-14)
        
    }
    
    
    public static function getCommentPatterns() {
        
        $patterns = array (
            
//          'classObject' => "/*(.*)*/",
//            'classObject' => "/\/\*(.*)\*\//",
//            'classObject' => "//\*(.*)\*//"
            
//          'dubSlash'    => "//(.*)\n"
//            'dubSlash'    => "/\/\/(.*)\\n/" // works!
//            'dubSlash' => "/(/{2})(.*)/g"
            'dubSlash' => "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/g"
            
        );
        
        return $patterns; // ArrayObject
        
        // * IN PROGRESS (2011-10-14)
        
    }
    
    
    public static function getComments ($file) {
        
        // read file into a string
        
        $fileContents = file_get_contents($file);
//        
//        // parse $file for anything that looks like comments and add to
//        // output buffer
//        
//        $commentPatterns = self::getCommentPatterns();
//        
//        foreach ($commentPatterns as $pattern) {
//            
//            if (preg_match($pattern, $fileContents, $matches)) {
//                
//                echo ($matches);
//                
//            } else {
//                
//                echo "No matches found<br />";
//                
//            }
//            
//        }
        
        echo "<span style='background:#F0FFF0;color:forestgreen;'>";
        if(!file_get_contents($file)) {
            echo "*** THERE WAS A PROBLEM READING <b>{$file}</b><br />";
            return;
        
        } else {
            echo "FILE <b>{$file}</b> was read just fine<br />";
            echo "<div width='60%' style='background:moccasin;color:darkgoldenrod;'>";
            echo "Contents of <b>{$file}</b> :";
            echo nl2br(file_get_contents($file));
            echo "</div>";  
        }
        echo "</span>";
        
        $tokens = token_get_all($fileContents);
        
        var_dump($tokens);
        echo "<hr />";
        
        // NOTE: Probably going to end up using this token_get_all method.
        foreach ($tokens as $token) {
            if ($token[0] == T_COMMENT
                || $token[0] == T_DOC_COMMENT) {
                // This is a comment ;-)
                self::debug($token);
                echo "<hr />";
            }
        }


        
        // parse $file for anything that looks like comments and add to
        // output buffer
        
        $commentPatterns = self::getCommentPatterns();
        
        foreach ($commentPatterns as $pattern) {
            echo "PATTERN: " . $pattern . "<br />";
            
            if (preg_match($pattern, $fileContents, $matches)) {
                
                echo "<div width='60%' style='background:moccasin;color:darkgoldenrod;'>";
                var_dump($matches);
                echo "</div>";
                
            } else {
                
                echo "<span style='background:yellow;'>*** NO MATCHES FOUND ***<br /></span>";
                
            }
            
        }
        
        
        
    }


    public static function getCommentsTest() {
        
        return self::getComments(__FILE__);
        
    }
    
//    
//    /**
//     * gets 
//     *
//     * @param $imageUrl the url to the image file
//     * @return ArrayObject
//     */    
//    public static function readFileLines($filePath) {        
//
//        $file = fopen('C:/test/test_01.txt',"r");
//
//        while(! feof($file))
//          {
//          echo fgets($file). "<br />";
//          }
//
//        fclose($file);
//        
//        
//    }        
//    
  
    /**
     * lists all the functions and their usages for a given class.
     *  if no class, then class is this class.
     *
     * @param $numItems how many items in your dropdown menu
     * @return nothing echo's formatted results to the view
     */        
    public static function buildDummyDropdown ($id) {
        
//        ViewUtilities::debug($numItems,'$numItems');
//        $dropdownId = 'dd1';
//        
//        $s = "\t<label for='{$dropdownId}_dummy'>Dropdown $dropdownId</label><br />";
//        $s .= "\t<select name={$dropdownId}_dummy id={$dropdownId}_dummy size='1'>\n";
//
//        for ($c=1;$c>=$numItems;$c++) {
//
//            $id = $dropdownId . "_" . $c;
//            ViewUtilities::debug($id);
////            $s .= "\t\t<option id={$dropdownId}_{$c} name=$dropdownId_$c value=$dropdownId_$c>{$dropdownId}_item_{$c}</option>\n";
//            $s .= "<option id =$id name=$id value=$id>" . $dropdownId . "_item_" . $c . "</option>";
//
//        }
//
//        $s .= "\t</select>\n\n";
//
//        echo $s;
        
        $out = "<select name='DUMMY_$id' id='DUMMY_$id' value='DUMMY_$id'>";
            $out .= "<option name='test_01' id='test_01' value='test_01'>DROPDOWN ITEM 1</option>";
            $out .= "<option name='test_02' id='test_02' value='test_02'>DROPDOWN ITEM 2</option>";            
            $out .= "<option name='test_03' id='test_03' value='test_03'>DROPDOWN ITEM 3</option>";
        $out .= "</select>";
        
        echo $out;
    }
    
}


?>