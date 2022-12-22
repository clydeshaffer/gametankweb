<script type="text/javascript">

</script>

<?php

$stepNumber = 0;

function buildstep($title, $bulletpoints, $images) {
    $stepNumber++;
    ?>
    <div class="buildstep">
        <a class="steptitle" href="#step<?=$stepNumber?>">Step <?=$stepNumber?>: <?=$title?></a>
        <div class="stepcontent">
            <div class="stepimages">
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
                        echo '</li>';
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