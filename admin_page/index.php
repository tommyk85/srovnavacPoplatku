<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">
<title>Srovnávač - administrace</title>
</head>

<?php
session_start();

if(isset($_POST['heslo']) && $_POST['heslo']==='!f=VjmF&*Ob$'){
$_SESSION['login'] = true;
header('location:admin.php');
}
?>



<body onload="document.login.heslo.focus()">
<FORM name="login" method="POST" action="">
Heslo: <input type='password' name='heslo' size=6>
</form>

                                                  
</BODY>
</HTML>
