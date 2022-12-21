<?php
    chdir("/var/www/webrepo/clydeshafferdotcom");
    $output = array();
    exec("git log -n 5 --invert-grep --grep='lowkey:'", $output);
    $commit = [];
    foreach($output as $line) {
       if(strpos($line, 'commit')===0){
            $commit = [];
       }
        else if(strpos($line, 'Author')===0){
        }
        else if(strpos($line, 'Date')===0){
            $commit['date']   = substr($line, strlen('Date:'));
        }
        else if($line != ''){
            $commit['message'] .= trim($line);
            echo '<div class="logentry"><h6>' . $commit['date'] . '</h6>';
            echo '<p>' . $commit['message'] . '</p></div>';
        }
    }
?>