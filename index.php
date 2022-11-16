<?php
const ERROR_REQUIRED = 'Veuillez renseigner une todo';
const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 caractères';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $todo = $_POST['todo'] ?? '';

  if (!$todo) {
    $error = ERROR_REQUIRED;
  } else if (mb_strlen($todo) < 5) {
    $error = ERROR_TOO_SHORT;
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>
  <link rel="stylesheet" href="./public/css/style.css">
  <script refer src="./public/js/index.js"></script>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
      <div class="todo-container">
        <h1>Ma Todo</h1>
        <form class="todo-form" action="/" method="post">
          <input name="todo" type="text">
          <button class="btn btn-primary">Ajouter</button>
        </form>
        <div class="todo-list"></div>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>
</body>

</html>