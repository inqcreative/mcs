<?php

// Comment if you don't want to allow posts from other domains
header('Access-Control-Allow-Origin: *');

// Allow the following methods to access this file
header('Access-Control-Allow-Methods: POST');

// Load the FilePond class
require_once('FilePond.class.php');

// Load our configuration for this server
require_once('config.php');

// Catch server exceptions and auto jump to 500 response code if caught
FilePond\catch_server_exceptions();
FilePond\route_form_post(ENTRY_FIELD, [
    'FILE_OBJECTS' => 'handle_file_post',
    'BASE64_ENCODED_FILE_OBJECTS' => 'handle_base64_encoded_file_post',
    'TRANSFER_IDS' => 'handle_transfer_ids_post'
]);

function handle_file_post($files) {

    // This is a very basic implementation of a classic PHP upload function, please properly
    // validate all submitted files before saving to disk or database, more information here
    // http://php.net/manual/en/features.file-upload.php
    
    foreach($files as $file) {
        FilePond\move_file($file, UPLOAD_DIR);
    }
}

function handle_base64_encoded_file_post($files) {

    foreach ($files as $file) {

        // Suppress error messages, we'll assume these file objects are valid
        /* Expected format:
        {
            "id": "iuhv2cpsu",
            "name": "picture.jpg",
            "type": "image/jpeg",
            "size": 20636,
            "metadata" : {...}
            "data": "/9j/4AAQSkZJRgABAQEASABIAA..."
        }
        */
        $file = @json_decode($file);

        // Skip files that failed to decode
        if (!is_object($file)) continue;

        // write file to disk
        FilePond\write_file(
            UPLOAD_DIR, 
            base64_decode($file->data), 
            FilePond\sanitize_filename($file->name)
        );
    }

}

function handle_transfer_ids_post($ids) {

    foreach ($ids as $id) {
        
        // create transfer wrapper around upload
        $transfer = FilePond\get_transfer(TRANSFER_DIR, $id);
        
        // transfer not found
        if (!$transfer) continue;
        
        // move files
        $files = $transfer->getFiles(defined('TRANSFER_PROCESSOR') ? TRANSFER_PROCESSOR : null);
        foreach($files as $file) {
            FilePond\move_file($file, UPLOAD_DIR);
        }

        // remove transfer directory
        FilePond\remove_transfer_directory(TRANSFER_DIR, $id);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Form Submission</title>

	<link rel="shortcut icon" href="" type="image/x-icon">
	<link rel="apple-touch-icon" href="">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Link to your css file -->
	<link rel="stylesheet" href="">

</head>

<body>
	<!-- Start coding here -->

	<h1>Thank you!</h1>

	<!-- Coding End -->

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>