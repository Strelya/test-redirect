<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Страница ввода адреса сайта для проверки правильности настройки главного зеркала и редиректов">
    <meta name="author" content="SerdjioStrel">
    <title>Проверка правильности настройки зеркал домена</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
</head>
<?php include_once("check.php"); ?>

<body class="text-center">
<div class="container">
    <form class="form-signin" action="" method="post">
    <img class="mb-4" src="img/logo.svg" alt="" width="116" height="80">
    <h1 class="h3 mb-3 font-weight-normal">Укажите имя сайта</h1>
    <label for="inputDomain" class="sr-only">Domain name</label>
    <?php
    if(isset($_REQUEST['Domain']))
    { ?>
        <input type="text" id="inputDomain" name="Domain" class="form-control" required autofocus value="<?=$_POST["Domain"]?>">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Проверить</button>

        <?php echo check_redirect ($_POST["Domain"]);?>

    <?php } else { ?>
        <input type="text" id="inputDomain" name="Domain" class="form-control" placeholder="Domain name" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Проверить</button>
    <?php
    }
    ?>
    </form>
</div>
</body>
</html>