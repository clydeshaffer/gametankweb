<!-- title = System Stabilized -->
<!-- thumb = img/v3_1/uncased.jpg -->
<?php $title = "System Stabilized!"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>
A Stabilized Hardware Platform
</h1>
<h2>No more software-breaking changes! I hope</h2>
<p>
    August 3rd, 2022
</p>
<img width="500" src="../img/v3_1/uncased.jpg">

<h3> Electronics Changes </h3>

<p>
    Since the last writeup I did indeed solder and test the boards as I said, though I left the web writeups on a bit of a cliffhanger.
    I actually ended up soldering and testing the bottom board twice! Not because it didn't work the first time but because I had some final
    killer features to add to the system. 
</p>
<p>
    Firstly, I expanded the Graphics RAM used as the blitter's source data from 32K to 512K. The orignal 32K GRAM only had room for two screen's
    worth of sprites. After experimenting with the sprite-packing functionality in Aseprite I still found this size was holding the system back.
    So I found a larger SRAM chip and designed a test board to shim into the v3 prototype, in order to verify that it was fast enough to serve as
    the GRAM.
</p>
<p>
    Satisfied with the performance of the new component, I respun the bottom board (which I've lately been calling the Compute Board) to include
    the higher address bits of the expanded memory on a register. This also involved shuffling around the existing video control registers and moving
    some flags to a new "banking" register. All the existing software would break, but it wasn't a problem since I was still the only developer for
    the time being and there were only four programs.
</p>
<p>
    In addition to the expanded GRAM, I also added banking flags to use the extra space on the General-Purpose SRAM chip. I had already been using a 32K
    SRAM for a while due to availability and pricing, but treated it as if it were merely an 8K chip. With the new banking register wired up, programs could
    now switch the entirety of the $0000-$2000 address space between eight banks. There is some care that needs to be taken in software with this approach
    since that range includes the stack, but it's still quite managable.
</p>
<p>
    The expanded general-purpose and graphic memory open up a great many possibilities for games. A fighting game in particular would be well served by the
    generous asset memory for characters with lots of moves. It could also be handy for pseudo 3D effects by storing a prerendered object in several sizes and angles.
</p>

<h3> The Case </h3>
<p>
    Another more obvious addition to the system is the 3D-printed case. This ended up being a bit of a rabbit hole as I played with different ways to build the power and reset
    switches.
</p>
<p>
    One concept I spent a bunch of time on but didn't end up using was to use a reed switch and magnets to integrate a sliding switch into the case. The idea was
    that the switch would be pulled forward to turn the system on. There'd be a halfway point where the power to the system is on, and a magnet would be placed so that the
    switch would stick there. Pulling the switch further would close the reset switch, but there would be no magnet to stick on so it would get pulled back to the middle position.
</p>
<p>
    Instead I decided to go with a more off-the-shelf approach and picked a couple of switches I thought looked cool on DigiKey, though the options were also limited by finding on-off
    and a momentary-off buttons that matched in style and had different colors.
</p>

<h3>Software</h3>
<p>
    After printing the case I switched focus to software and toolchains. I had started Accursed Fiend not too long after building Prototype3 in 2021 but it languished awhile as I
    ran into a difficult bug and life got a bit busy. This year I got back to it and finally figured out I had a STA (STore Accumulator) where I meant to put a STZ (STore Zero),
    causing an essentially random value to be written in a place where it caused an infinite loop. Oops!
</p>
<p>
    Having solved that issue, I got some momentum and built the game out into a short Zelda-like dungeon crawler. In the process, I found a few techniques that can be applied to
    GameTank gamedev at large.
</p>
<p>
    The most important technique was to establish a "draw queue" to minimize the time that the blitter lies idle each frame. Even if the blitter can fill the screen 3.5 times per frame,
    those cycles get spent whether you use them or not! The Draw Queue allows blit operations to be set up while a previous draw call is still running, and the interrupt handler that runs
    on blit completion would read the queue and set up the next blit. In this way a game can take full advantage of the parallel proessing offered by the blitter, and let a frame be drawn
    while continuing to run game logic.
</p>
<p>
    Besides software running on the GameTank itself, the utility program for flashing cartridges also got an update. The previous method involved a NodeJS script with complicated arguments
    that had to be given based on the size of the ROM file. I couldn't even remember the arguments all the time and would just press the up arrow in the terminal window until I got back to the last
    invocation I used for a given project.
</p>
<p>
    So I ended up writing "GameTank Flashing Overhauled", which was a bit overengineered in that I designed a whole state machine framework for serial communications. These efforts were rewarded though,
    as this framework provided building blocks with which I could quickly construct the flashing protocol and add helpful features. One such feature is that if I had my compiler output individual ROM
    banks for a project labeled by a number in their file extension, the flasher program would recognize the bank numbers and write only the needed flash sectors instead of the entire chip. Writing all the
    sectors can take quite some time over the USB serial link, but if a game isn't actually using all 128 sectors then it saves a ton of time to skip the empty parts.
</p>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>