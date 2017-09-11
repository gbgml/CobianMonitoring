<?php
class Install {

    
    /**
     * This function used to block the every request except allowed ip address
     */
    function configCopy(){
            if (!file_exists('application/config/database.php')){
                if (!copy('application/config/database-example.php', 'application/config/database.php')) {
                    echo "не удалось скопировать $file...\n";
                }
            }
    }
}
?>