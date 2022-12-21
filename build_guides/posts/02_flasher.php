<!-- title = Building the USB flasher -->
<!-- thumb = img/v3/v3-mockup_front_sm.png -->
<?php $title = "Building the cartridge flasher"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<h1>Building the cartridge flasher</h1>
<p>
For the flasher you just need the card edge connector and a set of stacking headers for an Arduino MEGA shield.
</p>

<ul>
    <li><a href="https://www.digikey.com/en/products/detail/te-connectivity-amp-connectors/2-5530843-7/1121941">Cartridge connector</a></li>
    <li><a href="https://www.amazon.com/Shield-Stacking-Header-Arduino-MEGA/dp/B0756KLNLX">Headers</a></li>
</ul>

<p>
The PCB is "MegaProgrammer_2021-01-06.zip" in the "Production" folder of the GameTank repo.
<a href="https://github.com/clydeshaffer/gametank/tree/main/Production">https://github.com/clydeshaffer/gametank/tree/main/Production</a>
</p>

<p>
    Once you have the parts basically everything fits where it looks like it does. The cartridge flasher design is essentially just a connector between the cartridge pins and the digital IO pins of an Arduino Mega.
</p>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>