<?php 
$usuario = 'user';
$senha = 'senha';
?>
<!DOCTYPE html>
    <html>
    <head>
        <style>
            ul{
                list-style:none;

            }
            a{
                text-decoration: none;
                color:#fff;
                font-size:20px;
                line-height: 1.3;
            }
            body {
                background-color: #b82251;
                font-family: 'Montserrat', sans-serif;
                text-align: center;
                color: #ffffff;
                margin: 0;
                padding: 0;
            }
            
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            
            form {
                width: 300px;
                padding: 40px 20px;
                background-color: #FFFFFF;
                border-radius: 8px;
                color: #000000;
                margin: 0 auto; /* Centraliza horizontalmente */
            }
            
            input[type="text"],
            input[type="password"] {
                border-radius: 8px;
                margin: 0;
                display: block;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.875rem;
                height: 2.3125rem;
                margin: 0 0 1rem 0;
                padding: 0.5rem;
                width: 100%;
                box-sizing: border-box;
                transition: border-color 0.15s linear, background 0.15s linear;
            }
            
            input[type="submit"] {
                background-color: #b82251;
                color: #FFFFFF;
                border: none;
                border-radius: 8px;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            
            input[type="submit"]:hover {
                background-color: #991f42;
            }
        </style>
        <title>Download</title>
    </head>
    <body>
        <div class="container">
            <div>

<?php
if (isset($_POST['usuario']) && isset($_POST['senha']) && $_POST['usuario'] == $usuario && $_POST['senha'] == $senha) {
    if ($handle = opendir('../../../csv')) {
        $arquivos = array();
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && pathinfo($entry, PATHINFO_EXTENSION) == "csv") {
                $arquivos[] = $entry;
            }
        }
        closedir($handle);
        
        sort($arquivos); // Ordena os arquivos em ordem alfabética

        echo "<ul>";
        foreach ($arquivos as $entry) {
            echo "<li><a href='download.php?arquivo=$entry&usuario=".$_POST['usuario']."&senha=".$_POST['senha']."'>$entry</a></li>";
        }
        echo "</ul>";
    }
} else {
    ?>
    <img src="https://indice.legislabrasil.org/img/marca.png">
    <?php
    if (isset($_POST['usuario']) || isset($_POST['senha'])) {
        echo "<h2>Credenciais incorretas.</h2>";
    } else {
        echo "<h2>Por favor, faça login para acessar a lista de arquivos.</h2>";
    }
    ?>
    <form method="post">
        <input type="text" id="usuario" name="usuario" placeholder="Usuário">
        <input type="password" id="senha" name="senha" placeholder="Senha">
        <input type="submit" value="Entrar">
    </form>
<?php
}
?>
        </div>
    </body>
</html>