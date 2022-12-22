<!-- title = Introduction -->
<!-- thumb = /build_guides/img/av_board/original/051_chip_6502.jpg -->
<?php $title = "Building a GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<?php include '../includes/manual_templates.php'?>

<h1>The A/V Board</h1>

<?php
    buildstep('Before we begin', 
    array(
        'This page will walk you throuhg building the A/V Board.',
        'In general we\'ll be placing the shorter components first.',
        'It will help to have a flat board handy, about the same size as the PCB. This can be used to keep parts from falling out as you flip the whole board to solder components.'
    ),
    array(
        '../img/av_board/annotated/000_board.jpg'
    ));

    buildstep('Bypass Capacitors', 
        array(
            'The bypass capacitors smooth out the power supply to each chip.',
            'Every IC gets a 0.1uF capacitor next to it.',
            'There should be 35 of these'
        ),
        array(
            '../img/av_board/annotated/001_bypass.jpg'
        ));

    buildstep('Filter Capacitors', 
        array(
            'A few more capacitors are used for audio and video filtering',
            'Leave C1 vacant',
            'Use 100pF in C2',
            'Place the respective capacitors on the slots labeled 680pF, 820pF, and 82pF',
            '(82pF is missing from the photo due to a shipping error, and will appear in later step photos)'
        ),
        array(
            '../img/av_board/annotated/002_filtercaps.jpg',
            '../img/av_board/annotated/004_filtercaps_close.jpg'
        ));
    
    buildstep('1K Resistors', 
        array(
            'There are 14 1kOhm resistors to install',
            'The resistors inside the rectangle are meant to be installed vertically, as in the picture.',
            'Cut the resistor leads after soldering',
            'Bending the legs of horizontal resistors outward can help them stay in place for soldering.'
        ),
        array(
            '../img/av_board/annotated/005_reistors_1k.jpg',
            '../img/av_board/annotated/006_reistors_1k_under.jpg',
            '../img/av_board/annotated/008_resistor_legs.jpg'
        ));
    

    buildstep('Other Resistors',
    array(
        'Install the rest of the resistors according to their labeled value.',
        '3 x 150 Ohms',
        '4 x 3.3kOhm resistors',
        'One each of 470, 16k, 68k, 10k',
        'R26 can be just a wire, such as one clipped from another resistor after soldering.',
    ),
    array(
        '../img/av_board/annotated/007_resistors_remaining.jpg',
        '../img/av_board/annotated/011_zero_ohm.jpg'
    ));

    buildstep('Big Capacitors',
    array(
        'One filter capacitor for video and the two bypass capacitors for inter-board connectors are big 220uF electrolytic caps',
        'The symbol for these capacitors has a small "+" plus sign indicating the positive lead',
        'The capacitor has a stripe indicating the negative lead, which should go in the opposite hole of the plus sign.'
    ),
    array(
        '../img/av_board/annotated/010_big_caps.jpg',
        '../img/av_board/annotated/009_cap_polarity.jpg'
    ));

    buildstep('DIP16 Sockets',
    array(
        'Next insert the DIP16 sockets, which have two rows of eight pins.',
        'There should be 11 of these on the A/V board.',
        'If the wood board method isn\'t enough, you can bend the socket pins outward to help them stay in the holes before soldering.',
        'BE SURE TO match the divot on the socket to the divot on the printed socket outline!'
    ),
    array(
        '../img/av_board/annotated/012_sockets_2x8.jpg',
        '../img/av_board/annotated/013_socket_legs.jpg'
    ));

    buildstep('DIP14 Sockets',
    array(
        'Now insert the DIP14 sockets, which have two rows of seven pins.',
        'There are places for 15 of these.'
    ),
    array(
        '../img/av_board/annotated/014_sockets_2x7.jpg'
    ));

    buildstep('DIP20 Sockets',
    array(
        'Install the DIP20 sockets, with two rows of ten pins.',
        'You\'ll be placing 3 of them.'
    ),
    array(
        '../img/av_board/annotated/015_sockets_2x10.jpg'
    ));

    buildstep('DIP40 Socket',
    array(
        'The next socket is the DIP40 that will hold one of the GameTank\'s two 6502 CPUs',
        'There is only one place for a DIP40 socket on the A/V board',
        'This CPU will be the Audio Coprocessor'
    ),
    array(
        '../img/av_board/annotated/016_socket_6502.jpg'
    ));

    buildstep('PLCC Sockets (The square ones)',
    array(
        'There are two square sockets to install, which will hold the Video RAM and Audio RAM chips.',
        'Be sure to match the direction of the arrows on the sockets to the arrows printed on the board.',
        '"Protip rest it on something and get the corners first." - dwbrite'
    ),
    array(
        '../img/av_board/annotated/017_square_sockets.jpg'
    ));

    buildstep('Inter-board connectors',
    array(
        'Next, install the two inter-board connectors on the BOTTOM of the board.',
        'You\'ll need one "receptacle" and one "plug" connector',
        'IMPORTANT: Each of the connectors has a single corner flattened on a diagonal. These diagonals should be oriented INWARD towards the cartridge hole for consistency.'
    ),
    array(
        '../img/av_board/annotated/019_inter_board_connector.jpg'
    ));

    buildstep('DIP8 Connector',
    array(
        'Install the single DIP8 connector that has two rows of four pins.'
    ),
    array(
        '../img/av_board/annotated/020_socket_2x4.jpg'
    ));

    buildstep('A/V Output Jacks',
    array(
        'Install the two RCA-style conectors on the corner of the PCB',
        'The yellow connector should go on VIDJACK',
        'The white connector should go on AUDJACK'
    ),
    array(
        '../img/av_board/annotated/021_rca_jacks.jpg',
        '../img/av_board/annotated/022_rca_jacks_close.jpg'
    ));

    buildstep('6-pin Header',
    array(
        'Install the 6-pin female header',
        'This will be for the video buffer amp module'
    ),
    array(
        '../img/av_board/annotated/023_header_6pin.jpg'
    ));

    buildstep('All sockets have been installed',
    array(
        'Pat yourself on the back!'
    ),
    array(
        '../img/av_board/annotated/024_sockets_all.jpg',
    ));

    buildstep('Assemble the Video Buffer Amp',
    array(
        'If you didn\'t request a pre-soldered module, this will be one of the two surface-mount soldering tasks in the console.',
        'This will use the small PCB with THS7374 printed on it, as well as the chip with the same name.',
        'Flux and low-temperature solder paste are recommended',
        'Align the THS7374 to the outline, matching the divot on the chip to the printed dot on the board.',
        'This can be soldered with an iron, hot air gun, oven, or hot plate.',
        'If any pins are bridged, add flux and use copper braid to remove excess solder.',
        'C1 and the resistor outline on this module can be left vacant with no issues.',
        'Then solder on the 6-pin male header to the BOTTOM of the board.'
    ),
    array(
        '../img/av_board/annotated/025_video_buffer.jpg',
        '../img/av_board/annotated/026_video_buffer_pins.jpg',
    ));

    buildstep('Install the Video Buffer Amp',
    array(
        'Insert the video buffer amp module into the 6-pin female header, with the arrow pointing towards the front of the console.',
        'It will hang over the electrolytic capacitor next to it, but there should be enough clearance.'
    ),
    array(
        '../img/av_board/annotated/027_buffer_installed.jpg',
        '../img/av_board/annotated/028_buffer_installed_close.jpg',
        '../img/av_board/annotated/029_buffer_installed_side.jpg',
    ));

    buildstep('Inserting Chips (Prelude)',
    array(
        'Next you\'ll be inserting chips into all these sockets you just soldered',
        'The chip names are printed on the the PCB, but they are now obscured by sockets.',
        'A <a href="https://github.com/clydeshaffer/gametank/blob/main/Docs/signals_board_layout_WIP.pdf">layout diagram</a> will come in handy for finding where chips live.',
        'It will also help greatly to have a Lead Forming Tool to straighten the chip pins, as they ship with their legs slightly bowed outward.',
        'Lead Forming Tools can be purchased commercially, or produced on a 3D printer.',
        'Simply place the chip on top of the middle bar and squeeze. The chip will now fit a socket perfectly.'
    ),
    array(
        '../img/misc/ic_lead_former_commercial.jpg',
        '../img/misc/ic_lead_former_printed.jpg',
    ));

    buildstep('Gather your chips',
    array(
        '1x 74HC164N/E',
        '1x HC151E (74LS151N)',
        '2x HC08E (74LS08N)',
        '2x HC257N',
        '1x HC564N/E',
        '2x HC573N',
        '1x 7524CN/JN (AD7524JN)',
        '3x HCT74N (74S74N/74LS74N/) ',
        '1x AC32N (74LS32N)',
        '5x HC00E (7400N)',
        '1x HC40103E (CD40103)',
        '1x HC86E (7486N)',
        '1x HCT30E (74AS30N)',
        '4x HC4040E (4040N)',
        '1x HC04E(7404N)',
        '2x HC161N (74HC161)',
        '1x LM358'
    ),
    array(
        '../img/misc/chip_pile.jpg',
    ));

    buildstep('1 x 74HC151',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/030_chip_74_151.jpg'
    ));

    buildstep('1 x 74HC30',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/031_chip_74_30.jpg'
    ));

    buildstep('5 x 74HC00',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/032_chip_74_00.jpg'
    ));

    buildstep('1 x 74HC04',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/033_chip_74_04.jpg'
    ));

    buildstep('3 x 74HC74',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/034_chip_74_74.jpg'
    ));

    buildstep('2 x 74HC161',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.',
        'In your overall parts order is at least one 74AC161, but don\'t use it here! Save it for slot U$6 on the main board!'
    ),
    array(
        '../img/av_board/annotated/035_chip_74_161.jpg'
    ));

    buildstep('1 x 74HC32',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/036_chip_74_32.jpg'
    ));

    buildstep('2 x 74HC08',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/037_chip_74_08.jpg'
    ));

    buildstep('1 x 74HC86',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/038_chip_74_86.jpg'
    ));

    buildstep('1 x 74HC164',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/039_chip_74_164.jpg'
    ));

    buildstep('4 x 74HC4040',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/040_chip_74_4040.jpg'
    ));

    buildstep('1 x 74HC40103',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/041_chip_74_40103.jpg'
    ));

    buildstep('2 x 74HC573',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/042_chip_74_573.jpg'
    ));

    buildstep('1 x TLC7524',
    array(
        'Might also be called AD7524'
    ),
    array(
        '../img/av_board/annotated/043_chip_TLC_7524.jpg'
    ));

    buildstep('1 x 74HC564',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/044_chip_74_564.jpg'
    ));

    buildstep('2 x 74HC257',
    array(
        'Depending on the market, the HCT or AHC versions might be easier to get. These will work fine.',
        'The text on the chip might end in an N or an E. This denotes what factory they came from and doesn\'t matter here.'
    ),
    array(
        '../img/av_board/annotated/045_chip_74_257.jpg'
    ));

    buildstep('1 x LM358',
    array(
        'Audio buffer op-amp',
    ),
    array(
        '../img/av_board/annotated/046_chip_LM_358.jpg'
    ));

    buildstep('IDT7007 (Video RAM)',
    array(
        'Larger of the two square chips',
        'BE SURE TO align the dot on one edge of the chip to the direction of the arrow on the socket',
        'If inserted wrong you will need a special PLCC Removal Tool to extract it.',
        'To insert, just make sure the dot and the pins are lined up and press down firmly.'
    ),
    array(
        '../img/av_board/annotated/048_chip_VRAM_close.jpg',
        '../img/av_board/annotated/049_chip_VRAM_installed_close.jpg',
        '../img/av_board/annotated/047_chip_VRAM.jpg'
    ));

    buildstep('IDT7137 (Audio RAM)',
    array(
        'Smaller of the two square chips',
        'Same warnings and advice for IDT7007 apply',
        'Double check the direction of the arrow, it isn\'t the same as the other socket!'
    ),
    array(
        '../img/av_board/annotated/050_chip_ARAM.jpg'
    ));

    buildstep('6502 (Audio Coprocessor)',
    array(
        'One of the two 6502 chips in your parts order',
        'Not the 6522 VIA which is also a 40 pin DIP chip',
        'With this installed your A/V Board is complete! Well done!'
    ),
    array(
        '../img/av_board/annotated/051_chip_6502.jpg'
    ));
?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>