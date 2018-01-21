<?php
header('X-Frame-Options: GOFORIT');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<script>
    var myWindow;
    function myFunction() {
        myWindow = window.open("https://www.facebook.com/photo.php?fbid=10214889748302477&set=a.10200953923195559.1073741825.1390475523&type=3&theater", "", "width=1000,height=500");
    }
    //10214889748302477
    function closeWin() {
        myWindow.close();   // Closes the new window
    }
</script>
<button onclick="myFunction()">Try it</button>
<button onclick="closeWin()">close</button>
</body>
</html>