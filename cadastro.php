<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="estilo/estilo.css">

</head>
<body>
        <h1 id="titulo">-Sitema de CRUD-</h1>
        <h1 id="cabecalho">Pagina de Cadastro | <a id="posCabecalho"href="index.php" >Listar Usuarios</a> <br/></h1>

        <form action="dados.php" method="post" enctype="multipart/form-data" act>
     
 
 
    <fieldset>
        <legend>Cadastro Inicial</legend>
     <label>Nome do usuário.</label><br/>
        <input id="formulario" type="text" name="nome" placeholder="Crie um nome de usuário" /><br/>
    
    
    <label>Email</label><br/>
        <input id="formulario" type="email" name="email" placeholder="Insira um email" /><br/>
   

    
    <label>Senha.</label><br/>
        <input id="formulario"type="password" name="senha" placeholder="Crie uma senha" /><br/>
    
    
    
     <label>Foto</label>
     <br/>
     <img id="iconeCam" src="icones/camera.png">

     
        <input type="file" name="foto" accept="image/*"/>
        <br/>
        </span>
    <button type="submit" name="salvar">Salvar !
        </button>

        </fieldset>
        
    

</form>


</body>
</html>