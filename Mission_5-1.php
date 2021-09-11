<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Mission5-1</title>
    </head>
    <?php
    // ・データベース名：
    // ・ユーザー名
    // ・パスワード

    // DB接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //TB作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    ."date TIMESTAMP,"
    ."pass TEXT"
    .");";
    
    $stmt = $pdo->query($sql);
    
    // 名前とコメントとパスワードがフォームに入っていたとしたらる&&編集対象番号が空だったら
    if(isset($_POST["name"]) && isset($_POST["comment"]) &&  isset($_POST["pass"])&& empty($_POST["edit_number"])){
              // 名前を変数に
             $name2=$_POST["name"];
             // コメントを変数に
             $comment2=$_POST["comment"];
             // 投稿日時を変数に
             $date2 =date("Y/m/d H:i:s");
             //パスワードを変数に
             $pass_word2=$_POST["pass"];
                 
                // DB接続設定
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                 $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
             //データ入力　（Mission4-5）
              $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment,date,pass) VALUES (:name, :comment,:date,:pass)");
               $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
            $name = $name2;
            $comment = $comment2;
            $date = $date2;
            $pass = $pass_word2;
            $sql -> execute();
        }
             
            // 削除番号と削除パスワードがフォームに入っていたら削除 
        else if(isset($_POST["deleteNO"]) && isset($_POST["delete_pass"])){
                //削除番号
                $deleteNO=$_POST["deleteNO"];
                //削除パスワード
                $delete_pass=$_POST["delete_pass"];
                
                 // DB接続設定
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                 //データ抽出
                 $sql = 'SELECT * FROM tbtest';
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     // 削除番号が正しくて、パスワードが正しかったら
                    if($row['id'] == $deleteNO && $row['pass'] == $delete_pass) {
                    
                     // データレコードを削除
                    $id = $deleteNO;
                    $sql = 'delete from tbtest where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);    
                    $stmt->execute(); 
                 }
                 // 削除番号は正しいが、パスワードが間違っている場合
                 if($row["id"]==$deleteNO && $row["pass"]!=$delete_pass){
                        // エラーメッセージを表示
                        echo "違うよ";
                  }
                  
                 }
        
            // 編集フォームに編集対象番号と編集パスワードが入っていたら             
        } else  if(isset($_POST["edit_number"]) && isset($_POST["edit_pass"])) { 
            // 編集対象番号
            $edit_number = $_POST["edit_number"]; 
             // 編集パスワード
            $edit_pass = $_POST["edit_pass"];
            
               // DB接続設定
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                 //データ抽出
                 $sql = 'SELECT * FROM tbtest';
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     
                      // 編集番号とパスワードが正しかったら
                    if($row['id'] == $edit_number && $row['pass'] == $edit_pass) {
                    // 編集するidを変数に
                    $edit_id = $row['id'];
                    // 編集するnameを変数に
                    $edit_name = $row['name']; 
                    // 編集するcommentを変数に
                    $edit_comment = $row['comment']; 
                }
              
                     // 編集番号が合っていて、パスワードが誤っていたら
                     if($row["id"] == $edit_number&& $row["pass"]!= $edit_pass ){
                     // パスワードを変数から除く
                     $edit_pass="";
                        // エラーメッセージを表示
                        echo "違うよ";
                   }
            }     
                 
                 //投稿フォームに名前とコメントと編集対象番号が入っていたら編集実行
            } else if(isset($_POST["comment"]) && isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["edit_n"])){
                //編集番号を変数に
                $edited_id=$_POST["edit_id"];
                //編集後の名前を変数に
                $edited_name=$_POST["name"];
                //編集後のコメントを変数に
                $edited_comment=$_POST["comment"];
                //編集時の時間を変数に
                $edited_date=date("Y/m/d H:i:s");
                // 編集後のパスワードを変数に
                $edited_pass=$_POST["pass"];
                
                  
               // DB接続設定
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                 //データ抽出
                 $sql = 'SELECT * FROM tbtest';
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
               
                // 編集番号と投稿番号が等しかったら
                if($row['id'] == $edited_id) {
                     // データ更新
                     // n
                    $id = $edited_id;
                    // 名前
                    $name = $edited_name; 
                    // コメント
                    $comment = $edited_comment;
                    // 日付
                    $date = $edited_date; 
                    // パスワード
                    $pass = $edited_pass; 
                $sql = 'UPDATE tbtest SET name=:name,comment=:comment ,date=:date,pass=:pass WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
               
            }  
            }
               
            }       
        ?>
         <!-- 入力フォーム -->
        <form method="POST" action="">
            <label for="name">名　前</label>
            <input type="text" name="name" placeholder="名前" value="<?php if(isset($edit_name))  {echo $edit_name;} ?>" required><br>
            <label for="name">意　見</label>
            <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($edit_comment)) { echo $edit_comment;} ?>" required><br>
            <label for="name">暗　号</label>
            <input type="text" name="pass" placeholder="パスワード" value="<?php  if(isset($edit_pass)) {echo $edit_pass;}?>" required><br>
            <input type="hidden" name="edit_id" value="<?php if(isset($edit_id)) { echo $edit_id;} ?>">
            <input type="submit" value="送信">
        </form><br>
        
        <!-- 削除フォーム -->
        <form method="POST" action="">
            <label for="name">削　除</label>
            <input type="number" name="deleteNO" placeholder="削除対象番号"><br>
            <label for="name">合言葉</label>
            <input type="text" name="delete_pass" placeholder="パスワード"><br>
            <input type="submit" value="削除">
        </form><br>
        
        <!-- 編集フォーム-->
        <form method="POST" action="">
            <label for="name">編　集</label>
            <input type="number" name="edit_number" placeholder="編集対象番号"><br>
            <label for="name">合言葉</label>
            <input type="text" name="edit_pass" placeholder="パスワード"><br>
            <input type="submit" value="編集">
        </form><br>
        
        
        
        
        <?php
        
         
               // DB接続設定
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                 //データ抽出
                 $sql = 'SELECT * FROM tbtest';
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     //$rowの中にはテーブルのカラム名が入る
                     echo $row['id'].',';
                     echo $row['name'].',';
                     echo $row['comment'].',';
                     echo $row['date'].',';
                      echo $row['pass'].'<br>';
                     echo "<hr>";
              
        }
        ?>
    </body>
</html>   