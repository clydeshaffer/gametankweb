<!-- title = Building a GameTank -->
<!-- thumb = /img/v3/v3-mockup_front_sm.png -->
<?php $title = "Building a GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1> Building a GameTank of your own </h1>

<p>
These instructions will apply for building a GameTank with the June 2021 AV board and the August 2022 Compute board.
</p>
<p>
There may be some revisions based on parts availabilty or to make assembly easier.
</p>

<h2>Parts</h2>

<p>Here's a web tool to generate the Digi-Key and Mouser carts based on your build preferences.</p>
<form action="../digikey_csv.php">
<p>
<input type="checkbox" id="order_exclude_smds" name="order_exclude_smds">
<label for="order_exclude_smds">
    Exclude SMD parts (select if requesting presoldered SMD modules)
</label>
</p>

<p>
<input type="checkbox" id="order_exclude_dprams">
<label for="order_exclude_dprams">
    Exclude Dual-Port RAMs (select if requesting from Shaffer's Secret Stash)
</label>
</p>
If Bulk Add fails then <input type="submit" value="Generate Digi-Key CSV">, save as a text file, and use their CSV upload.
</form>
<p><label for="digikey_order">Digi-Key order: (Paste under "Bulk Add" on <a href="https://www.digikey.com/ordering/shoppingcart">cart page</a>, you might need to refresh the cart page if it reports an error)</label></p>
<textarea id="digikey_order" name="digikey_order" rows="4" cols="40">
</textarea>

<p><label for="mouser_order">Mouser order: (Use the <a href="https://www.mouser.com/Tools/part-list-import.aspx">Part List Importer</a>, requires an account)</label></p>
<textarea id="mouser_order" name="mouser_order" rows="4" cols="40">
</textarea>

<script type="text/javascript" src="../js/ordertool.js"></script>

<p>
Gerber file packages can be found in the <a href="https://github.com/clydeshaffer/gametank/tree/main/Production/Combined">git repo</a>.
You'll need both "cpu-blitter-inputs_2022-08-31.zip" and "signals_2021-06-07.zip" which are the bottom and top boards respectively.
These can be sent to a service like JLCPCB for manufacture. Since the PCB houses tend to have minimum orders though, I'll also be offering these for sale individually.
</p>

<h2>Construction</h2>
<p>
    TODO: Add photos, step-by-step instructions.
</p>
<p>
    To guide assembly, the names of all the integreted circuits are written amidst their footprints. Ideally IC sockets from the DigiKey cart are used
    instead of soldering down the chips directly. The capacitor footprints next to each IC are for the bypass caps. Other passives have their values written
    next to the footprint, or in the case of the electrolytic capacitors the size of the circle should match the capacitor body.
</p>
<p>
    NOTE: The "LS" designations printed on the board are wrong, actually, for every part on the board except for the 74LS07. These should match the HC, HCT, or AHC parts in the order.
</p>

<p>
    NOTE2: The 74HC163 labeled U$6 on the board should actually be the 74AC161 from your parts order. The '163 and '161 are the same except for their reset behavior, which is unused for U$6. AC is used here instead of HC to provide a strong set of main system clock signals.
</p>

<h3>Construction Advice:</h3>
<ul>
    <li>The chip sockets cover up the labels, so print these layout guides or put them on a monitor. (<a href="https://github.com/clydeshaffer/gametank/blob/main/Docs/compute_board_layout_WIP.pdf">motherboard</a>) (<a href="https://github.com/clydeshaffer/gametank/blob/main/Docs/signals_board_layout_WIP.pdf">AV board</a>)</li>
    <li>It's easier to put the shortest components first (the capacitors) so they'll stay in when you flip the board to solder.</li>
    <li>Make sure to match the divots on the chip sockets to the printed outlines.</li>
    <li>For most of the capacitors it doesn't matter which way you insert them. The electrolytic (big cylinder) capacitors are marked with a minus stripe, that should be placed opposite the pad marked with a plus.</li>
    <li>A lead-forming tool comes in handy to bend the chip legs to fit in sockets.</li>
    <li>The 40-pin interconects have one diagonal corner, these should face inwards (ie. towards the center of the board)</li>
    <li>After soldering, inspect your joints to make sure there aren't accidental connections between pins or to vias.</li>
    <li>EXTRA_BUTTON_JACK_1 and _2 are currently unused and can be left unpopulated. </li>
</ul>

<p>
   
</p>

<p>
   
</p>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>