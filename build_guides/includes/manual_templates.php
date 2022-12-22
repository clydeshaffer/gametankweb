<script type="text/javascript">

function setImage(stepNumber, newSrc) {
    document.getElementById("stepImage" + stepNumber).src = newSrc;
}

function zoomImage(srcStep) {
    var srcImg = document.getElementById("stepImage" + srcStep);
    var zoomModal = document.getElementById("zoomModal");
    var zoomImage = document.getElementById("zoomImg");
    zoomImage.src = srcImg.src;
    zoomModal.style.display = 'block';
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
                <img id="stepImage<?=$stepNumber?>" class="stepBigImage" src="<?=$images[0]?>" onclick="zoomImage('<?=$stepNumber?>');">
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

function zoomModalTemplate() {
    ?>
    <div class="zoomModal" id="zoomModal">
        <img class="zoomImg" id="zoomImg">
        <div class="modalX" onclick="document.getElementById('zoomModal').removeAttribute('style');">
            X
        </div>
    </div>
    <?php
}

?>