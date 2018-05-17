<?php
 error_reporting( ~E_NOTICE ); // mostrar erro
 require_once 'chave_bd.php';
 
 if(isset($_POST['salvar']))
 {
  $username = $_POST['nome'];// nome do usuario
  $usermail = $_POST['email'];// email do usuario
  $userpasscrypt = $_POST['senha'];// senha
  $userpass = sha1(md5($userpasscrypt));

  $imgFile = $_FILES['foto']['name'];
  $tmp_dir = $_FILES['foto']['tmp_name'];
  $imgSize = $_FILES['foto']['size'];
  
  
  if(empty($username)){
   $errMSG = "Digite um nome de usuario";
   echo "$errMSG";
  }
  else if(empty($usermail)){
   $errMSG = "Digite um endereço de email";
   echo "$errMSG";
  }
  else if(empty($userpass)){
   $errMSG = "Digite uma senha";
   echo "$errMSG";
  }
  else if(empty($imgFile)){
   $errMSG = "Selecione uma foto";
   echo "$errMSG";
  }
  else
  {
   $upload_dir = 'user_images/'; // diretorio de envio
 
   $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // le a extensao da imagem
  
   // validação da extensão da imagem
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // extensões que são válidas
  
   // renomeia o arquivo de forma randomica 
   $userpic = rand(1000,1000000).".".$imgExt;
    
   // permite apenas extensões validas
   if(in_array($imgExt, $valid_extensions)){   
    // define o tamanho maximo do arquivo
    if($imgSize < 5000000)    {
     move_uploaded_file($tmp_dir,$upload_dir.$userpic);
    }
    else{
     $errMSG = "Desculpe, mas sua foto excede o tamanho máximo de 5mb";
     echo "$errMSG";
    }
   }
   else{
    $errMSG = "desculpe, apenas aquivos JPG, JPEG, PNG & GIF são permitidos."; 
    echo "$errMSG"; 
   }
  }
  
  
  // se não tiver nenhum erro irá seguir em frente
  if(!isset($errMSG))
  {
   $stmt = $DB_con->prepare('INSERT INTO sistema(nome,email,senha,foto) VALUES(:uname, :umail, :upass, :upic)');
   $stmt->bindParam(':uname',$username);
   $stmt->bindParam(':umail',$usermail);
   $stmt->bindParam(':upass',$userpass);
   $stmt->bindParam(':upic',$userpic);
   
   if($stmt->execute())
   {
    $successMSG = "Os dados foram inseridos com sucesso ...<br/> aguarde...<br/> redirecionando para a pagina principal";
    echo "$successMSG";
    header("refresh:5;index.php"); // redireciona para outra pagina depois de 5 segundos.
   }
   else
   {
    $errMSG = "Ocorreu um erro durante a inserção....";
    echo "$errMSG";
   }
  }
 }
?>