<!-- title = Second Prototype -->
<!-- thumb = /img/v2/V2-mobo.JPG -->
<?php $title = "Second Prototype"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h1>
GameTank Prototype V2
</h1>
<h2>Layout rearranged for easier debugging</h2>

<p>
The initial GameTank prototype with its backplane-style motherboard and genericized bus connectors was great for trying things out but not very sturdy and difficult to find an angle
to connect oscilloscope probes. It had also grown even more fragile in accumulating several bodge edits, some of which were connected by jumper wires so they could span multiple
circuit boards.
</p>
<p>
Having settled several design questions, I sat down to create the next set of boards that would be used to investigate the remaining hardware bugs. The new boards would be connected
in a flat arrangement, rather than perpendicular to a backplane, for easier access to the circuit. The connections would also be more limited, with the video and audio cards using
dedicated connectors that only broke out the signals they needed. Also, these connectors would be parts actually designed for board-to-board mating. The way-too-long pin headers
used in Version 1 started out with a bothersome amount of friction and only got worse as the pins slightly bent from repeated connection and disconnection. Otherwise the overall
design of each module was mostly the same, apart from incorporating the bodges into the schematic.
</p>
<p>
Well... except for the audio module. I ordered the Version 2 boards for the Motherboard, the Blitter, and the Video card at the same time but had not yet redesigned the audio card.
That still needed a workaround for the digital potentiometer being EOLed so I saved it for later. This ended up being different enough from the original audio card that detail it
in a separate post. 
</p>
<p>
The Video Card, responsible for generating the TV signal, had its output stage tweaked to incoporate a video op-amp that buffers the voltage for a consistent picture. The op-amp
used has relatively straightforward connections, but annoyingly is only available in a tiny surface mount package.
</p>
<p>
The Blitter Card has had a couple of new features added, though these ended up being the cause of two board respins as I grappled with the timing of its many counters.
In particular, the new features are the ability to draw a flipped version of a graphic asset, as well as the ability to inhibit "wrap" drawing where a draw operation going off
screen will continue on the opposite edge. At first I thought to use the 74HC191 counter which allows for controlling the count direction, but I had overlooked how troublesome
asynchronous vs synchronous reloads would be. The latest version of the Blitter goes back to the 74HC163 which isn't reversible but has synchronous reload. Sprite flipping is instead
accomplished by passing the G.RAM coordinates through a pair of inverting/noninverting buffers which will act to reverse the drawn image orientation.
</p>
<center>
    <img width="500" src="../img/v2/V2-mobo.JPG">
    <img width="500" src="../img/v2/V2-graphics.JPG">
</center>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>