<?php

require_once 'Usuario.php';


echo "<h2>1. Criando um novo usuário...</h2>";

$novoUsuario = new Usuario();
$novoUsuario->setEmail('durinhodematar7@gmail.com');
$novoUsuario->setSenha('senhaSuperSegura123'); 

if ($novoUsuario->save()) {
    echo "Usuário criado com sucesso! ID: " . $novoUsuario->getId() . "<br>";
} else {
    echo "Falha ao criar usuário (talvez o e-mail já exista?).<br>";
}

echo "<hr>";


echo "<h2>2. Verificando se e-mail existe...</h2>";
$email_para_verificar = 'durinhodematar7@gmail.com';

if (Usuario::checkUser($email_para_verificar)) {
    echo "O e-mail '$email_para_verificar' já está cadastrado.<br>";
} else {
    echo "O e-mail '$email_para_verificar' está disponível.<br>";
}

echo "<hr>";



echo "<h2>3. Tentando autenticar...</h2>";

$email_login = 'durinhodematar7@gmail.com';
$senha_login = 'senhaSuperSegura123'; 

$usuarioLogado = Usuario::checkPass($email_login, $senha_login);

if ($usuarioLogado) {
    echo "Login bem-sucedido!<br>";
    echo "ID do Usuário: " . $usuarioLogado->getId() . "<br>";
    echo "E-mail: " . $usuarioLogado->getEmail() . "<br>";
} else {
    echo "Falha no login. E-mail ou senha inválidos.<br>";
}


$senha_login_errada = 'senhaErrada';
$usuarioFalhou = Usuario::checkPass($email_login, $senha_login_errada);

if (!$usuarioFalhou) {
    echo "Teste de login com senha errada falhou, como esperado.<br>";
}

echo "<hr>";


echo "<h2>4. Buscando usuário pelo ID...</h2>";
$id_para_buscar = 1;
$usuarioEncontrado = new Usuario();
$resultado = $usuarioEncontrado->findById($id_para_buscar);

if ($resultado) {
    echo "Usuário encontrado com ID $id_para_buscar!<br>";
    echo "Email: " . $usuarioEncontrado->getEmail();
} else {
    echo "Usuário com ID $id_para_buscar não encontrado.";
}