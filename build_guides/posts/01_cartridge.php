<!-- title = Building cartridges -->
<!-- thumb = img/v3/v3-mockup_front_sm.png -->
<?php $title = "Building cartridges"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<h1>Building the cartridges</h1>
<h2>EEPROM Cartridges</h2>
<p>
    The EEPROM cartridges are the most limited in storage but the simplest to build. They have only the <a href="https://www.mouser.com/ProductDetail/Microchip-Technology-Atmel/AT28C64B-15PU?qs=2VKgqYuc3OvipbcAuBcLow%3D%3D">EEPROM chip</a>, a bypass capacitor, and the PCB.
</p>
<p>
    The PCB design "EEPROM32card_2021-05-04.zip" in the "Production" folder is compatible with 8K, 16K, and 32K EEPROM chips. (Though only the 8K chips are priced reasonably on Mouser.)
    It is also comptible with EPROM chips by selecting the alternate pinout using the solder jumpers on the back side of the board. The solder jumpers are marked EE for EEPROM and E for EPROM.
    So you should bridge the jumpers between the middle and whichever side matches your chip.
</p>
<h2>Flash Cartridges</h2>
<p>
    The flash cartridge board "FlashCardBanked2M_2021-01-05.zip" holds a 2MB NOR Flash and uses the VIA pins exposed to the cartridge to switch banks.
    It is entirely build from surface-mount parts, but can hold bigger programs and are quicker to load programs onto.
</p>
<p>
    <a href="https://www.mouser.com/ProjectManager/ProjectDetail.aspx?AccessID=2adf4123fa
">Mouser cart containing Flash Cart parts</a>
</p>
<p>
    Assembly is straightforward as none of the parts aside from bypass caps share identical footprints. Although surface mount soldering can be intimidating, these
    parts can be surprisingly forgiving when it comes to placing the parts and applying the solder. With enough patience and flux, the surface tension of the liquid
    solder will help guide the components into the right place.
</p>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>