<?php 

date_default_timezone_set("Asia/Tokyo");

$comment_array = array();
$pdo = null;
$stmt = null;

try{
    $pdo = new PDO('mysql:host=localhost;dbname=bbs-yt', "root", "");

}catch(PDOException $e){
 echo $e->getMessage();
}

 if (!empty ($_POST["submitButtn"]));{

    if(empty($_POST["username"])){
        echo"名前を入力してくだい";
        $error_messages["username"] ="名前を入力してくだい";
    }  
    
    if(empty($_POST["comment"])){
        echo"コメントを入力してくだい";
        $error_messages["comment"] ="コメントを入力してくだい";
    }

    if(empty($error_messages)){
        $postDate = date("Y-m-d H:i:s");

        try{
            $stmt = $pdo->prepare("INSERT INTO `bbs-table` (`username`, `comment`, `postDate`) VALUES (:username, :comment,:postDate);");
            $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
            $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
        
            $stmt->execute();
        
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}


$sql = "SELECT `id`,`username`,`comment`,`postDate`FROM `bbs-table`;";
$comment_array = $pdo->query($sql);

$pdo->null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">
        <?php
        class SampleClass
        {
        //プロパティの宣言
        public $var = '掲示板アプリ';

        }
        //インスタンスの生成
        $sample = new SampleClass();

        echo $sample->var;

        ?>
   </h1>
    <hr>
    <div class="boardWrapper">
        <section>
            <?php foreach($comment_array as $comment): ?>
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <span>名前：</span>
                        <p class="username"><?php echo $comment["username"]; ?></p>
                        <time>:<?php echo $comment["postDate"]; ?></time>
                    </div>
                    <p class="comment"><?php echo $comment["comment"]; ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
        <form class="fordWrapper" method="POST">
            <div>
                <input type="submit" value=”書き込む” name="submitButtn">
                <label for="">名前</label>
                <input type="text" name="username">
            </div>
            <div>
                <textarea class="commenttextarea" name="comment"></textarea>
            </div>
        </form>
    </div>
    
</body>
</html>