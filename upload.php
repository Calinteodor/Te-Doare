<?php
    echo "<pre>";
    print_r($_POST);
    
    echo "<pre>";
    print_r($_FILES);
    
    if (!empty($_FILES)) {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }
?>