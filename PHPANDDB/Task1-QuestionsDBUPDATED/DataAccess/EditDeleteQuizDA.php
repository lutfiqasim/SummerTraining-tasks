<?php
include_once ("Database.php");
include_once ("..\phpActions\DeleteQuiz.php");

function deleteQuiz($id)
{
   $delete = new DeleteQuiz();
   try{
    $result = $delete ->deleteCurrentQuiz($id);
    return $result;
   }catch(Exception $e)
   {
        echo $e->getMessage();
   }


}


