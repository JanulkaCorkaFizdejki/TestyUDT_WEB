
<?php 
require_once("WebSettings/settings.php");
$settings = new WebSettings();
?>

<!doctype html>
<html lang = "pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>404 - Testy UDT</title>
<?php require_once('webElements/app_icons.html'); ?>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class = "main-404">
        <div class = "error-number">
            <h2>404</h2>
            <p>NIE MA TAKIEJ STRONY!</p>
            <a href = "<?php echo $settings -> getBaseDomain(); ?>"><?php echo $settings -> getBaseDomain();?></a>
        </div>
    </div>
</body>
</html>