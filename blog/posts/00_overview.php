<!-- title = Introduction -->
<!-- thumb = img/front_sm.jpg -->
<?php $title = "Introduction"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>Project Introduction</h1>

<img width="500" src="../img/front_sm.jpg">

<h2>How did I get here?</h2>
<p>
    When I was a kid, one of my dreams was to build a video game console. The reasoning being that I wanted to start my own video game company,
    and a REAL video game company releases their own console as well as first-party titles. (It was the 90s and I was a sheltered little kid, okay?)
    While I never exactly got to raise my own banner in the console wars of yore, I did study how to write games for PCs from a young age and built
    a pretty strong foundation for my eventual formal education in Computer Science.
</p>
<p>
    Fast-forward a bit and I'm an adult with disposable income, but not all that much of a social life. I had long been tinkering with electronics at
    the "module" level; eg. Arduinos, Raspberries Pi, premade sensor breakout boards... but it wasn't until I played the game MHRD and encountered
    some of Ben Eater's early videos that I realized much of my low-level programming experience could be directly translated into assembling digital logic
    gates on a breadboard. Soon I'd purchase a kit of assorted ICs, and begin to dabble with combinatoric and sequential logic circuits. 
</p>

<h2>Why the 6502?</h2>

<p>
    Oddly, having already seen both Ben Eater's breadboard CPU and solved the final level of MHRD, I wasn't all that terribly interested in designing a CPU.
    I had at that point pretty comfortably understood the workings of these existing designs, but didn't really have any ideas or inspiration at the time for
    developing my own design. I was however somewhat fascinated by the idea of building a computer around an existing CPU. Furthermore, it was inspring that not
    one but TWO different retro CPUs were still being made today that I could reasonably interface using simple logic. These were the Z80 and the 6502
    (in the form of WDC's 65C02S). I knew I just had to do <i>something</i> with one of these chips.
</p>

<p>
    A few specific factors led me to choose the 6502. I'd previously dabbled with coding in 6502 assembly for an NES emulator.
    It was a bit easier to find community resources for working with the 6502. Finally, I think memory-mapped I/O is pretty neat.
</p>

<h2>Setting out to build a game platform</h2>
<h3>or: <q>Free software? No, I said software-free!</q></h3>
<p>
    I settled on a few informal guidelines to steer the project by. I wanted to build a computer system that:
    <ul>
        <li>Displayed images on a TV</li>
        <li>Uses a gamepad as its primary imput method</li>
        <li>Has its software stored on cartridges</li>
        <li>Does <b>not</b> use a more powerful computer as a subcomponent. (ie. a modern microcontroller)</li>
        <li>Is built from parts that can be purchased new today. (ideally for the next five years)</li>
        <li>Can be soldered by hand, by a determined novice.</li>
    </ul>

    The last two points are because I have some half-baked notion of making a kit available and <del>tricking</del> convincing
    others besides myself into developing for and playing games on it. Actually, another reason that I don't want to use a microcontroller
    is that it hides away parts of the design in software. I'd like for the system to be understandable (eventually) just from looking at the
    schematics and the datasheets for the parts. Including a microcontroller (or an FPGA) adds extra steps to understand how the system works,
    as well as extra steps and tooling needed to construct the system.  This would sort of condense into an additional specification for the project.

    <ul>
        <li>The base system doen't contain software. The software comes from the cartridge.</li>
    </ul>


    From these rules and the experiemnts I'd later do, I've settled on these system specs:
    <ul>
        <li>CPU/System:
            <ul>
                <li>WDC65C02S CPU at 3.5MHz</li>
                <li>8KB of general purpose RAM</li>
                <li>32KB address space reserved for the cartridge slot</li>
                <li>Two gamepad/input ports. (Compatible with SEGA Genesis controllers)</li>
            </ul>
        </li>
        <li>Graphics:
            <ul>
                <li>128x128 pixels of display resolution</li>
                <li>256 colors (225 distinct colors)</li>
                <li>Dual framebuffers, switchable at any time</li>
                <li>DMA graphics copy engine running at 14MHz</li>
                <li>32KB dedicated graphics RAM</li>
            </ul>
        </li>
        <li>Audio:
            <ul>
                <li>2 square wave channels</li>
                <li>LFSR noise channel</li>
                <li>PCM sample-looping channel, with 4KB dedicated sample RAM</li>
            </ul>
        </li>
    </ul>
</p>

<p>
    I'm writing this all down pretty far into the project, as I've got a somewhat fragile prototype that connects to old CRT TVs
    and runs a fully-featured action game. My usual work style is to obsessively chase a milestone, reach it at five in the morning,
    and then go crawl into bed to start the next feature in the morning (AKA the next day's late afternoon). Documentation is mostly
    the furthest thing from my mind, but it's somewhat important for a project of this size. So I'm shifting gears to fully focus on
    documenting the work I've already done. Hopefully when I've caught up I can progress both the project and its website at the
    same time, switching the writing from past tense to present progressive.
</p>

<p>
    Clyde H. Shaffer III - August 2020
</p>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>