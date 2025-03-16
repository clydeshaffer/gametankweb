<?php

include 'upload.php';
include '../../include/db.php';

session_start();

if(isset($_SESSION["user"])) {

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        try {
            $db = get_db("games");
            $sql = 'INSERT INTO games (title, author, visibility) values (:title, :author, 0)';
            $statement = $db->prepare($sql);
            $statement->execute([
              ":title" => $_POST['title'],
              ":author" => $_SESSION["user"]
            ]);
        
            http_response_code(200);
            $id = $db->lastInsertId();
            $romfileKey = 'games/phpapi/' . $id . '/game.gtr';
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok', 'url' => generatePresignedUrl('gametankgames', 'nyc3', $romfileKey), 'id' => $id]);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('IDK something went sideways: ' . $e->getMessage());
        }
    


} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
?>

<input id="RomFileInput" type="file" onchange="useFileInput(this);" style="display: none"/>
<input type="button" id="loadimg" value="Upload ROM" onclick="document.getElementById('RomFileInput').click();" />

<script>
    async function useFileInput(fileInput) {
          console.log("useFileInput called");
          if (fileInput.files.length == 0)
              return;
          var file = fileInput.files[0];
          console.log("loading file " + file.name);
          var fr = new FileReader();

          async function doUpload () {
              var data = new Uint8Array(fr.result);
              
              const response = await fetch('addgame.php', {
                method: "POST",
                body: new URLSearchParams({
                  title: file.name
                })
              });
              const json = await response.json();
              const signedURL = json['url'];
              
              let romresponse = await fetch(signedURL, {
                        method: "PUT",
                        body: data,
                        mode: 'cors',
                        headers: {
                          "Content-Type": "binary/octet-stream",
                          "x-amz-acl": "public-read"
                        },
                    });

                    if (romresponse.ok) {
                        alert("Upload successful!");
                        window.location = "https://gametank.zone/emulator/web?game=" + json.id;
                    } else {
                        console.error("Upload failed", await response.text());
                    }

              fileInput.value = '';
          };

          fr.onload = () => {
            doUpload();
          }
          fr.readAsArrayBuffer(file);
      }
</script>

<?php
}
} else {
    http_response_code(401);
}


?>