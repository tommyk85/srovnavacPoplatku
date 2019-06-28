<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>Zadání nové platby</title>

</head>
<body bgcolor='#FFFFFF' text='#000000'>

<script type='text/javascript'>

function platbaTypCheck(){

var frek = document.getElementsByName("frekvence")[0];
// var fPrav=document.getElementById("prav");
// var fJedn=document.getElementById("jedn");
var select=document.getElementById("typPlatby").childNodes;
 
  for(var i = 0; i < select.length; i++){
    if (select[i].selected===true) {
      switch(select[i].value){
      case "tp":
      frek.readOnly = false;
      frek.value = 1;
      break;
      
      case "jp":
      case "js":
      frek.readOnly = true;
      frek.value = 0;
      break;
      
      
      default:
      console.log("neznamy typ");      
      }
      
    break;  
    }
    
    else{continue;}
  }
}                                                                                                 

</script>

<center>
<font face='Arial CE, Arial' size='5'>
<!-- <h1>Zadání nové platby</h1>
Kategorie:
<select id='typPlatby' style='font-size:20px;' onChange="formCheck()">
<option value='prav'>pravidelná
<option value='jedn'>jednorázová
</select> -->

<form action='fin_zadani_platby.php' method='POST'>
<TABLE BORDER='1'><caption>Zadání nové platby</caption>
<TR>
  <TD>Typ platby:</TD>
  <TD><select name='typPlatby' id='typPlatby' onChange='javascript:platbaTypCheck()'>
      <option value='tp'>Trvalý příkaz
      <option value='jp'>Jednorázová platba
      <option value='js'>Jednorázová platba (šablona)
      <option value='at' disabled>Automatický převod
      <option value='in' disabled>Inkaso
      </select>
  </TD>
</TR>
<TR>
  <TD>Platba ke dni:</TD>
  <TD><input type='number' name='platbaKeDni' /></TD>
</TR>
<TR>
  <TD>Termín první platby:</TD>
  <TD><input type='text' name='datumPrvniPlatby' size='6'>(yyyymm)</TD>
</TR>
<TR>
  <TD>Ucel transakce:</TD>
  <TD><input type='text' name='ucelTransakce' size='20'></TD>
</TR>
<TR>
  <TD>Prijemce:</TD>
  <TD><input type='text' name='prijemce' size='20'></TD>
</TR>
<TR>
  <TD>Castka:</TD>
  <TD><input type='text' name='castka' size='6'></TD>
</TR>
<TR>
  <TD>Frekvence:</TD>
  <TD><input type='number' name='frekvence' size=6 value=1 /></TD>
</TR>
<TR>
  <TD>VS:</TD>
  <TD><input type='text' name='vs' maxlength=10 size=10></TD>
</TR>
<TR>
  <TD>SS:</TD>
  <TD><input type='text' name='ss' maxlength=10 size=10></TD>
</TR>
<TR>
  <TD>KS:</TD>
  <TD><input type='text' name='ks' maxlength=4 size=4></TD>
</TR>
<TR>
  <TD>Zpráva pro příjemce:</TD>
  <TD><input type='text' name='zprava' size='20'></TD>
</TR>
<TR>
  <TD>Číslo účtu příjemce:</TD>
  <TD><input type='text' name='prijemceUcetPredC' value='000000' maxlength=6 size=6>-<input type='text' name='prijemceUcetCislo' maxlength=10 size=10 />/<input 
  type='text' name='prijemceBanka' maxlength=4 size=4></TD>
</TR>
<TR><TD><TD ALIGN='right'><input type='submit' name='uloz' value='Zadat'></TD></TD></TR>
</TABLE>
</form>



</font></center>
</body>
</html>
