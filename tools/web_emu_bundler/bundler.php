<?php

// Check if the POST parameter "romfile" is set
if(isset($_POST['romfile'])) {

    // Get the base64 string from the POST parameter
    $base64String = $_POST['romfile'];

    // Create a unique filename for the zip file on the server
    $serverZipFilename = './output_' . uniqid() . '.zip';
    register_shutdown_function('unlink', $serverZipFilename);

    // Create a new ZipArchive
    $zip = new ZipArchive();
    if ($zip->open($serverZipFilename, ZipArchive::CREATE) === TRUE) {

        // Add the JavaScript file with the base64 string verbatim
        $javascriptContent = file_get_contents('template/template.js');
        $javascriptContent = str_replace('INSERT_ROMFILE', $base64String, $javascriptContent);
        $zip->addFromString('index.js', $javascriptContent);

        // Add other static files
        $zip->addFile('template/index.html', 'index.html');
        $zip->addFile('template/index.wasm', 'index.wasm');
        $zip->addFile('template/commit_hash.txt', 'commit_hash.txt');

        // Close the zip file
        $zip->close();

        // Set headers for zip file download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="gt_embed.zip"');
        header('Content-Length: ' . filesize($serverZipFilename));

        // Output the zip file
        readfile($serverZipFilename);

        // Delete the temporary zip file
        //unlink($serverZipFilename);

    } else {
        echo 'Failed to create zip file.';
    }

} else {
    echo 'No "romfile" parameter provided.';
}

?>