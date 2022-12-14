<?php
include_once('utils/viewutilities_01.php');
require_once('gamecontroller.php');

    //ViewUtilities::debug($_SERVER,"Hello World!<br />",4);
   
    $controller = GameController::getInstance();
    
    // if user chooses 'New Game'
    if (isset($_POST['New_Game'])) {
        $controller->startNewGame();
        
        ViewUtilities::debug($controller,'$controller');
        ViewUtilities::debug($controller->getPlayer2(),'$player2');
    }
    

    
    // VIEW STUFF
    ?>
    <form name='game' value='' method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type='submit' name='New Game' value='NEW GAME' />
    </form>
    
    
    
    
    <?php
    
?>