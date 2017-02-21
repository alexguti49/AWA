<?php 
/******************************************************************************************************************************************
/*function encriptar($cadena){
    $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
    return $encrypted; //Devuelve el string encriptado
}
 
function desencriptar($cadena){
     $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decrypted;  //Devuelve el string desencriptado
}*/
/******************************************************************************************************************************************
/******************************************************************************************************************************************
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9 ( check your PHP version for function definition changes )
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 * use at your own risk
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
//declare encrypt_decrypt();
function encrypt_decrypt($action, $string) {
	
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'Awa-KEY';
    $secret_iv = 'Awa-IV';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
/******************************************************************************************************************************************/
$nombre = encrypt_decrypt('encrypt','Alexander');
$apellido = encrypt_decrypt('encrypt','Intriago');
$usuario = encrypt_decrypt('encrypt',"ALEX");
$texto = encrypt_decrypt('encrypt','xdjalex@gmail.com');

echo "USUARIO = $usuario\n";
echo "NOMBRE = $nombre\n";
echo "APELLIDO = $apellido\n";
echo "TEXTO = $texto\n";

	$claveC = "1234";
	//$clave = encrypt_decrypt('encrypt',$claveC);
	$salt = ('$a*l#e%x|');
 	$clave_encriptada = sha1(md5($salt.$claveC));
	echo "CLAVE = $clave_encriptada";
/****************************** EJEMPLO ********************************
$plain_txt = "This is my plain text";
echo "Plain Text = $plain_txt\n";

$encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
echo "Encrypted Text = $encrypted_txt\n";

$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
echo "Decrypted Text = $decrypted_txt\n";

if( $plain_txt === $decrypted_txt ) echo "SUCCESS";
else echo "FAILED";

echo "\n";*/
/************************************************************************/
?>