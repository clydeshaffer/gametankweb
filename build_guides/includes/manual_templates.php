<script type="text/javascript">

</script>

<?php

$stepNumber = 0;

function buildstep($title, $bulletpoints, $images) {
    global $stepNumber;
    $stepNumber++;
    ?>
    <div class="buildstep">
        <a class="stepTitle" href="#step<?=$stepNumber?>"><h2>Step <?=$stepNumber?>: <?=$title?></h2></a>
        <div class="stepContent">
            <div class="stepImages">
                <img class="stepBigImage" src="<?=$images[0]?>">
                <div class="stepLittleImageRow">
                <?php
                    foreach($images as $image) {
                        echo "<img class=\"stepLittleImage\" src=\"" . $image . "\">";
                    }
                ?>
                </div>
            </div>
            <div class="steptext">
                <ul>
                <?php
                    foreach($bulletpoints as $bulletpoint) {
                        echo '<li>';
                        echo $bulletpoint;
                        echo '</li><br>';
                    }
                ?>
                </ul>
            </div>
        </div>
        <hr>
    </div>
    <?php
}

?>