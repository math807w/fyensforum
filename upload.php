<?php
$date = date("m-d-H-i-s");
$datedir = mkdir("uploads/" . $date, 0777);
$target_dir = "uploads/" . $date . "/";
$file_name = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $file_name;
$tmpname = $_FILES["fileToUpload"]["tmp_name"];
$imagetype = exif_imagetype($tmpname);
$uploadOk = 1;
$success = false;

if($file_name != ""){
    // Tjek om filen er en billedfil
    if($imagetype) {
        // Hvis filen er en billedfil tjekkes filstørrelsen
        if ($_FILES["fileToUpload"]["size"] > 2500000) {
            $uploadOk = 0;
        }
        else{
            $uploadOk = 1;
        }
    }

    if ($uploadOk == 0) {
        echo "Filen blev ikke uploadet.";
    // Hvis alt er ok, prøv da at uploade filen
    } else {
        if(move_uploaded_file($tmpname, $target_file)){ 
        $success = true;
        }
    }
}

$name = "NAVN:" . PHP_EOL . $_POST['navn'] . PHP_EOL . PHP_EOL;
$tel = "TELEFON:" . PHP_EOL . $_POST['telefon'] . PHP_EOL . PHP_EOL;
$mail = "E-MAIL:" . PHP_EOL . $_POST['email'] . PHP_EOL . PHP_EOL;
$text = "TEKST:" . PHP_EOL . $_POST['tekst'] . PHP_EOL . PHP_EOL;
$fp = fopen($target_dir . 'data.txt', 'a');

if($_POST['navn'] != ""){
fwrite($fp, $name);
}else{
fwrite($fp, "NAVN:" . PHP_EOL . "(TOM)" . PHP_EOL . PHP_EOL);
}

if($_POST['telefon'] != ""){
fwrite($fp, $tel);
}else{
fwrite($fp, "TELEFON:" . PHP_EOL . "(TOM)" . PHP_EOL . PHP_EOL);
}

if($_POST['mail'] != ""){
fwrite($fp, $mail);
}else{
fwrite($fp, "E-MAIL:" . PHP_EOL . "(TOM)" . PHP_EOL . PHP_EOL);
}

if($_POST['tekst'] != ""){
fwrite($fp, $text);
}else{
fwrite($fp, "TEKST:" . PHP_EOL . "(TOM)" . PHP_EOL . PHP_EOL);
}

fclose($fp);

if($success == true){
  echo "<script language='javascript'>\n";
  echo "alert('Info samt filen " . $file_name . " blev uploadet og gemt.'); window.location.href='https://mmd.mathiashammer.dk/fyensforum/delhistorie.html';";
  echo "</script>\n";
}else{
  echo "<script language='javascript'>\n";
  echo "alert('Info blev gemt, men ingen blev uploadet.'); window.location.href='https://mmd.mathiashammer.dk/fyensforum/delhistorie.html';";
  echo "</script>\n";
}

?>