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
    <br>
    The GameTank has dual 128x128 framebuffers which are transmitted as color composite video by a dedicated circuit running in parallel to the CPU.
    The framebuffers store each pixel as a single byte that encodes roughly the hue, saturation, and luminosity components of a color.
    The system also has dedicated hardware, referred to as the "blitter", for copying graphic assets into the framebuffer.
    <br>
    The second 6502 CPU is dedicated to the task of generating audio output and operates using RAM shared by the main CPU. It has no permanent storage, and must be initialized with its own program by the main program on the cartridge.
    This program will provide an interrupt service routine that computes the next audio sample and sends its value to the Digital-to-Analog Converter.
    <br>
    The cartridge port is given control over the entire upper half of the 6502\'s 64K address range.
    At time of writing, the typical cartridge hardware carries 2 megabytes of flash memory and a shift register used for selecting a portion of those 2 megabytes to be exposed to the system bus.
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

    add_section('Blitter Operation', 'blitter', '');
    add_section('Audio Coprocessor', 'audio', '');
    add_section('Gamepads', 'gamepads', '');
    add_section('Versatile Interface Adapter', 'via', '');
    add_section('2MB Flash Cartridges', 'flashcarts', '');

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