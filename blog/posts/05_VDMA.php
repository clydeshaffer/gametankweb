<!-- title = VRAM DMA -->
<!-- thumb = img/vdma/copying.png -->
<?php $title = "VRAM DMA"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>Video RAM DMA</h1>
<h2>Copying pixels but like, really fast</h2>
<center>
    <img width="500" src="../img/vdma/tshell32_161.gif">
</center>

<p>
The Video DMA system of the Gametank could very well be considered the star of the show. While the 6502 CPU is much more flexible and
is responsible for application/gameplay logic, it is not particularly efficient at repeating the same operation en masse. Even the
comparatively small 128x100 resolution of the Gametank output image is a substantial number of bytes to process at 60 frames per second.
</p>
<p>
To establish a baseline on the amount of data to be processed and the required number of cycles to do this using the CPU, let's consider the
case of writing a uniform color to every pixel on the framebuffer. This would consist of writing 12,800 bytes. The quickest way to do this
would be to simply set one of the 6502's registers with either LDA, LDX, or LDY and then executing 12,800 consecutive absolute-addressed STA
(or STX, or STY) opcodes. The code would look like this:
</p>
<pre>
LDA #28 ;light green
STA $4000
STA $4001
STA $4002
...
STA $71FF
STA $7200
</pre>
<p>
This implementation would be of limited practicality due to occupying 38,402 bytes of memory, but has a speed advantage because it skips
the comparison steps that a loop would use. This is a rather extreme example of an optimization technique called "loop unrolling". However,
even with this radical size-vs-speed compromise the process would take 51,202 cycles to execute. To perform this repeatedly at 60Hz would
eat up 3,072,000 cycles per second. While it isn't that hard to build a 6502 computer that runs stably with this much speed (particularly using
WDC's modern chip), remember that this is already an extremely simplified rendering case and there is plenty of other processing a game engine
needs to have time for. Not to mention that this routine already occupies more than half of the available 16-bit address space.
</p>
<p>
The essence of this problem lies in the fact that it takes too many cycles to accomplish this simply data copy task. The unrolled routine above
takes only 4 cycles per byte, but once you try to write a reasonably-sized implementation and account for time spent counting your loops, you're
looking at closer to 26 cycles per byte. Increasing the clock speed would certainly be desirable, but the bigger rewards to be found are hidden
within the puzzle of acheiving a 1 cycle/byte copy method. This is where I was inspired to build dedicated copy hardware that runs independently
of the CPU.
</p>
<p>
DMA, or Direct Memory Access, refers to techniques where hardware besides the primary CPU performs specialized operations on memory.
The Video DMA scheme for the Gametank is relatively straightforward in that it's just a set of counter ICs which generate addresses and write-enable
pulses. Of course, it's in magaging these moving parts that the complexity appears.
</p>
<p>
The VDMA board operates at a higher clock frequency (specifically 4X) than the main CPU, and indeed accomplishes the goal of copying a byte with every
full cycle. The board uses logic tranceiver chips to control access between the main data bus and the Video RAM, as well as a Graphics RAM which contains
sprite and tiles that may be drawn onto the screen. When the DMA engine is not engaged, the CPU can freely access either the V.RAM or the G.RAM. This mode
is useful for filling up the G.RAM, such as by extracting compressed graphics from ROM using the INFLATE algorithm.
</p>
<p>
When the DMA engine is engaged the V.RAM/G.RAM memory space is isolated from the main bus, and the memory mapping for V.RAM/G.RAM is replaced with access
to the DMA control registers. These registers are:
</p>
<ul>
    <li>0x4000 - X coordinate of destination rectangle's top-left corner</li>
    <li>0x4001 - Y coordinate of destination rectangle's top-left corner</li>
    <li>0x4002 - X coordinate of source rectangle's top-left corner</li>
    <li>0x4003 - Y coordinate of source rectangle's top-left corner</li>
    <li>0x4004 - Width of rectangle to copy</li>
    <li>0x4005 - Height of rectangle to copy</li>
    <li>0x4006 - DMA Start (write 1 to this address to initiate a DMA copy)</li>
    <li>0x4007 - Color to draw in solid-color mode</li>
</ul>
<p>
When a copy operation is initiated, the DMA address counters are set to the values of these coordinate registers. The signal that represents whether the
DMA is currently running enables the DMA clock to advancing these counters on the "up" stroke of the clock signal, and asserting the write enable on V.RAM
during the "down" stroke. For each cycle the X counter is incremented while the width counter is decremented. When the width counter reaches zero, the X
and width counters are reloaded from the registers while advancing the Y and height counters. Finally, when the height counter reaches zero the "DMA running"
signal is toggled back into the off state. 
</p>
<p>
In addition, there is a configuration byte at 0x2007 that is accessible regardless of the state of the DMA board. Each bit of this byte
controls a different flag regarding operation of the DMA board.
</p>
<pre>
;DMA flags are as follows
; 1   ->   DMA enabled
; 2   ->   Video out page
; 4   ->   NMI enabled
; 8   ->   G.RAM frame select
; 16  ->   V.RAM frame select
; 32  ->   CPU access bank select (High for V, low for G)
; 64  ->   Enable copy completion IRQ
; 128 ->   Transparency copy enabled (skips zeroes)>
</pre>
<p>
Bit 1 for enabling DMA controls the aforementioned "engaged" state. When this is 0 the CPU accesses either G.RAM or V.RAM and no DMA operations will run.
When it is set to 1 the CPU can only access the DMA parameters.
</p>
<p>
Bit 2 controls which side of the V.RAM double buffer is being sent to the screen, so that
a framebuffer can be prepared without a partial image rendering to the television.
</p>
<p>
Bit 4 controls whether the vertical sync signal generated by the video board is forwarded to the CPU as an interrupt. This is useful for updating game state
at a consistent rate linked to the video framerate.
</p>
<p>
Bit 8 selects which half of the G.RAM is accessed by the CPU or DMA. Similar to the V.RAM's double buffer, the G.RAM can actually hold two pages of 128x128
pixels. A DMA operation can only occur within a single page.
</p>
<p>
Bit 16 selects which side of the V.RAM double-buffer is accessed by the CPU or by the DMA engine. While the expected common use case is for the CPU to
write graphics to G.RAM and then for the DMA to draw to the V.RAM page not currently being displayed, it is also acceptable to use the CPU or DMA to draw
to the currently displayed V.RAM page if needed.
</p>
<p>
Bit 32 selects whether the CPU accesses V.RAM or G.RAM when the DMA is disengaged. (i.e. when bit 1 is clear)
</p>
<p>
Bit 64 sets whether the DMA engine should assert the interrupt line to notify the CPU that it is finished. This is useful when multiple DMA jobs need to be
prepared and submitted without interrupting the one in progress.
</p>
<p>
Bit 128 enables Transparency Mode. When Transparency Mode is enabled, the DMA will not write to V.RAM any bytes equalling zero. 
</p>
<p>
One issue that plagued me on this design (and I hope will be gone on the revised boards currently in transit from the fab) is a glitch that would add
an extra pixel on the bottom left corner of every copy operation. After alternating between obsessing over this problem and ignoring it for months, I
eventually realized that when the DMA copy finishes and the clock is inhibited it rests in the "up" position. This means that when the height counter reaches
zero it introduces one last increment of the X/Y counters. Unfortunately this would be a bit too difficult to fix with a bodge wire, so I'll have to simply
accept its existence on the V1 prototype.
</p>
<p>
Another feature on the incoming V2 prototype I'm looking forward to testing is the ability to flip sprites. In the current prototype sprites can
only be copied as-is as the X/Y counters only go in one direction. This means that separate flipped copies of sprites have to be stored for objects
that can turn around. The new design replaces the up-only X/Y G.RAM counters with up/down counters, which will decrement instead of increment if
the highest bits of width or height are set.
</p>
<p>
The final benefit on the V2 VDMA is that wrapping the image can be turned on or off. The V1 prototype has the quirk that if a wide object is drawn close to
the right side of the screen, the right side of the object which clips offscreen will appear on the left side of the screen. This can be handy in some games,
but it'd useful to make this behavior optional. Thus the high bits of Destination X/Y, previously unused since the screen is only 128x128, now determine
whether drawing is inhibited when the coordinate counters roll over.
</p>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>