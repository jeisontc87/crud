 <?php

	require_once 'chave_bd.php';

	

	
	if(isset($_GET['apaga_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT foto FROM sistema WHERE id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['apaga_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['foto']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM sistema WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['apaga_id']);
		$stmt_delete->execute();
		
		header("Location: index.php");
	}

?>
<!DOCTYPE html>
<head>
<meta charset=utf-8" />

<title>Meu Crud</title>
<link rel="stylesheet" href="estilo/estilo.css">

</head>

<body>


    
		<h1 id="titulo">-Sitema de CRUD-</h1>

	
    	<h1 id="cabecalho">Listar Usuarios | <a id="posCabecalho"href="cadastro.php" >Adicionar novo usuário</a> </h1>
    
    
<br />

<div class="row">
<?php
	
	$stmt = $DB_con->prepare('SELECT id, nome, email, foto FROM sistema ORDER BY id DESC');
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="container">
				<p id="info"><?php echo "NOME :".$nome."<br/>Email  :".$email; ?></p>
				<img id="fotos" src="user_images/<?php echo $row['foto']; ?>" width="250px" height="250px" />
				<p>
				
				<a href="editar.php?editar=<?php echo $row['id']; ?>" title="Clique para editar" onclick="return confirm('Tem certeza que quer editar? ?')"><img id="icones"src="icones/editar.png"></a>
				<a href="?apaga_id=<?php echo $row['id']; ?>" title="Clique para deletar" onclick="return confirm('Tem certeza que quer apagar essa entrada ?')"><img id="icones"src="icones/lixeira.png"></a>
				
				</p>
			</div>       
			<?php
		}
	}
	else
	{
		echo "nenhum arquivo encontrado";
		?>
        
        <?php
	}
	
?>
</div>	









</body>
</html>