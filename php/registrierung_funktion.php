<?php
$error = false;

  if(isset($_POST['fbenutzername']) and isset($_POST['fpasswort1']) and isset($_POST['fpasswort2']) and isset($_POST['femail'])){
  if(empty ($_POST['fbenutzername']) or empty($_POST['fpasswort1']) or empty( $_POST['fpasswort2']) or empty($_POST['femail'])){

    echo "fehlende Eingabe!";
    $error = true;
  }
  if (!($_POST['fdsgelesen']))
  {
    echo "<script>alert('Datenschutzbestimmung akzeptieren!');</script>";
    $error = true;
  }
  if ($_POST['fpasswort1'] != $_POST['fpasswort2'])
  {
	echo "<script>alert('Passwörter stimmen nicht überein!');</script>";
    $error = true;
  }

	$vorname=$_POST['fvorname'];
	$nachname=$_POST['fnachname'];
	$benutzername=$_POST['fbenutzername'];
	$passwort1=$_POST['fpasswort1'];
	$passwort2=$_POST['fpasswort2'];
	$email=strtolower($_POST['femail']);
	$dsgelesen=$_POST['fdsgelesen'];
	$teilnehmer=$_POST['fteilnehmer'];
	$campe=$_POST['fcamp'];
	$jahr=$_POST['fjahr'];

  $anz=strlen($_POST['fpasswort1']);

  if ($anz<6)
  {
    echo "<script>alert('Passwort mit mindestens 6 Zeichen verwenden!');</script>";
    $error = true;
  }

  $vorname = $_POST["fvorname"];
  $nachname = $_POST["fnachname"];
  $benutzer='root';
  $adminpasswort='';
  $server='localhost';
  $datenbankname='wintercamp';

  $ok=mysqli_connect($server,$benutzer,$adminpasswort,$datenbankname);

    $sqli="SELECT Count(nID) AS anz FROM nutzer WHERE benutzername='".$benutzername."'";

	$erg1 = 0;
    $erg1=mysqli_fetch_row(mysqli_query($ok,$sqli))[0];

    if($erg1 != 0)
    {
      echo "<script>alert('Benutzername ist bereits vergeben!');</script>";
      $error = true;
    }

    $sqli="SELECT Count(nID) AS anz FROM nutzer WHERE eMail='".$email."'";

	$erg2 = 0;
    $erg2=mysqli_fetch_row(mysqli_query($ok,$sqli))[0];

    if($erg2 != 0)
    {
      echo "<script>alert('Email wurde bereits verwendet!');</script>";
      $error = true;
    }
    $camp=$campe . " " .$jahr;

	if ($teilnehmer)
	{
		$rID=2;
	}
		else $rID=3;

	$userpasswort=hash("sha512",$passwort1);

	if (!$error)
	{
	$sqli="INSERT INTO nutzer (nachname,vorname,benutzername,eMail,passwort,rID,teilnahme) VALUES('".$nachname."','".$vorname."','".$benutzername."','".$email."','".$userpasswort."','".$rID."','".$camp."')";
	  $query_result= mysqli_query($ok,$sqli);

    header('location: ./logIn.php'); #Bitte noch den richtigen Link eingeben
    exit(1);
	}
	else echo ".$error.";
  }
?>