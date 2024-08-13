<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<link href="https://fonts.cdnfonts.com/css/manifestly" rel="stylesheet">
<link href="https://fonts.cdnfonts.com/css/depixel" rel="stylesheet">

<style type="text/css">
    center {
        width : 100%;
    }
    .main{
        min-height:100%;
    }
</style>
                
<div style="height:75%; position:relative; max-height:33vw;">
    <div style="height:100%; width:50%; display:inline-block">
    </div>
    <img style="height:100%; display:inline-block" src="img/system-sq.jpg"/>
    <div style="position: absolute; top: 5%; left: 10%;">
    <span style="font-size:2vw; font-family: 'Manifestly', sans-serif;">Introducing the</span><br>
    <span style="font-size: 5vw; font-family:'DePixel', sans-serif;">GAMETANK</span>
    <span style="font-size:1.5vw; font-family:Arial;">
        <ul>
                <li>W65C02S CPU @ 3.5MHz</li>
                <li>Double 128x128 Framebuffer</li>
                <li>200 Colors</li>
                <li>3.5 Megapixel/second blitter</li>
                <li>Dedicated audio coprocessor</li>
                <li>Fully open source</li>
        </ul>
    </span>
    </div>
</div>

<div class="gallery" style="margin-top:5%">
    <center>
        <h2>The GameTank is an open source 8-bit retroconsole that YOU can build, and build games for.</h2>
    </center>
    <center>
        <h2>...and now you can <a href="https://swag.gametank.zone/products/the-gametank">buy one</a> too!</h2>
    </center>
    <p>
        Similar in spirit to fantasy consoles like the Pico-8 or TIC-80, the GameTank is set apart by its implementation as a <em>physical hardware device first</em>,
        followed by an emulator second. Games are written in assembly, or a mix of C and assembly. The special hardware features of the GameTank - such as the
        Sprite Copy mechanism and the Audio Coprocessor - streamline the process of writing fun and richly animated games.
    </p>
    <center>
        <h2>All the schematics, board files, and 3D print files are <a href="https://github.com/clydeshaffer/GameTank">available on GitHub</a></h2>
    </center>
    <p>
        You might very well be a couple of electronic component orders and a weekend of soldering away from having your very own GameTank to plug into your TV.
        Seriously! One of this project's guiding principles has been to use through-hole parts that are easy to work with, and parts that are <em>still made today.</em>
        No scouring eBay for old-stock chips is needed: You can source all the components brand new on Digi-Key and Mouser.
    </p>
    <center>
        <h2>There's an <a href="https://github.com/clydeshaffer/GameTankEmulator">emulator</a> too!</h2>
    </center>
    <p>
        To make development for the system easier, the GameTank has an emulator with builds for Windows, OSX, and Linux. There's even a version that runs in the browser, and performs decently on certain phones.
        The emulator is under active development to better replicate the behaviors of the physical console, as well as add-on hardware or special cartridge features.
    </p>
    <center>
        <h2>Interested in developing for the GameTank? Consider joining the <a href="https://discord.gg/8z7hncf4GY">Discord!</a></h2>
    </center>
    <p>
        A nicely-formatted programming manual and tutorials are in the works... but in the meantime, check out some <a href="https://github.com/clydeshaffer/GameTankEmulator/tree/main/asm/Tutorial">example code</a> in the emulator repo!
            You are also encouraged to join the Discord and ask questions directly. In fact, this will help inform the areas the tutorials and manual need to cover in more detail. So please, ask away!
    </p>
</div>

<center>
    <h2>See the system in action!</h2>
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/ZP2NPPouTkA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</center>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>