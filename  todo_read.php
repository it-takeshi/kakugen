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
$sql = 'SELECT * FROM todo_table';

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
  $output1 .= "<td>{$record["todo"]}</td>";
  // $output2 .= "<td>{$record["name"]}</td>"; 
  // $output3 .= "<td>{$record["trivia"]}</td>"; 
  $output .= "</tr>";
  $output .= "<td>
  <a href='todo_edit.php?id={$record["id"]}'>edit</a>
  </td>";
  $output .= "<td>
  <a href='todo_delete.php?id={$record["id"]}'>delete</a>
  </td>"; 
  $output .= "</tr>";
  }
  // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($record);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>リスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>リスト一覧</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
        <th>todo</th>
              
          <!-- <th>deadline</th>
          <th>todo</th> -->
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>