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
        'Be sure to match the direction of the arrows on the sockets to the arrows printed on the board.'
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

    buildstep('All sockets have been installed!',
    array(
        'Pat yourself on the back',
        'You\'re done soldering! ...On the A/V Board, at least ;)'
    ),
    array(
        '../img/av_board/annotated/024_sockets_all.jpg',
    ));
?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>