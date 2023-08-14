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
        $sections.push(array("title"=>$title, "anchor"=>$anchor, "content"=>$content));
    }

    function emit_table_of_contents() {
        global $sections;
        foreach($sections as $section) {
            echo tag(
                "li",
                anchor(
                    $section["title"],
                    $section["anchor"]
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
            <td>System control registers</td>
        </tr>
        <tr>
            <td>$2008 - $2009</td>
            <td>Gamepads</td>
        </tr>
        <tr>
            <td>$2800 - $280F</td>
            <td>GPIOs, Timers</td>
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

?>

<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<center>
        <h2>Programmer's Manual</h2>
    </center>

    <ul>
<?php emit_table_of_contents(); ?>
    </ul>

    <?php emit_section_contents(); ?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>