<?php

require_once 'mensajeria_configuracion.php';

$w = new WhatsProt($username, /*$identity,*/ $nickname, $debug);
$w->Connect();
$w->LoginWithPassword($password);

$to = $_POST['numero'];
$mensaje = $_POST['texto'];
//$tipo = $_POST['tipo'];

$urlimagen = $_POST['urlimagen'];
$urlaudio = $_POST['urlaudio'];
$urlvideo = $_POST['urlvideo'];

//$w->sendBroadcastMessage($to, $mensaje);
if ($mensaje !== ''){
	$w->sendBroadcastMessage($to, $mensaje);
	//header("Location: index.php");
	}

if ($urlimagen !== ''){
	$w->sendBroadcastImage($to, $urlimagen);
	//header("Location: index.php");
	}

if($urlaudio !== ''){
	$w->sendBroadcastAudio($to, $urlaudio);
	//header("Location: index.php");
	}

if ($urlvideo !== ''){
	$w->sendBroadcastVideo($to, $urlvideo);
	//header("Location: index.php");
	}
			
header("Location: index.php");

//$imageURL = "https://www.chelseafc.com/content/cfc/en/ref/clubs/en/chelsea.img.png";
//$w->sendMessageImage($to, $imageURL);

//$videoURL = "http://luisguti14001.herobo.com/media/video.mp4";
//$w->sendMessageVideo($to, $videoURL);

//$audioURL = "http://luisguti14001.herobo.com/media/ring.mp3";
//$w->sendMessageAudio($to, $audioURL);

//$imageURL = "C:\Users\Alexander\Pictures\folder(2).JPG";
//$audioURL = "http://luisguti14001.herobo.com/media/ring.mp3";
//$audioURL = "http://freemp3.se/music/user_folder/J%20Balvin%20Ay%20Vamos%20J%20Balvin%20Ay%20Vamos%20-%201425363591.mp3";
//$videoURL = "E:\media\video.mp4";

//$w->sendBroadcastMessage($targets, $mensaje);
//$w->sendMessage($to, $mensaje);
//$w->sendMessageImage($to, $imageURL);
//$w->sendMessageImage($to, $imageURL, false, $fsize='99268', $fhash ="LVX3ZB3/aCqWLfk/dPTT7c6nKKkURrhrhAqwsOpZcBw=" /*$caption*/);
//$w->sendMessageImage($to, $imageURL, false, $fsize, $fhash /*$caption*/);

//$w->sendMessageAudio($to, $audioURL, false, $fsize='121729', $fhash, $caption);

//$w->sendMessageVideo($to, $videoURL, $storeURLmedia = false, $fsize = 0, $fhash = "");
//$w->sendVcard($to, $nom, '+593986319399');//: Send a vCard to $to.
//$w->pollMessage();
//$w->WaitForServer();
//$w->WaitForReceipt();// : Wait for the WhatsApp servers to confirm the delivery

//Message($to, $msg): Simply send a regular text message to $to.
//MessageImage($to, $imageURI): Send images by URL or local path (jpg) to $to.
//MessageVideo($to, $videoURI): Send videos by URL or local path (mp4) to $to.
//MessageAudio($to, $audioURI): Send audios by URL or local path (mp3) to $to.
//Location($to, $lng, $lat): Send GPS coordinates to $to
//sendvCard($to, "Alex", '593986319398');//: Send a vCard to $to.
//WaitForReceipt();// : Wait for the WhatsApp servers to confirm the delivery.
//$targets = array("", "");
//$nom = "Alex";

?>
