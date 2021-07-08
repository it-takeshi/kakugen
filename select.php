<?php
// DB接続情報
$dbn = 'mysql:dbname=kakugen;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$myselect = $_POST["myselect"];

// $search_word = $_GET["searchword"]; // GETでデータ受け取り

// db連携
// $sql = "SELECT * FROM word_table WHERE name LIKE :myselect OR trivia LIKE :myselect" ;
$sql = "SELECT * FROM word_table WHERE name LIKE :myselect" ;

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':myselect', "%{$myselect}%", PDO::PARAM_STR);
$status = $stmt->execute();

$wordAll = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach ($wordAll as $key => $value) {
        $output .= "
      
            <div class='word_title'>{$value['word']}</div>
            <div class='name_title'>{$value['name']}</div>
            <div class='occupation_title'>{$value['occupation']}</div>
            <h3>Trivia</h3>
            <div class='trivia'>{$value['trivia']}</div>
        
        ";
        // foreach ($my_playlist as $list) {
        //         $output .= "
        //         <form id='fm'>
        //         <li class='playlist_li' onclick='submitFnc()'>{$list['playlist_name']}</li>
        //         <input type='hidden' name='playlist_id' value='{$list['playlist_id']}'>
        //         <input type='hidden' name='music_id' value='{$music['music_id']}'>
        //         </form>
        //     ";
        // }
        // $output .= "
        // </ul>
        // </li>
        // ";
    }
    unset($value);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended</title>
    <!-- <link href="css/ajax.css" rel="stylesheet"> -->
    <style>
      /* vegas対応ここから */
html,body{
        margin: 0;
        padding: 0;
        /* background-color: black; */
    }

    .visual{
        width: 1000%;
        height: 70vh;
    }
/* vegas対応ここまで */
/* 格言ここから */
#output{
  color:red;
  font-family: "Noto Serif JP","YuMincho","Yu Mincho","游明朝体","ヒラギノ明朝 ProN","Hiragino Mincho ProN",serif;
  position: absolute;
  left:  50px;                
  top: 10px;   
}
/* 格言ここまで */
    </style>
</head>
<body>
<main>

<!-- HTMLここから -->
<!-- vegasここから -->
<div id="vegas-slide" class="visual"></div>
<!-- 格言表示ここから -->
<header>
        <a href="beatles.php"><img src="img/beatles_logo05.png" alt="" height="60px"></a>
      
      
    </header>
    <main>

          <!-- <ul class="row"> -->
          <div id="output">
          <h2><i class="fas fa-record-vinyl"></i> 格言</h2>
          <h2><?= $output ?></h2> 
          <input type="button" onclick="history.back()" class="gradient1" value="戻る">
          </div>
          


<!-- 格言表示ここまで -->

</main>
<script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/vegas.min.js"></script>
<script>

// vegas対応ここから
$(function() {
$('#vegas-slide').vegas({
slides:[
  
    { src: 'https://cdn.pixabay.com/photo/2016/12/28/17/26/book-1936547__480.jpg'},

    { src: 'https://cdn.pixabay.com/photo/2018/03/16/23/19/pattern-3232784__480.jpg'},
    { src: 'https://cdn.pixabay.com/photo/2015/10/23/12/47/prague-1002963__480.jpg'},
   
    { src: 'https://media.istockphoto.com/photos/tourists-sitting-near-campfire-under-starry-sky-picture-id1213691432?b=1&k=6&m=1213691432&s=170667a&w=0&h=IZYW6cUQYRyeTUcWta1a5Rxu6ULG728AzY-6JClQACE='},

   
    { src: 'https://media.istockphoto.com/photos/montmartre-steps-paris-picture-id1037992464?k=6&m=1037992464&s=612x612&w=0&h=yldWcdI4Dxb52IWoGmISQjkrL6gRCs-WMub2HJRgjZs='},

   
   
    { src: 'https://cdn.pixabay.com/photo/2018/02/13/23/41/nature-3151869__340.jpg'},
    { src: 'https://cdn.pixabay.com/photo/2016/01/22/19/33/aurora-borealis-1156479__480.jpg'},
    { src: 'https://cdn.pixabay.com/photo/2016/02/19/11/53/book-1210030__480.jpg'},
    { src: 'https://cdn.pixabay.com/photo/2016/01/19/17/38/camels-1149803__480.jpg'},
    { src: 'https://media.istockphoto.com/photos/teamwork-friendship-hiking-help-each-other-trust-assistance-in-of-picture-id1255203350?b=1&k=6&m=1255203350&s=170667a&w=0&h=qbRqFnf9pH2JZieaAur7dUw5hjoKjS2ae3Cd4yCoMFg='},
    { src: 'https://cdn.pixabay.com/photo/2013/12/13/04/34/world-227747__480.jpg'},

],
 overlay: 
 './js/overlays/06.png', //フォルダ『overlays』の中からオーバーレイのパターン画像を選択
        transition: 'fade', //スライドを遷移させる際のアニメーション
        transitionDuration: 4000, //スライドの遷移アニメーションの時間
        delay: 10000, //スライド切り替え時の遅延時間
        animation: 'kenburns', //スライド表示中のアニメーション
        animationDuration: 20000, //スライド表示中のアニメーションの時間
        preload:	false,
    });

});

// vegasここまで

  </script>
</body>

</html>