<?php
    $sections = [];

    function anchor($title, $url) {
        return "<a href=\"" .  $url . "\">" . $title . "</a>";
    }

    function anchor_id($title, $id) {
        return "<a id='$id'>$title</a>";
    }

    function tag($t, $content) {
        return "<" . $t . ">" . $content . "</" . $t . ">";
    }

    function add_section($title, $anchor, $content) {
        global $sections;
        if($content == '') {
            $sections[] = (array("title"=>$title, "anchor"=>$anchor, "body"=>'Under construction'));
        } else {
            $sections[] = (array("title"=>$title, "anchor"=>$anchor, "body"=>$content));
        }
    }

    function emit_table_of_contents() {
        global $sections;
        foreach($sections as $section) {
            echo tag(
                "li",
                anchor(
                    $section["title"],
                    '#' . $section["anchor"]
                )
            );
        }
    }

    function emit_section_contents() {
        global $sections;
        foreach($sections as $section) {
            echo tag("div",
                anchor_id(tag("h3", $section["title"]), $section["anchor"]) .
                tag("p", $section["body"])
            );
        }
    }

    add_section('System Overview', 'system', '
    The GameTank is based on the W65C02S from WDC. It features two of these processors as well as the W65C22 Versatile Interface Adapter ("VIA").
    The system also has composite video output, mono audio output, two front-facing controller ports, a 14-pin rear-facing accessory header, and a top-loading 36-pin cartridge port.
    As a 6502-based system the boot behavior is for the CPU to read a memory address from 0xFFFC and 0xFFFD and then begin executing code from that address.
    The VIA controls twelve general-purpose IO pins on the rear accessory port, and four pins on the cartridge port.
    <br><br>
    The GameTank has dual 128x128 framebuffers which are transmitted as color composite video by a dedicated circuit running in parallel to the CPU.
    The framebuffers store each pixel as a single byte that encodes roughly the hue, saturation, and luminosity components of a color.
    The system also has dedicated hardware, referred to as the "Blitter", for copying graphic assets into the framebuffer.
    Separate from both the framebuffer RAM and general-purpose RAM is Sprite RAM. The Blitter strictly copies <em>from</em> Sprite RAM <em>to</em> the framebuffer.
    <br><br>
    The second 6502 CPU is dedicated to the task of generating audio output and operates using RAM shared by the main CPU. It has no permanent storage, and must be initialized with its own program by the main program on the cartridge.
    This program will provide an interrupt service routine that computes the next audio sample and sends its value to the Digital-to-Analog Converter.
    <br><br>
    The cartridge port is given control over the entire upper half of the 6502\'s 64K address range.
    At time of writing, the typical cartridge hardware carries 2 megabytes of flash memory and a shift register used for selecting a portion of those 2 megabytes to be exposed to the system bus.
    <br>
    ');

    add_section("Memory Map", "memorymap", '
    <table>
        <thead>
        <tr>
            <th>Addr</th>
            <th>Use</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>$0000 - $1FFF</td>
            <td>General purpose RAM</td>
        </tr>
        <tr>
            <td>$2000-$2007</td>
            <td><a href="#registers">System control registers</a></td>
        </tr>
        <tr>
            <td>$2008 - $2009</td>
            <td>Gamepads</td>
        </tr>
        <tr>
            <td>$2800 - $280F</td>
            <td>Versatile Interface Adapter (GPIOs, Timers)</td>
        </tr>
        <tr>
            <td>$3000 - $3FFF</td>
            <td>Audio RAM</td>
        </tr>
        <tr>
            <td>$4000 - $7FFF</td>
            <td>Framebuffer, Sprite RAM, Blitter registers</td>
        </tr>
        <tr>
            <td>$8000 - $FFFF</td>
            <td>Cartridge slot</td>
        </tr>
        </tbody>
        </table>
    ');


    add_section("System Registers", "registers", '
    <table>
    <thead>
    <tr>
        <th>Addr</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>$2000</td>
        <td>Write 1 to reset audio coprocessor</td>
    </tr>
    <tr>
        <td>$2001</td>
        <td>Write 1 to send NMI to audio coprocessor</td>
    </tr>
    <tr>
        <td>$2005</td>
        <td>Banking Register</td>
    </tr>
    <tr>
        <td>$2006</td>
        <td>Audio enable and sample rate</td>
    </tr>
    <tr>
        <td>$2007</td>
        <td>Video/Blitter Flags</td>
    </tr>
    <tr>
        <td>$2008</td>
        <td>Gamepad 1 (Left port)</td>
    </tr>
    <tr>
        <td>$2009</td>
        <td>Gamepad 2 (Right port)</td>
    </tr>
    </tbody>
    </table>
    <br>
    The registers from $2000 through $2007 are write-only. The two gamepad registers are read-only.

    ');

    add_section("Banking Register", 'bankreg', '
    The Banking Register controls certain memory mapping behaviors within the console hardware.
    <br><br>
    <table>
    <thead>
    <tr>
        <th>Bitmask</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>00000111</td>
        <td>Select the active Sprite RAM page</td>
    </tr>
    <tr>
        <td>00001000</td>
        <td>Select which framebuffer to read/write/blit</td>
    </tr>
    <tr>
        <td>00010000</td>
        <td>Clip blits on the left/right screen edges</td>
    </tr>
    <tr>
        <td>00100000</td>
        <td>Clip blits on the top/bottom screen edges</td>
    </tr>
    <tr>
        <td>11000000</td>
        <td>Select general purpose RAM page</td>
    </tr>
    </tbody>
    </table>
    <br>
    <p>The active Sprite RAM page applies to both CPU access of Sprite RAM and blit operations.</p>
    <br>
    <p>Clipping blits refers to DMA draw operations that would cross the boundary of the screen. By default the drawing will wrap around to the other side of the screen, enabling the respective clip bit will prevent this behavior.</p>
    <br>
    <p>The banking for general purpose RAM includes the zero page and 6502 stack page, so you\'ll need to restore the RAM bank before returning from a subroutine that changes the RAM page.</p>
    <br>
    ');

    add_section("Video and Blitter Flags", "dmaflags", '
    <table>
    <thead>
    <tr>
        <th>Bitmask</th>
        <th>Name</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>00000001</td>
        <td>DMA_ENABLE</td>
        <td>Enable/disable the Blitter</td>
    </tr>
    <tr>
        <td>00000010</td>
        <td>DMA_PAGE_OUT</td>
        <td>Select framebuffer page sent to TV</td>
    </tr>
    <tr>
        <td>00000100</td>
        <td>DMA_NMI</td>
        <td>Enable NMI signal generated by VBlank</td>
    </tr>
    <tr>
        <td>00001000</td>
        <td>DMA_COLORFILL_ENABLE</td>
        <td>Use solid colors for blits instead of sprites</td>
    </tr>
    <tr>
        <td>00010000</td>
        <td>DMA_GCARRY</td>
        <td>Set 0 to repeat 16x16 tiles on blit draws</td>
    </tr>
    <tr>
        <td>00100000</td>
        <td>DMA_CPU_TO_VRAM</td>
        <td>0 means CPU accesses Sprite RAM<br>1 means the CPU access the framebuffer</td>
    </tr>
    <tr>
        <td>01000000</td>
        <td>DMA_IRQ</td>
        <td>Enable IRQ signal when blits finish</td>
    </tr>
    <tr>
        <td>10000000</td>
        <td>DMA_OPAQUE</td>
        <td>Set 1 to disable transparency</td>
    </tr>
    </tbody>
    </table>
    <br>
    <p>
        DMA_ENABLE must be set to access blitter registers and perform blitter operations. DMA_ENABLE must be clear for the CPU to access Sprite RAM or the framebuffer directly.
        <br>
        NOTE: Modifying DMA_ENABLE or any blitter register is not currently modeled by the GameTank Emulator.
    </p>
    <br>
    <p>
        DMA_PAGE_OUT can cause screen tearing if you use it outside of the TV\'s blanking period. Screen tearing is not currently modeled by the GameTank Emulator.
    </p>
    <br>
    <p>
        DMA_NMI controls whether the NMI interrupt will be called when the video hardware sends a sync pulse to the TV. This signal happens approximately 60 times per second.
    </p>
    <br>
    <p>
        DMA_COLORFILL_ENABLE when set will draw rectangles of a solid color.
    </p>
    <br>
    <p>
        DMA_GCARRY controls whether the sprite coordinate counters in the blitter will increment the upper four bits when the lower four bits roll over. Carrying is required to draw an image larger than 16x16, but turning it off can be used to repeat a 16x16 tile over a larger area.
    </p>
    <br>
    <p>
        DMA_CPU_TO_VRAM only applies when DMA_ENABLE is clear. This flag determines whether the CPU accesses the Sprite RAM or the Framebuffer RAM. These accesses are further controlled by the Sprite Page select and Framebuffer select bits in the Banking Register.
    </p>
    <br>
    <p>
        DMA_IRQ controls whether an IRQ interrupt will be called when a blit operation completes. Unlike NMI which is edge-sensitive, IRQ is level-sensitive. Before an IRQ service routine returns, the IRQ condition should be cleared or else the routine will immediately be called again. The IRQ condition will be cleared if 0 or 1 is written to the blit start register.
    </p>
    <br>
    <p>
        DMA_OPAQUE controls whether the blitter draws with transparency. When DMA_OPAQUE is zero the blitter will not write any zero-valued bytes to the framebuffer.
    </p>
    <br>
    ');

    add_section('Blitter Operation', 'blitter', '
    The Blitter is an arrangment of logic gates, registers, and counters that may be used to copy rectangular areas up to 127x127 pixels from Sprite RAM to the framebuffer. This copy runs in parallel to CPU execution and copies at a rate of 1 pixel per CPU clock cycle.
    There are seven registers used for preparing a copy operation and an additional address used for initiating the copy operation. If the DMA_IRQ flag is set, the Blitter will assert an IRQ signal when a copy operation completes.
    <br>
    In order to access these registers, DMA_ENABLE must be set. Modifying these registers during a copy operation is possible, but not presently modeled in the GameTank Emulator.
    <br><br>
    When the system is powered on the contents of Sprite RAM are, for all intents and purposes, random. Before drawing anything useful the CPU will need to copy graphics into this memory while the Blitter is disabled.
    <br><br>
    <table>
    <thead>
    <tr>
        <th>Addr</th>
        <th>Name</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>$4000</td>
        <td>VX</td>
        <td>X coordinate in framebuffer of left column of drawing</td>
    </tr>
    <tr>
        <td>$4001</td>
        <td>VY</td>
        <td>Y coordinate in framebuffer of top row of drawing</td>
    </tr>
    <tr>
        <td>$4002</td>
        <td>GX</td>
        <td>X coordinate in Sprite RAM for first column of source data</td>
    </tr>
    <tr>
        <td>$4003</td>
        <td>GY</td>
        <td>Y coordinate in Sprite RAM for first row of source data</td>
    </tr>
    <tr>
        <td>$4004</td>
        <td>WIDTH</td>
        <td>Width of drawing operation. Bit 7 controls horizontal flipping.</td>
    </tr>
    <tr>
        <td>$4005</td>
        <td>HEIGHT</td>
        <td>Height of drawing operation. Bit 7 controls vertical flipping.</td>
    </tr>
    <tr>
        <td>$4006</td>
        <td>START</td>
        <td>Write 1 to clear IRQ and begin a blit operation. Write 0 to clear IRQ without starting a blit.</td>
    </tr>
    <tr>
        <td>$4007</td>
        <td>COLOR</td>
        <td>Value to use for Color Fill Mode. Only used when DMA_COLORFILL_ENABLE is set.</td>
    </tr>
    </tbody>
    </table>
    <br>
    <p>
    A typical blitting operation consists of setting each of the paramter registers, and then writing 1 to the START register.
    However, these parameters are not modified by the Blitter so if you are performing repetitive drawings that have common parameters you can skip setting the reused values for increased performance.
    </p>
    <br><br>
    <p>
    During a blit the parameters should generally be left alone. If you know the drawing is small you can simply wait by performing some other work on the CPU.
    For larger or variable sized drawings you can use an IRQ handler to set up blits. You can also execute a WAI ("wait") opcode that will pause the CPU until the next interrupt of any kind occurs.
    You lose out on parallelism this way, but it makes things very simple. For consecutive small drawings the overhead of managing a drawing queue can waste more time than simply waiting for the blitter to finish.
    </p>
    <br><br>
    <p>
    Setting the higest bit of WIDTH or HEIGHT will invert the output of the GX or GY counters. This is used for drawing a horizontally and/or vertically flipped version of a sprite, though it requires some modification of the GX and GY register values to use for this purpose.
    </p>
    <br><br>
    <p>
    Values of VX and VY outside of the 128x128 resolution are valid. If CLIP_X or CLIP_Y are set in the banking buffer then blit writes that fall outside the 0-127 range will simply not be drawn.
    </p>
    <br><br>
    <p>
    Sprite RAM can be thought of as a set of eight 256x256 sheets, selected using the Banking Register. Therefore any value for GX and GY in the full 0-255 range is valid and practical.
    </p>
    <br><br>
    <p>
    The values of GX and GY last used by the Blitter will also influence which part of Sprite RAM the CPU can access in addition to the Banking Register. The video section of the memory map is only big enough for a 128x128 region.
    So the quadrant of Sprite RAM available to the CPU is determined by the most significant bit in the Sprite RAM coordinate counters.
    Typically these would be set before loading sprites by running a single-pixel blit operation copying from the target quadrant to an off-screen portion of the framebuffer.
    </p>
    <br><br>
    ');

    add_section('Audio Coprocessor', 'audio', '
    All audio on the GameTank is produced by a subsystem called the Audio Coprocessor. It is essentially a minimal 6502-based computer enclosed within the larger system.
    This subsystem has 4 kilobytes of RAM, all of which is accessible to the main system at any time. Due to its simplicity, the Audio Coprocessor runs at four times the clock speed of the main system.
    While the Audio Coprocessor is enabled, IRQ signals will be asserted by a configurable counter. The audio sample rate register at $2006 will set the rate of these IRQ signals with its lower seven bits.
    The highest bit determines whether the Audio Coprocessor is enabled or suspended. It is a good idea to suspend the Audio Coprocessor while initializing Audio RAM.
    <br><br>
    From the perspective of the Audio Coprocessor, a program should only treat the memory range from $0000 through $0 through $0FFF as available. Any reads or writes will be wrapped around this range.
    <br>
    However, any writes to $8000 will additionally be mirrored to the DAC buffer. The value stored in the DAC buffer will be copied to the DAC output simultaneously with the next IRQ event.
    <br><br>
    The typical Audio Coprocessor program consists of a main loop that does very little, and a long IRQ handler that computes the next audio sample before writing it to the DAC buffer.
    ');
    add_section('Gamepads', 'gamepads', '
    The GameTank uses two Genesis-style controller ports on the front of the console. The 9-pin controller ports include a "select" line that tells the controller which button states should be connected to the output.
    Each controller port will alternate this "select" value on consecutive reads. Additionally reading one controller port will reset the "select" value on the other controller port, to allow placing it into a known state before reading.
    <br><br>
    In other words: Before reading controller port 1, read controller port 2 and discard the result. Then the next two reads to controller port 1 will contain the full state of a standard controller.
    <br><br>
    This does mean that 6-button Genesis controllers may also be readable but it hasn\'t been tested yet.
    ');

    add_section('Versatile Interface Adapter', 'via', '
    The GameTank includes a 6522 Versatile Interface Adapter, or "VIA" for short. This chip is primarily used for controlling the GPIO pins on the cartridge port and on the accessory header.
    <br><br>
    <table>
    <thead>
    <tr>
        <th>Addr</th>
        <th>Name</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>$2800</td>
        <td>ORB/IRB</td>
        <td>Output/Input Register B</td>
    </tr>
    <tr>
        <td>$2801</td>
        <td>ORA/IRA</td>
        <td>Output/Input Register A. Bits 0, 1, 2, and 7 are exposed to the cartridge port.</td>
    </tr>
    <tr>
        <td>$2802</td>
        <td>DDRB</td>
        <td>Data Direction Register B</td>
    </tr>
    <tr>
        <td>$2803</td>
        <td>DDRA</td>
        <td>Data Direction Register A</td>
    </tr>
    <tr>
        <td>$2804</td>
        <td>T1C-L</td>
        <td>T1 Low-Order Latches (Write) or Counter (Read)</td>
    </tr>
    <tr>
        <td>$2805</td>
        <td>T1C-H</td>
        <td>T1 High-Order Counter</td>
    </tr>
    <tr>
        <td>$2806</td>
        <td>T1L-L</td>
        <td>T1 Low-Order Latches</td>
    </tr>
    <tr>
        <td>$2807</td>
        <td>T1L-H</td>
        <td>T1 High-Order Latches</td>
    </tr>
    <tr>
        <td>$2808</td>
        <td>T2C-L</td>
        <td>T2 Low-Order Latches (Write) or Counter (Read)</td>
    </tr>
    <tr>
        <td>$2809</td>
        <td>T2C-H</td>
        <td>T2 High Order Counter</td>
    </tr>
    <tr>
        <td>$280A</td>
        <td>SR</td>
        <td>Shift Register</td>
    </tr>
    <tr>
        <td>$280B</td>
        <td>ACR</td>
        <td>Auxiliary Control Register</td>
    </tr>
    <tr>
        <td>$280C</td>
        <td>PCR</td>
        <td>Peripheral Control Register</td>
    </tr>
    <tr>
        <td>$280D</td>
        <td>IFR</td>
        <td>Interrupt Flag Register</td>
    </tr>
    <tr>
        <td>$280E</td>
        <td>IER</td>
        <td>Interrupt Enable Register</td>
    </tr>
    <tr>
        <td>$280F</td>
        <td>ORA/IRA</td>
        <td>Same as ORA/IRA but without "handshake"</td>
    </tr>
    </tbody>
    </table>
    <br>
    NOTE: Not all of these are currently modeled in the GameTank Emulator as I\'ve primarily been using ORA for cartridge banking. If you have ideas to try with other VIA registers feel free to bring them up on the Discord and motivate adding them to the emulator!
    <br>
    See the WDC <a href="https://www.westerndesigncenter.com/wdc/documentation/w65c22.pdf">datasheet</a> for more specifics on this chip\'s behavior.
    <br><br>
    See the section on 2MB Flash Cartridges for information on how this device is used to access cartridge ROM banks.
    <br><br>
    The GameTank Emulator uses the rear accessory port to activate profiling timers for debugging program performance.
    ');

    add_section('2MB Flash Cartridges', 'flashcarts', '
    The currently available cartridge designs are the 8KB EEPROM cartridges and the 2MB NOR Flash cartridges. The 8KB EEPROM cartridges fit neatly into the 32K available through the cartridge port, and thus don\'t leave much to talk about.
    <br>
    The 2MB Flash cartridges present the issue of how to access more than 32 kilobytes through a 32 kilobyte window. A banking system is thus used to address this large memory span. On the cartridge board is a shift register that is accessed through
    the lowest three bits of VIA Output Register A.
    <br><br>
    <table>
    <thead>
    <tr>
        <th>Bit</th>
        <th>Use</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>0</td>
        <td>CLOCK</td>
    </tr>
    <tr>
        <td>1</td>
        <td>DATA</td>
    </tr>
    <tr>
        <td>2</td>
        <td>LATCH</td>
    </tr>
    </tbody>
    </table>
    <br>
    The shift register is written with repeated writes to ORA. Each time CLOCK goes from 0 to 1, the value of DATA is pushed into the shift register.
    <br>
    When LATCH goes from 0 to 1, the value of the shift register will take effect.
    <br><br>
    On the 2MB cartridge only the lowest seven bits in the shift register are considered. For memory reads in the range $8000 through $BFFF, the bits from the shift register will be used as the highest address bits on the NOR Flash.
    This provides a moveable window into the Flash memory with 128 possible positions.
    <br><br>
    To allow for deterministic boot behavior, memory reads in the range $C000 through $FFFF will <em>always</em> map to the same memory as Bank 127. This ensures that the 6502 CPU will be able to retrieve the intended RESET, IRQ, and NMI pointers
    no matter the state of the cartridge banking register.
    <br<br>
    <h3>NOTE for compatibility with future cartridges:</h3>
    Another cartridge under development adds battery-backed RAM, and makes use of the 8th shift register bit. When the 8th bit is zero, reads (and writes) will be mapped to the cartridge RAM.
    Therefore it is recommended to use bank numbers 128-255 in your code, instead of 0-127. On the RAM-less design these ranges are equivalent, so the high bit being set will not cause an error.
    ');

?>

<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
        <h1>Programmer's Manual</h1>

            <h2>Table of contents:</h2>
    <ul>
        <?php emit_table_of_contents(); ?>
    </ul>
    <?php emit_section_contents(); ?>


<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>