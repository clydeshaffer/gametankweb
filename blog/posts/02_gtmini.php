<!-- title = Cartridge System -->
<!-- thumb = /img/gt_mini/gt_mini_running.jpeg -->
<?php $title = "Cartridge System"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>How Will The Cartridges Work?</h1>
<h2>and why's it called the GameTank?</h2>
<center>
    <img width="500" src="../img/gt_mini/gt_mini_running.jpeg">
</center>

<p>
    After creating the Steamed RAMs prototype, I wanted to make it a bit easier to switch images so it seemed like a good time as any to
    experiment with making cartridges. Admittedly there might actually have been better times later in the development of the GameTank
    that I could have come up with the cartridge pinout, but what I came up with has worked decently well so far and I might not have to
    revise it that much.
</p>
<p>
    I wanted the cartridges to host a ROM chip and connect using a card-edge connector like in olden times. But I also wanted to have the
    possiblity to use the cartirdge port as an expansion port, or to embed more than just ROM in a cartridge. Some Famicom games, for instance,
    brought extra audio hardware of their own which would be mixed into the output alongside the console's own generated audio. To support stuff
    like this, I designed the cartridge port to include all address lines (not just the ones used by an 8K ROM), the IRQ line, two pins to connect
    extra audio from the cartridge, the system clock, and two pins for connecting I2C devices I might theoretically put in a cartridge.
</p>
<p>
    Here's the cartridge pinout copied from my notebook:
    <br>
    <center>
    <table>
        <tr>
            <th>Back</th>
            <th>Front</th>
        </tr>
        <tr>
            <td>Ground</td>
            <td>Phi2 (System Clock)</td>
        </tr>
        <tr>
            <td><span style="text-decoration: overline">Reset</span></td>
            <td>IO2</td>
        </tr>
        <tr>
            <td>Ready</td>
            <td>IO1</td>
        </tr>
        <tr>
            <td>A14</td>
            <td>IO0</td>
        </tr>
        <tr>
            <td>IO3</td>
            <td>A0</td>
        </tr>
        <tr>
            <td>IO4</td>
            <td>A1</td>
        </tr>
        <tr>
            <td>IO5</td>
            <td>A2</td>
        </tr>
        <tr>
            <td>IO6</td>
            <td>A3</td>
        </tr>
        <tr>
            <td>IO7</td>
            <td>A4</td>
        </tr>
        <tr>
            <td><span style="text-decoration: overline">Cartridge Enable</span></td>
            <td>A5</td>
        </tr>
        <tr>
            <td>A10</td>
            <td>A6</td>
        </tr>
        <tr>
            <td><span style="text-decoration: overline">Output Enable</span></td>
            <td>A7</td>
        </tr>
        <tr>
            <td>A11</td>
            <td>A12</td>
        </tr>
        <tr>
            <td>A9</td>
            <td>I2C Clock</td>
        </tr>
        <tr>
            <td>A8</td>
            <td>I2C Data</td>
        </tr>
        <tr>
            <td><span style="text-decoration: overline">IRQ</span></td>
            <td>Audio IN</td>
        </tr>
        <tr>
            <td><span style="text-decoration: overline">Write Enable</span></td>
            <td>Audio OUT</td>
        </tr>
        <tr>
            <td>A13</td>
            <td>VCC</td>
        </tr>
    </table>
    </center>
    <br>
    If some of the address numbering looks like it's all over the place, it's because I was somewhat adopting the positioning
    from the pins on the ROM chip I'm using, the AT28C64. I don't actually know why it's like that. I designed PCBs for using
    this pinout and that particular ROM chip, along with 3D printed cases. To program it, I built an Arduino-based cartridge programmer
    that would connect to my PC over USB and load data using a specially made command line utility.
</p>

<center>
    <img width="500" src="../img/gt_mini/cart.jpeg">
    <img width="500" src="../img/cart-prog.jpeg">
</center>

<p>
    To try out this cartridge pinout I decided to extend my previous work by replacing the ROM chip in the schematic with a cartridge connector,
    and making a new board. Also this board would use surface-mount components because I wanted to try working with those. After ordering the board
    I also designed a 3D printed case for it.
</p>

<center>
    <img width="500" src="../img/gt_mini/gt_mini_box.PNG">
</center>

<p>
    This looked a bit boring though, and I wanted to take the opportunity to embellish the design with a few <i>subtle flourishes</i>.
</p>

<center>
    <img width="500" src="../img/gt_mini/gt_mini_model.PNG">
</center>

<p>
    Much better. So basically this is when the game console project gained the GameTank name and this random design was the only reason for it.
</p>

<center>
    <img width="500" src="../img/gt_mini/gt_mini.jpeg">
    <img width="500" src="../img/gt_mini/gt_mini_open.jpeg">
</center>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>