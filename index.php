<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php
    $page="home";
    include $_SERVER['DOCUMENT_ROOT'].'/include/head.php';
?>

<header class="header">
    <h2 class="header__heading"><a href="/"><span class="header__introducing">Introducing the</span> <span class="header__title">GameTank</span></a></h2>
    <ul class="header__features">
        <li>W65C02S CPU @ 3.5MHz</li>
        <li>Double 128x128 Framebuffer</li>
        <li>200 Colors</li>
        <li>3.5 Megapixel/second blitter</li>
        <li>Dedicated audio coprocessor</li>
        <li>Fully open source</li>
    </ul>
    <picture>
        <source srcset="/img/gametank-angle-01-smaller.png" media="(width < 800px)" />
        <img class="header__image" src="/img/gametank-angle-01.png" alt="Big blue GameTank console" />
    </picture>
</header>
<section class="homepage__content">
    <h2 class="announce">Live now on <a href="https://www.crowdsupply.com/clydeware/gametank">Crowd Supply</a>!! Order yours today to help make this production run happen!</h2>
    <p>
        Crowdfunding runs until Feb 26 with a July 2026 delivery target. Includes a cartridge flasher and a blank cartridge, along with a physical copy of Accursed Fiend.
    </p>
    <h2>The GameTank is an open source 8-bit retroconsole that YOU can build, and build games for.</h2>
    <p>
        Similar in spirit to fantasy consoles like the Pico-8 or TIC-80, the GameTank is set apart by its implementation as a <em>physical hardware device first</em>,
        followed by an emulator second. Games are written in assembly, or a mix of C and assembly. The special hardware features of the GameTank - such as the
        Sprite Copy mechanism and the Audio Coprocessor - streamline the process of writing fun and richly animated games.
    </p>

    <h2>All the schematics, board files, and 3D print files are <a href="https://github.com/clydeshaffer/GameTank">available on GitHub</a></h2>

    <p>
        You might very well be a couple of electronic component orders and a weekend of soldering away from having your very own GameTank to plug into your TV.
        Seriously! One of this project's guiding principles has been to use through-hole parts that are easy to work with, and parts that are <em>still made today.</em>
        No scouring eBay for old-stock chips is needed: You can source all the components brand new on Digi-Key and Mouser.
    </p>
    <h2>There's an <a href="https://github.com/clydeshaffer/GameTankEmulator">emulator</a> too!</h2>
    <p>
        To make development for the system easier, the GameTank has an emulator with builds for Windows, OSX, and Linux. There's even a version that runs in the browser, and performs decently on certain phones.
        The emulator is under active development to better replicate the behaviors of the physical console, as well as add-on hardware or special cartridge features.
    </p>
    <h2>Interested in developing for the GameTank? Consider joining the <a href="https://discord.gg/8z7hncf4GY">Discord!</a></h2>
    <p>
        A nicely-formatted programming manual and tutorials are in the works... but in the meantime, check out some <a href="https://github.com/clydeshaffer/GameTankEmulator/tree/main/asm/Tutorial">example code</a> in the emulator repo!
        You are also encouraged to join the Discord and ask questions directly. In fact, this will help inform the areas the tutorials and manual need to cover in more detail. So please, ask away!
    </p>
    
    <h2>See the system in action!</h2>
    <iframe src="https://www.youtube-nocookie.com/embed/ZP2NPPouTkA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</section>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>