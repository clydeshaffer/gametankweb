<script type="text/javascript">

function setImage(stepNumber, newSrc) {
    document.getElementById("stepImage" + stepNumber).src = newSrc;
}

</script>

<?php

$stepNumber = 0;

function buildstep($title, $bulletpoints, $images) {
    global $stepNumber;
    $stepNumber++;
    ?>
    <div class="buildStep">
        <a class="stepTitle" href="#step<?=$stepNumber?>" id="step<?=$stepNumber?>"><h2>Step <?=$stepNumber?>: <?=$title?></h2></a>
        <div class="stepContent">
            <div class="stepImages">
                <img id="stepImage<?=$stepNumber?>" class="stepBigImage" src="<?=$images[0]?>">
                <div class="stepLittleImageRow">
                <?php
                    if(count($images) > 1) {
                        foreach($images as $image) {
                            ?>
                            <img class="stepLittleImage" src="<?=$image?>" onclick="setImage(<?=$stepNumber?>,'<?=$image?>')">
                            <?php
                        }
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