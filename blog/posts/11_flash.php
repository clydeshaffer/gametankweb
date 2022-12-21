<!-- title = Flash Cartridge -->
<!-- thumb = img/flashcart/flash-card.jpg -->
<?php $title = "Flash Cartridge"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>
Flash Cartridge with Movable Window
</h1>
<h2>2MB gives so much room for activities!</h2>

<p>Up until recently the only program storage media I had physically prototyped was the 8KB EEPROM cartridges. These were pretty easy to design and assemble, since all the had to do was adapt the pins of a 28C64 to the cartridge slot. The data was say to address and access since fit well within the memory map of the system.<br><br></p>

<p>However, while developing more content-heavy demos such as Cubicle Knight I found myself bumping hard into this memory limit. Already I had compressed the sprite sheet, tilemaps, and music with zlib but could basically only fit one level in the game. I also now had to deal with the ROM space requirements of the new soundcard, which would need a program loaded into it before it could be of use.&nbsp;<br><br>I had already reserved the upper half of the memory map for hardware residing in the cartridge port, and there are certainly EEPROM chips that can fit into this address space. An AT28C256 for instance would fill the 32KB and have plenty of room for game content. They're a bit more expensive though, and a mere 4x memory growth would be somewhat underwhelming.<br><br>So when I&nbsp;found a flash memory chip on Mouser with a parallel interface and 2 megabytes of space I figured I'd give it a try!</p>

<img width="500" src="../img/flashcart/flash-card.jpg">

<p>
(Important note, the Micro SD card pictured is included only for size comparison! Despite its size, its capacity still dwarfs the new cart by a factor of 16,000)
</p>

<p>Having already saved the cartridge form factor in my Eagle library, I was able to quickly sketch up a design for a 2MB flash cartridge. The flash chip is a&nbsp;M29F160 (or it's Alliance counterpart AS29CF160), which is a NOR flash that defaults to a simple read mode for an 8 or 16 bit bus, selected by a "byte/word" pin level. In the byte mode the chip has 21 address pins, of which I directly control 14 with the 6502 bus. The rest get their values either from a shift register, or a buffer chip depending on whether A14 is high or low. If A14 is high, the system is possibly accessing the interrupt vectors and so addresses the very top of flash memory.</p>

<p>The shift register is accessed by a "SPI interface" that's actually just four of the 6522 VIA's pins on port A. At any time the CPU can shift out an address, and move the 16KB window mapped from $8000 to $BFFF. I'm still thinking of different techniques to take advantage of this in software, but one convenient way to use it is to put game engine code in the fixed window and put content data into the other pages such that the same 16-bit pointer can be used to access a certain type of info on each page. (Such as keeping the music, tilemaps, graphics for a level under 16KB and then giving each level its own page.)<br><br>To support this new flash cartridge, I also built a new cartridge programmer tool. Unlike the previous two where a shift register or a counter was used to expand the IO pins of an Arduino Nano (clone), this time I implemented it as a shield for an Arduino Mega to reduce complexity and increase flexibility. To allow for even faster programming, I aligned the address and data pin connections of the cartridge connector to the port registers of the ATmega2560. Having done this, my programmer firmware would be able to put a byte on the data bus simply by storing it in the port register variable. Ditto for each half of the 16 bit address.&nbsp;</p>

<img width="500" src="../img/flashcart/flash-prog.jpg">

<p>Quite handily, this new programmer can write data 15 times faster than the old one. The old cartridges used to take almost two minutes to flash, but now only take about eight seconds. Of course, on the new boards this 15x speedup is countered by the 256x increase in data to send and filling the whole chip with data takes half an hour. Fortunately this flash chip also has a command to erase only a single sector at a time, which makes it quick to update individual segments of code or content.</p>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>