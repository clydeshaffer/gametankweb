<!-- title = CPU Board -->
<!-- thumb = /build_guides/img/cpu_board/annotated/053_VIA.jpg -->
<?php $title = "Building a GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<?php include '../includes/manual_templates.php'?>

<h1>The CPU Board</h1>
<h3>Photos by @dwbrite</h3>

<?php

    buildstep('Before we begin', 
        array(
            'This page will walk you through building the CPU Board, which holds the main system bus, blitter, cartridge ports, gamepad ports, and GPIO ports.',
            'The power board is also attached to the CPU board.',
            'In general we\'ll be placing the shorter components first.',
            'It will help to have a flat board handy, about the same size as the PCB. This can be used to keep parts from falling out as you flip the whole board to solder components.'
        ),
        array(
            '../img/cpu_board/annotated/000_cpu_board.jpg'
    ));

    buildstep('Bypass Capacitors', 
        array(
            'The bypass capacitors smooth out the power supply to each chip.',
            'Every IC gets a 0.1uF capacitor next to it.',
            'There should be 63 of these'
        ),
        array(
            '../img/cpu_board/annotated/001_bypass_caps.jpg'
    ));

    buildstep('Resistors', 
        array(
            '7 x 3.3k resistors (Orange Orange Red)',
            '150 Ohm resistor next to LED1',
            'Polarity doesn\'t matter but they should be nice and close to the board to leave room for nearby components.',
            'After soldering and trimming resistors, set a couple of the trimmed leads aside to help with a later step.'
        ),
        array(
            '../img/cpu_board/annotated/002_3_3k_resistors.jpg',
            '../img/cpu_board/annotated/003_150_resistor.jpg',
    ));

    buildstep('Big Capacitors', 
        array(
            '220 Ohm capacitor near the power entry pads',
            'Be sure to align the stripe indicating the cathode (negative side) with the pad that does NOT have a "plus" + symbol',
        ),
        array(
            '../img/cpu_board/annotated/004_220_capacitor.jpg',
    ));

    buildstep('DIP Sockets (Prelude)',
    array(
        'The next several steps will insert sockets for chips.',
        'The "wood board" method will still help if the sockets are still the tallest thing on the board.',
        'Otherwise, you can bend the socket pins outward to help them stay in the holes before soldering.',
        'BE SURE TO match the divot on the socket to the divot on the printed socket outline!'
    ),
    array(
        '../img/av_board/annotated/013_socket_legs.jpg'
    ));

    buildstep('DIP14 Sockets', 
        array(
            '18 sockets with 2 rows of 7 pins',
        ),
        array(
            '../img/cpu_board/annotated/005_dip14.jpg',
    ));

    buildstep('DIP16 Sockets', 
        array(
            '22 sockets with 2 rows of 8 pins',
        ),
        array(
            '../img/cpu_board/annotated/006_dip16.jpg',
    ));

    buildstep('DIP20 Sockets', 
        array(
            '14 sockets with 2 rows of 10 pins',
        ),
        array(
            '../img/cpu_board/annotated/007_dip20.jpg',
    ));

    buildstep('DIP28 Socket', 
        array(
            'Just one socket with 2 rows of 14 pins',
        ),
        array(
            '../img/cpu_board/annotated/008_dip28.jpg',
    ));

    buildstep('Big Sockets', 
        array(
            '2 wide sockets with 2 rows of 20 pins',
            '1 wide socket with 2 rows of 16 pins',
        ),
        array(
            '../img/cpu_board/annotated/009_big_sockets.jpg',
    ));

    buildstep('Controller Ports', 
        array(
            '2 male DB9 sockets',
        ),
        array(
            '../img/cpu_board/annotated/010_controller_ports_top.jpg',
            '../img/cpu_board/annotated/011_controller_ports_front.jpg',
            '../img/cpu_board/annotated/012_controller_ports_under.jpg',
    ));

    buildstep('Mezzanine Connector (Audio Side)', 
        array(
            'TX24-40P-12ST-H1E',
            'It is IMPORTANT that the beveled corner is on the top left to mate with the A/V board (assuming controller ports are oriented downward)',
            'There are a lot of vias on this board, so be careful not to short any of this connector\'s small pins to a via.'
        ),
        array(
            '../img/cpu_board/annotated/013_inter_board_audio.jpg',
            '../img/cpu_board/annotated/014_inter_board_audio_close.jpg',
            '../img/cpu_board/annotated/015_vias_warning.jpg',
    ));

    buildstep('Mezzanine Connector (Video Side)', 
        array(
            'TX25-40P-6ST-H1E',
            'The beveled corner should go towards the top right.',
        ),
        array(
            '../img/cpu_board/annotated/016_inter_board_video.jpg',
            '../img/cpu_board/annotated/017_inter_board_video_close.jpg',
    ));

    buildstep('Cartridge Slot', 
        array(
            '36 pin edge connector, with 0.1 inch spacing',
            'The connection is not symmetrical (don\'t put carts in backwards) but the connector itself is symmetrical and can be installed in either direction.',
        ),
        array(
            '../img/cpu_board/annotated/018_cartridge_slot.jpg',
    ));

    buildstep('Molex Headers', 
        array(
            'Two locking molex 1x2 header pins',
            'For RESET_SW_HDR the orientation should\'t matter.',
            'For LED1 just make sure that when you attach the opposite connector to the LED wire, that the flat side of the circle aligns with the minus side of the connection.'
        ),
        array(
            '../img/cpu_board/annotated/019_molex_headers.jpg',
            '../img/cpu_board/annotated/020_molex_close.jpg',
    ));

    buildstep('Reset Button Wiring', 
        array(
            '1 x shorter wire with molex plug attached',
            '1 x Yellow button (momentary switch)',
            'Solder one of the wires with a molex plug to the switching pins',
            'The plus and minus pins aren\'t needed for this button.'
        ),
        array(
            '../img/cpu_board/annotated/021_molex_reset.jpg',
            '../img/cpu_board/annotated/022_molex_reset_detail.jpg',
    ));

    buildstep('Power Button Wiring', 
        array(
            '1 x shorter wire with molex plug attached',
            '1 x longer wire with molex plug attached',
            '1 x Red button (on/off toggle)',
            'The shorter wire connects to the plus and minus LED terminals',
            'Check the orientation of the header from the earlier Molex Headers step. Ensure that the minus side connects to the grounded flat side of the circular LED marker.',
            'The longer wire is used for the other two pins (switch) and its polarity doesn\'t really matter'
        ),
        array(
            '../img/cpu_board/annotated/023_molex_power_led.jpg',
            '../img/cpu_board/annotated/024_molex_power_led_detail.jpg',
            '../img/cpu_board/annotated/025_molex_power_switch.jpg',
    ));

    buildstep('Mount Power Board',
        array(
            '1 x Power Board (assembled with separate instructions)',
            '2 x trimmed resistor leads from earlier',
            'Align GND and 5V pads and put folded resistor leads through',
            'bend the folded leads outward on the underside so they stay put like binder clips',
            'Solder this in place'
        ),
        array(
            '../img/cpu_board/annotated/026_mount_power_board.jpg',
            '../img/cpu_board/annotated/027_power_board_binder_clips.jpg',
            '../img/cpu_board/annotated/028_power_board_soldered.jpg',
            '../img/cpu_board/annotated/029_power_board_soldered_under.jpg',
    ));

    buildstep('All soldering done on this board',
    array(
        'Get some fresh air!'
    ),
    array(
        '../img/cpu_board/annotated/030_all_soldered.jpg',
        '../img/cpu_board/annotated/031_all_soldered_under.jpg',
        '../img/cpu_board/annotated/032_button_wires_connected.jpg',
    ));

    buildstep('11 x 74HC573',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/033_74_573.jpg',
    ));

    buildstep('9 x 74HC257',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/034_74_257.jpg',
    ));

    buildstep('8 x 74HC163',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/035_74_163.jpg',
    ));

    buildstep('4 x 74HC08',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/036_74_08.jpg',
    ));

    buildstep('3 x 74HC04',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/037_74_04.jpg',
    ));

    buildstep('3 x 74HC74',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/038_74_74.jpg',
    ));

    buildstep('2 x 74HC8541',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/039_74_8541.jpg',
    ));

    buildstep('2 x 74HC32',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/040_74_32.jpg',
    ));

    buildstep('2 x 74HC40103',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/041_74_40103.jpg',
    ));

    buildstep('3 x 74HC00',
    array(
        'At the time these photos were taken, one 74HC00 was missing. It will be digitally added to the photo for this step, please imagine it is with us in sucessive photos if it hasn\'t been edited in.',
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/042_74_00_missing_one.jpg',
    ));

    buildstep('1 x 74HC640',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/043_74_640.jpg',
    ));

    buildstep('1 x 74LS07',
    array(
        'The 07 is an open-drain buffer and should SPECIFICALLY be the LS version.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/044_74_07.jpg',
    ));

    buildstep('2 x 74HC238',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/045_74_238.jpg',
    ));

    buildstep('1 x 74HC139',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/046_74_139.jpg',
    ));

    buildstep('1 x 74HC30',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/047_74_30.jpg',
    ));

    buildstep('1 x 74HC86',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/cpu_board/annotated/048_74_86.jpg',
    ));

    buildstep('1 x 32K SRAM',
    array(
        'Long boi',
        'General-purpose system RAM'
    ),
    array(
        '../img/cpu_board/annotated/049_SRAM_32K.jpg',
    ));

    buildstep('1 x AS6C4008',
    array(
        'Asset/Sprite RAM used by blitter',
        '512K of memory'
    ),
    array(
        '../img/cpu_board/annotated/050_ASSET_RAM.jpg',
    ));

    buildstep('1 x 74AC161',
    array(
        'Should SPECIFICALLY be the AC version',
        'Goes in a spot labeled U$6 that may be labeled 74163 despite us using a 161 here'
    ),
    array(
        '../img/cpu_board/annotated/051_74_AC_161.jpg',
    ));

    buildstep('1 x W65C02S',
    array(
        'The CPU',
        'This board is designed around Western Design Center\'s "modern" 6502 and probably won\'t work with old stock NMOS chips.',
    ),
    array(
        '../img/cpu_board/annotated/052_CPU.jpg',
    ));

    buildstep('1 x W65C22S',
    array(
        'The Versatile Interface Adapter',
        'If you\'ve already build the A/V board then all that\'s left to do is to connect the two together and wrangle it into a case!',
    ),
    array(
        '../img/cpu_board/annotated/053_VIA.jpg',
    ));
?>