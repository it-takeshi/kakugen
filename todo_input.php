<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TODO入力</title>
  <style>

  </style>
</head>
<body>

<form action="todo_create.php" method="POST">
    <fieldset>
      <legend>目標orやること</legend>
      <a href="todo_read.php">目標orやること一覧</a>
      <div>
        todo: <input type="text" name="todo">
      </div>
    
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form> 

  </body>

</html>