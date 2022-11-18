<?php
const ERROR_REQUIRED = 'Veuillez renseigner une todo';
const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 caractères';

$filename = __DIR__ . "/data/todos.json";
$error = '';
$todo = '';
$todos = [];

if (file_exists($filename)) {
  $data = file_get_contents($filename);
  $todos = json_decode($data, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $todo = $_POST['todo'] ?? '';

  if (!$todo) {
    $error = ERROR_REQUIRED;
  } else if (mb_strlen($todo) < 5) {
    $error = ERROR_TOO_SHORT;
  }

  if (!$error) {
    $todos = [...$todos, [
      'name' => $todo,
      'done' => false,
      'id' => time()
    ]];
    file_put_contents($filename, json_encode($todos));
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
        <form class="todo-form" action="" method="POST">
          <input value="<?= $todo ?>" name="todo" type="text">
          <button class="btn btn-primary">Ajouter</button>
        </form>
        <?php if ($error) : ?>
          <p class="text-danger"><?= $error ?></p>
        <?php endif; ?>
        <ul class="todo-list">
          <?php foreach ($todos as $t) : ?>
            <li class="todo-item <?= $t['done'] ? 'low-opacity' : '' ?>">
              <span class="todo-name"><?= $t['name'] ?></span>
              <a href="./edit-todo.php?id=<?= $t['id'] ?>">
                <button class="btn btn-primary btn-small">Valider</button>
              </a>
              <button class="btn btn-danger btn-small">Supprimer</button>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>
</body>

</html>