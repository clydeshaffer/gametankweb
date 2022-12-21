<!-- title = Toolchain -->
<!-- thumb = img/toolchain/spritesheet.PNG -->
<?php $title = "Development Toolchain"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>Development Toolchain</h1>
<h2>Handy tools to actually write software for this hardware</h2>
<center>
    <img width="500" src="../../pikaconstruction.gif">
</center>

<p>
    This page mostly just lists off some programs (and one physical tool) that I've used in writing programs for the GameTank.
    For an example project you can check out <a href="https://github.com/clydeshaffer/CubicleKnight">Cubicle Knight</a> which
    is a platforming game that runs on the GameTank. In particular the Makefile will show how some of these programs are used.
</p>

<h2>Existing tools</h2>

<h3>VASM</h3>
<p>
    <a href="http://www.compilers.de/vasm.html">VASM</a> is the assembler I use to produce executable binaries that I flash to EEPROMs.
    I don't have any particular reason that I use this assembler over any other, but it does support WDC's 6502 and outputs a ROM file that
    can be used by the emulator or flashed to a cartridge without further modification. 
</p>
<h3>zlib6502/Zopfli</h3>
<p>
    Graphics for a video game can actually take up quite a bit of space. A full screen's worth of pixels is actually more data than the smallest
    GameTank cartridge can hold, and half of the largest parallel EEPROM I've considered building a cartridge board for. Therefore it's highly
    useful to be able to store graphics on the cartridge in compressed form, and decompress it at the start of a game.
    While it's easy to compress data in many different ways on a PC, some decompression routine is needed that can run on the console.
    The <a href="https://github.com/pfusik/zlib6502">zlib6502</a> library by Piotr Fusik is an implementation of the INFLATE algorithm for the 6502
    processor. It has a realtively low footprint and resource requirements, and is simple to include into an existing program thanks to the ability
    to configure (at compile time) the memory locations it uses. Along with the compression utility <a href="https://github.com/google/zopfli">Zopfli</a>,
    I was able to pack the 16,384 bytes of sprite and tile data for Cubicle Knight into only 2,345 bytes on the EEPROM.
</p>
<h2>Self-made tools</h2>
<h3>GameTank Emulator</h3>
<p>
    The <a href="https://github.com/clydeshaffer/gametankemulator">emulator</a> should probably get its own writeup page eventually. One of the challenges in cross-developing software for a cartrige-based system
    is the time it takes to transfer the compiled program to the EEPROM chip. Any modern programmer (myself included) that is used to quickly cycling through
    [edit, compile, test] would be annoyingly hindered if they have to wait a long time to transfer the program.
</p>
<p>
    My solution to this problem was to write a simple emulator program that could execute the code in a compiled ROM file and mimic the functions of the game hardware.
    The emulator is written in C++, uses SDL, and can be compiled for Windows, OSX, and Linux. It currently includes most of the functions of the V1 prototype.
    Going forward I would like to add certain features that would make debugging easier; such as a memory monitor, save states, or a viewer for the off-screen
    graphics buffers. However, it already has proven useful in being able to rapidly iterate on game design and checking the effects of changes.
</p>
<h3>MIDI converter</h3>
<p>
    The MIDI converter was written during the devlopment of Cubicle Knight but will probably see use in other GameTank games, and eventually morph
    into a more user-friendly tool. The music format is actually defined not by the hardware design, but by the playback routine written in the
    Cubicle Knight code. The format is designed to store long music passages somewhat efficiently, each byte alternates between representing a note index
    and a note length measured in 60Hz frames. During each frame update, the game decements the note length counter and loads the next note/duration when
    that counter reaches zero. Cubicle Knight only uses the two square wave channels for music playback, so the conversion script reads the first two
    tracks of the input MIDI file for conversion. Because each track is monophonic, the script also terminates any previous note when a new note is played.
</p>
<p>
    One of the tricky nuances in writing this converter was dealing with fractional frame delays, which result from scaling MIDI timings into units of
    60Hz frames. To account for this, the decimal part of computed durations is stored in an accumulator. On a later note or rest, if the accumulated
    fractional frames are greater than or equal to 1, the integer part of that accumulator is added to the note.
</p>
<h3>Cartridge Flasher</h3>
<p>
    This tool was previously mentioned in the Cartridge Format writeup. The Cartridge Flasher uses an Arduino Nano
    clone and shows up to the host PC as a COM port (on windows) or a tty in /dev (on Linux). There were actually two version of this device,
    one with a cartridge slot and the earlier one with a ZIF socket to program EEPROM chips directly. The ZIF version is still useful in cases where
    the EEPROM chip isn't permanently installed in a cartridge, or is not being used for a cartridge at all on some other circuit. The cartridge-based
    tool is used mainly for the surface-mount version of the cartridge, where the EEPROM chip cannot be easily removed from the board to program externally.
</p>
<p>
    The cartridge-based flasher has one "feature" that I'll probably not include in the next version, though. In order to make construction quicker and
    potentially use a single-sided PCB, I opted to use a 4040 counter instead of shift registers to generate the output address. Furthermore, I optimized
    the connections to the address pins for simpler routing over marching the address space in order. As a consequence, the file being flashed to the cartridge
    must be run through a scrambler program that rearranges the bytes to match the order that this flasher visits the ROM addresses. Next time I'm probably
    just going to use shift registers, which will let the Arduino visit addresses in any order I want. Or even allow for partial updates.
</p>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>