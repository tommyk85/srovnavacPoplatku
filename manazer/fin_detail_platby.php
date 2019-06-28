<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Overeni zadanych udaju</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="5">
<?php
echo 'Platba ke dni <B>'.$_POST['platbaKeDni'].'</B> za ucelem <B>'.$_POST['ucelTransakce'].'</B> pro <B>'.$_POST['prijemce'].'</B>. Castka je <B>'.$_POST['castka'].'</B> Kc.<BR>';
echo '<form action="fin_zadani_platby.php"> <input type="submit" value="Potvrdit">';
?>

</form>
</font></center>
</body>
</html>
