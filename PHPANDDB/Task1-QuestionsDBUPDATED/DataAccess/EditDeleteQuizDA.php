<?php
include_once ("Database.php");
include_once ("..\phpActions\EditQuizes.php");

function deleteQuiz($id)
{

   $delete = new EditQuizes();
   try{
    $result = $delete ->deleteCurrentQuiz($id);
    return $result;
   }catch(Exception $e)
   {
        echo $e->getMessage();
   }


}


