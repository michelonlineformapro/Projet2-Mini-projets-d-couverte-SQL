<?php

ob_start();
if(isset($_GET['url'])){
    if($_GET['url'] === "exercices"){
        $title  = "SQL EXERCICES";
        require "exercices.php";
    }elseif ($_GET['url'] === "crud"){
        $title  = "SQL CRUD";
        require "crud.php";
    }elseif ($_GET['url'] === "add_student"){
        $title  = "SQL AJOUTER";
        require "add_student.php";
    }elseif ($_GET['url'] === "edit_student"){
        $title  = "SQL EDITER";
        if(isset($_GET['id']) && $_GET['id'] > 0){
            require "edit_student.php";
        }
    }elseif ($_GET['url'] === "delete_student"){
        $title  = "SQL SUPPRIMER";
        require "delete_student.php";
    }
}



$content = ob_get_clean();
require "template.php";