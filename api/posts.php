<?

    if($method == 'GET'){
        if($id){
            $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array('id'=>$id));
            if($data != null){
                echo json_encode($data[0]);
            }else{
                echo json_encode(['message'=>'There are no posts in the DB']);
            }
        }else{
            $data = DB::query("SELECT * FROM $tableName");
            echo json_encode($data);
        }
    }elseif($method == 'POST'){
        if($_POST !== null && !$id){
            extract($_POST);
            DB::query("INSERT INTO $tableName VALUES(null, :title, :body, :author, null)", array(":title"=>$title, ":body"=>$body, ":author"=>$author));
            $data = DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
            echo json_encode(["message"=>'Post added succesfully', "success"=>true, 'post'=>$data[0]]);
        }else{
            echo json_encode(["message"=>'Please fill in all the field', "success"=>false]);
        }
    }elseif($id){
        $post = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id'=>$id));
        if($post != null){
            if($method == "PUT"){
                 extract(json_decode(file_get_contents('php://input'), true));
                 DB::query("UPDATE $tableName SET title=:title, body=:body, author=:author WHERE id=:id", array(":id"=>$id,":title"=>$title, ":body"=>$body, "author"=>$author));
                $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(":id"=>$id));
                 echo json_encode(["post"=>$data[0], "message"=>'Post updated successfully',"success"=>true]);
            }elseif($method == "DELETE"){
                DB::query("DELETE FROM $tableName WHERE id=:id", array(":id"=>$id));
                echo json_encode(["message"=>'Post has been deleted successfully',"success"=>true]);
            }
        }else{
            echo json_encode(["message"=>'Post not found']);
        }  
    }
?>