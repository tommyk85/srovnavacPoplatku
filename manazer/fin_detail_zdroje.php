<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Moje finance-overeni zadanych udaju</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size=4>

  
                                     
<?php
                                        
If (!isset($_POST['next-detail_zdroje']) || $_POST['next-detail_zdroje'] != 'Pokracuj') 
die ('Neplatny pokus.');

//   DEFINICE PROMENNYCH


$nazev = str_replace(' ','_',Trim($_POST['zdroj_nazev']));
$den = str_replace(' ','',Trim($_POST['zdroj_den']));
$mena = $_POST['zdroj_mena'];
$ucet = $_POST['zdroj_ucet'];
$mzda = str_replace(' ','',Trim($_POST['zdroj_mzda']));


If ($_POST['zdroj_typ'] == 'aktivni')
{
$prefer = $_POST['zdroj_prefer'];
//str_replace(' ', '',$_POST['ucet_predcisli']).' - '.str_replace(' ', '',$_POST['ucet_cislo']).' / '.$_POST['ucet_kod_banky'];
?>
<form action='fin_potvrzeni_zdroje.php' method='POST'>

<INPUT type='hidden' name='typ' value='aktivni'>
<TABLE WIDTH=400 BORDER=1>

<CAPTION><B>Kontrola vstupnich dat noveho AKTIVNIHO zdroje</B></CAPTION>
<TR>
<TH>Nazev zdroje</TH>
<TH>Hlavni zdroj</TH>
<TH>Vyplata ke dni</TH>
<TH>Vyplata v mene</TH>
<TH>Hruba mes. mzda</TH>
<TH>Vyplata na ucet</TH>


</TR>


<TR><TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?>
<input type='hidden' name='nazev' value='<?php echo $nazev; ?>'></TD>

    <TD ALIGN='CENTER' NOWRAP><?php if($prefer == 1){echo 'Ano';} else echo 'Ne'; ?>
<input type='hidden' name='prefer' value='<?php echo $prefer; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $den; ?>
<input type='hidden' name='den' value='<?php echo $den; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?>
<input type='hidden' name='mena' value='<?php echo $mena; ?>'></TD>

    <TD ALIGN='CENTER' NOWRAP><?php echo $mzda; ?>
<input type='hidden' name='mzda' value='<?php echo $mzda; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $ucet; ?>
<input type='hidden' name='ucet' value='<?php echo $ucet; ?>'></TD>


</TR>

</TABLE>


<?php
}

If ($_POST['zdroj_typ'] == 'pasivni')
{
$varianta = $_POST['zdroj_varianta'];
$platce = $_POST['zdroj_platce'];

?>

<form action='fin_potvrzeni_zdroje.php' method='POST'>

<INPUT type='hidden' name='typ' value='pasivni'>
<TABLE WIDTH=400 BORDER=1>

<CAPTION><B>Kontrola vstupnich dat noveho PASIVNIHO zdroje</B></CAPTION>
<TR>
<TH>Nazev zdroje</TH>
<TH>Typ zdroje</TH>
<TH>Jmeno platce</TH>
<TH>Prijem ke dni</TH>
<TH>Prijem v mene</TH>
<TH>Mesicni prijem</TH>
<TH>Prijem na ucet</TH>


</TR>


<TR><TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?>
<input type='hidden' name='nazev' value='<?php echo $nazev; ?>'></TD>

    <TD ALIGN='CENTER' NOWRAP><?php echo $varianta; ?>
<input type='hidden' name='varianta' value='<?php echo $varianta; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $platce; ?>
<input type='hidden' name='platce' value='<?php echo $platce; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $den; ?>
<input type='hidden' name='den' value='<?php echo $den; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?>
<input type='hidden' name='mena' value='<?php echo $mena; ?>'></TD>

    <TD ALIGN='CENTER' NOWRAP><?php echo $mzda; ?>
<input type='hidden' name='mzda' value='<?php echo $mzda; ?>'></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $ucet; ?>
<input type='hidden' name='ucet' value='<?php echo $ucet; ?>'></TD>


</TR>

</TABLE>


<BR>

<?php
}

?>

<input type=button onclick="history.back()" value="Zpět"> 
<input type='submit' name='next-potvrzeni_zdroje' value='Pokracuj'>


</FORM>
</font></center>
</body>
</html>