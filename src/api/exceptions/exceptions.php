<?php 


    function noContent(){
        include '../exceptions/no_content.php';
    }

    function notAllowed(){
        header('Location: /src/public/views/exceptions/403.php');
    }

    function pageNotFound(){

    }

    function internalError(){

    }


?>