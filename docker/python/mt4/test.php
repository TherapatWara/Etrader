<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $myfile = fopen("result.txt", "r") or die("Unable to open file!");
    echo fread($myfile,filesize("result.txt"));
    fclose($myfile);
    ?>
    <h1></h1>
</body>
</html>