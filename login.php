<?php 
session_start();

// Если попадает авторизованный значт хочет ливнуть хехе
if (isset($_SESSION['s_login'])) {
    unset($_SESSION['s_login']);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q-Digital</title>
    <link rel="stylesheet" href="/libs/bootstrap.css">
    <link rel="stylesheet" href="/static/style.css">
</head>
<body>
    <?php include("includes/header.php") ?>
    
    <form method="POST" action="/api/index.php" class="form-signin">
        <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
        <label for="inputLogin" class="sr-only">Логин</label>
        <input type="text" id="inputLogin" class="form-control" placeholder="Логин" name="login" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Пароль" name="password" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="requestType" value="LOGIN">Войти</button>
        <p class="mt-3 mb-1 text-muted">Для регистрации просто введите желаемый логин и пароль</p>
    </form>
</body>
</html>