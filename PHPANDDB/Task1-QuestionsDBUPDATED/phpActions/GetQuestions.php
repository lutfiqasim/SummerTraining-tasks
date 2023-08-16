<?php

class GetQuestions
{
    private $error="";

    public function retriveQuestions()
    {
        try{
            $query = "SELECT * from questions";
            $conn = new Database();
            $data = $conn->read($query);
            if($this->error ==""){
                return $data;
            }else{
                return $this->error;
            }
        }catch(Exception $e){
            return "Error accord while getting data:\n".$e->getMessage();
        }
    } 

    public function retriveQuestionsAscendingOrder(){
        try{
            $query = "SELECT * from questions ORDER BY id";
            $conn = new Database();
            $data = $conn->read($query);
            if($this->error ==""){
                return $data;
            }else{
                return $this->error;
            }
        }catch(Exception $e){
            return "Error accord while getting data:\n".$e->getMessage();
        }
    }
    public function retriveQuestionsDescendingOrder(){
        try{
            $query = "SELECT * from questions ORDER BY id DESC";
            $conn = new Database();
            $data = $conn->read($query);
            if($this->error ==""){
                return $data;
            }else{
                return $this->error;
            }
        }catch(Exception $e){
            return "Error accord while getting data:\n".$e->getMessage();
        }
    }
}

?>