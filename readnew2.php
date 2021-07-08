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
// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる.

//  // 参照はSELECT文!
// $sql = 'SELECT * FROM word_table ORDER BY id ASC LIMIT 30'; 
$sql = 'SELECT * FROM word_table WHERE date = current_date()';

$stmt = $pdo->prepare($sql); 
$status = $stmt->execute();

if ($status==false) {
$error = $stmt->errorInfo(); exit('sqlError:'.$error[2]);
//   // 失敗時􏰂エラー出力

} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC); $output = "";
  foreach ($result as $record) {
  // $output .= "<tr>";
  // $output .= "<td>{$record["word"]}</td>";
  // $output .= "<td>{$record["name"]}</td>"; 
  // $output .= "<td>{$record["trivia"]}</td>"; 
  // $output .= "</tr>";
  $output .= "<tr>";
  $output1 .= "<td>{$record["word"]}</td>";
  $output2 .= "<td>{$record["name"]}</td>"; 
  $output3 .= "<td>{$record["trivia"]}</td>"; 
  $output .= "</tr>";

  } 
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>格言</title>
  <link rel="stylesheet" type="text/css" href="css/vegas.min.css">
  <link rel="stylesheet" href="">
    <style>
 /* vegas対応ここから */
html,body{
        margin: 0;
        padding: 0;
        /* background-color: black; */
    }

    .visual{
        width: 65%;
        height: 70vh;
    }
/* vegas対応ここまで */
/* 格言ここから */
#output{
  color:#fff;
  font-family: "Noto Serif JP","YuMincho","Yu Mincho","游明朝体","ヒラギノ明朝 ProN","Hiragino Mincho ProN",serif;
}
#output1{
  position: absolute;
  left:  50px;                
  top: 10px;    
}
#output2{
  position: absolute;
  left:  70px;                
  top: 60px;    
}
#output3{
  position: absolute;
  left:  80px;                
  top: 90px;    
}
/* 格言ここまで */
/* バック表示セレクトここから */
#select_color{
  position: absolute;
  left: 1100px;                
  top: 600px;
}
/* バック表示セレクトここから */
/*カレンダーここから*/
        #calendar{
          position: absolute;
          left:  900px;                
          top: 60px; 
          color: #fff;     
        }
        .top {
            border-bottom: 2px solid gray;
        }
        .top, .day {
            display: flex;
            align-items: flex-end;
        }
        .day {
            justify-content: center;
        }
        .mm {
            width: 50px;
            font-size: 40px;
            font-weight: bold;
        }
        .eng_m {
            font-size: 25px;
            font-weight: bold;
            color: blue;
        }
        .YYYY {
            width: 200px;
            text-align: right;
            font-size: 25px;
        }
        .week{
            margin-top: 16px;
            text-align: center;
            font-size: 25px;
    
        }
        .dd {
            font-size: 150px;
        }
        .nichi {
            font-size: 60px;
        }
        .week, .day {
          <?php 
              if (date("w") == 0) { echo "color: red;"; }
              if (date("w") == 6) { echo "color: blue;"; }
          ?>
        }
  /* カレンダーここまで */
  /* タイマーここから */
  .timer {
    margin: 0 auto;
    margin-top: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 15px;
    width: 400px;
    position: absolute;
          left:  50px;                
          top: 300px; 
    color: #fff;
  }
/* タイマーここまで */
</style>
<!-- styleここまで -->
</head>

<body>
<!-- HTMLここから -->
<!-- vegasここから -->
<div id="vegas-slide" class="visual"></div>
<!-- 格言表示ここから -->
  <div id="kakugen">
  <div id="output">
      <h2 id="output1">『<?= $output1 ?>』</h2>
      <p id="output2"><?= $output2 ?></p>
      <p id="output3"><?= $output3 ?></p>
  </div>
  </div>
<!-- 格言表示ここまで -->

<!-- 日めくりカレンダーここから -->

<div id="calendar">
      <div class="top">
      <div class="mm"><?php echo date("n"); ?></div>
            <!-- <div class="eng_m"><?php echo date("n"); ?></div> -->
      <div class="YYYY"><?php echo date("Y"); ?>年</div>
            
            
      </div>
      <?php $week = array("日","月","火","水","木","金","土"); ?>
      <div class="week"><?php echo $week[date("w")]; ?>曜日</div>
      <div class="day">
        <div class="dd"><?php echo date("j"); ?></div>
        <div class="nichi">日</div>
      </div>
    </div>
</div>
<!-- 日めくりカレンダーここまで -->

<!-- セレクト 背景色変更 ここから-->
<div id="select_color">
<form name="form1" action="" metod="">
        <select name="color" onChange="changecolor()">
        <option value="#000000"> black</option>
        <option value="#ffffff"> White </option>
        <option value="#ffcccc"> Red </option>
        <option value="#ccccff"> Blue </option>
        <option value="#778899"> Gray </option>
        <option value="#C0C0C0"> Silver </option>

        </select>
</form>
</div>
<!-- セレクト 背景色変更 ここまで-->
<!-- タイマーここから -->
<div class="timer">
 
 <h2><span class="badge badge-primary">残りの日数</span></h2>

 <form>
   <div class="form-group">
     <label class="bmd-label-floating">終了日時</label>
     <input type="date" id="date1">
   </div>
   <div class="form-group">
     <label class="bmd-label-floating">開始日時</label>
     <input type="date" id="date2">
   </div>
 </form>

 <button type="button" onclick="hoge()" class="btn btn-raised btn-primary">
   click
 </button>

</div>

<!-- タイマーここまで -->
<!-- HTMLここまで -->


<!-- JSここから -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

// セレクト 背景色ここから
function changecolor(){
          document.bgColor = document.form1.color.value;
    }
// セレクト 背景色ここまで

// タイマーここから
function hoge() {
 
 // フォームの入力を取得
 var date1 = document.getElementById('date1').value;
 var date2 = document.getElementById('date2').value;

 // date型に変換
 date1 = new Date(date1);
 date2 = new Date(date2);

 // 計算　86400000ミリ秒(1日)
 var result = (date1 - date2) / 86400000; 
 
 // 表示用要素取得
 var obj = document.getElementsByClassName("badge")[0];    
 // 結果表示
 obj.textContent = result;

}
// タイマーここまで
  </script>
</body>

</html>