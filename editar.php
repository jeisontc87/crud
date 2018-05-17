<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'chave_bd.php';
	
	if(isset($_GET['editar']) && !empty($_GET['editar']))
	{
		$id = $_GET['editar'];
		$stmt_edit = $DB_con->prepare('SELECT nome, email, foto FROM sistema WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
	
	
	
	if(isset($_POST['atualizar']))
 {
  $username = $_POST['nome'];// nome do usuario
  $usermail = $_POST['email'];// email do usuario
  

  $imgFile = $_FILES['foto']['name'];
  $tmp_dir = $_FILES['foto']['tmp_name'];
  $imgSize = $_FILES['foto']['size'];
  
  
  if(empty($username)){
   $errMSG = "Digite um nome de usuario";
   //echo "$errMSG";
  }
  else if(empty($usermail)){
   $errMSG = "Digite um endereço de email";
   //echo "$errMSG";
  }
  /*else if(empty($userpass)){
   $errMSG = "Digite uma senha";
   echo "$errMSG";
  }*/
  else if(empty($imgFile)){
   $errMSG = "Selecione uma foto";
   //echo "$errMSG";
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
     //echo "$errMSG";
    }
   }
   else{
    $errMSG = "desculpe, apenas aquivos JPG, JPEG, PNG & GIF são permitidos."; 
    //echo "$errMSG"; 
   }
  }
  
  
  // se não tiver nenhum erro irá seguir em frente
  if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE sistema 
									     SET nome=:uname, 
										     email=:umail,
										      
										     foto=:upic 
								       WHERE id=:uid');
			$stmt->bindParam(':uname',$username);
  		 	$stmt->bindParam(':umail',$usermail);
   			//$stmt->bindParam(':upass',$userpass);
   			$stmt->bindParam(':upic',$userpic);
   			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Os dados foram atualizados corretamente');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Os dados não puderam ser atualizados";
				echo "$errMSG";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html>
<head>
<meta charset=utf-8" />
<title>editar</title>
<link rel="stylesheet" href="estilo/estilo.css">
</head>
<body>


           
      <h1 id="titulo">-Sitema de CRUD-</h1>

  
      <h1 id="cabecalho">Edição de Perfil | <a id="posCabecalho"href="index.php" >Listar Usuários</a> </h1>



<form method="post" enctype="multipart/form-data" >
	
    
    <?php
	if(isset($errMSG)){        
          echo $errMSG;        
	}
	?>
   
   <fieldset>
        <legend>Editar Perfil</legend> 
	
	
    <label>Nome de usuário.:</label><br/>
    <input id="formulario"type="text" name="nome" value="<?php echo $nome; ?>" required /><br/>
    <label>Email.:</label><br/>
    <input id="formulario"type="text" name="email" value="<?php echo $email; ?>" required /><br/>
	<!--tr>
		<td><label>Senha.:</label></td>
	    <td><input type="text" name="senha" value="<!-?php echo sha1(md5*/($senha)); ?>" required /></td>
    </tr-->

    
   <label >Imagem do perfil.</label><br/>
        	<p><img src="user_images/<?php echo $foto; ?>" height="150" width="150" /></p>
        	<input type="file" name="foto" accept="image/*" /><br/>
        <button type="submit" name="atualizar">Atualizar</button>
        
       <button type="submit"> <a href="index.php">Cancelar </a></button>
        
        
    </fieldset>
</form>





</body>
</html>