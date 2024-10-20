<?php
    // Set appropriate headers for error reporting and file uploads
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        // Ensure a file was uploaded
        $file = $_FILES['file'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Upload failed with error code " . $file['error']);
        }

        $uploadedFilename = pathinfo($file['name'], PATHINFO_FILENAME);

        // Define a temporary directory for working with the repo
        $tempDir = sys_get_temp_dir() . '/' . uniqid('gte_', true);
        mkdir($tempDir, 0755, true);

        // Copy the repository from the local directory instead of cloning it
        $sourceRepoPath = '/home/cshaffer/GameTankEmulator-Template'; // Path to the source repo
        $copyCommand = "cp -r $sourceRepoPath/* $tempDir";
        exec($copyCommand, $output, $returnVar);
        if ($returnVar !== 0) {
            die("Failed to copy repository.");
        }

        // Save the uploaded file inside the "roms" folder of the copied repo as "game.gtr"
        $romsDir = $tempDir . '/roms'; // Path to the roms directory
        if (!is_dir($romsDir)) {
            mkdir($romsDir, 0755, true);
        }
        $filePath = $romsDir . '/game.gtr'; // The file will be saved as "game.gtr"
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            die("Failed to move uploaded file.");
        }

        $emsdkEnvScript = '/home/cshaffer/emsdk/emsdk_env.sh';
        $emsdkDir = '/home/cshaffer/emsdk';
        $pathVar = '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin';
        // Run 'make' with the required parameters
        $makeCommand = "/bin/bash -c 'export PATH=$pathVar && cd $emsdkDir && source emsdk_env.sh 2>&1 && cd $tempDir &&  make clean && make OS=wasm ROMFILE=roms/game.gtr WEB_SHELL=web/embedded.html MANUAL_COMMIT_HASH=none 2>&1'";
        exec($makeCommand, $output, $returnVar);
        if ($returnVar !== 0) {
            // Output the stderr from the make command
            echo "<h2>Build failed:</h2>";
            echo "<pre>" . implode("\n", $output) . "</pre>";
            exec("rm -rf $tempDir"); // Clean up after failure
            exit;
        }

        // Get the ZIP archive of the build artifacts
        $zipFile = $tempDir . '/dist/GTE_wasm.zip';

        // Serve the ZIP file for download
        header('Content-Disposition: attachment; filename="' . $uploadedFilename . '.zip"');
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($zipFile));
        readfile($zipFile);

        // Clean up the temporary files
        unlink($zipFile);
        exec("rm -rf $tempDir");
    } else {
        // HTML form for file upload
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gametank ROM Embedding Tool</title>
    <style>
    </style>
</head>
<body>
    <div>
        <h1>Gametank ROM Embedding Tool</h1>
        <p>This tool is designed to let you embed your GameTank games into an Itch.io project page with the web emulator!</p>
    </div>
    <div>
            <form enctype="multipart/form-data" action="" method="POST">
                <input type="file" name="file" required>
                <button type="submit">Upload and Build</button>
            </form>
    </div>
    <div>
        <h3>Configuring your itch.io page</h3>
        <p>When uploading to itch.io there are a few project settings needed to make the embed work smoothly:</p>
        <img src="kind_of_game.png" width="500"/>
        <p>The "Kind of project" field should be set to "HTML". After putting your coolgame.gtr file into this page</p>
        <img src="uploads.png" width="500"/>
        <p>Make sure to check the "This file will be played in the browser"</p>
        <p>If you also upload the GTR file, people can play it in the desktop emulator or even flash it to a cartridge!</p>
        <img src="embed_options.png" width="500"/>
        <p>"Embed in page" and "Manually set size" should be selected, with a viewport of 512px by 512px. (Currently the web emulator assumes this size)</p>
    </div>
</body>
        </html>
    HTML;
    }
    ?>
