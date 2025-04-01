<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Base de dados em memória
$usuarios = [
    ["id" => 1, "login" => "user1", "senha" => "1234", "nome" => "Usuário 1", "perfil" => "admin"],
    ["id" => 2, "login" => "user2", "senha" => "1234", "nome" => "Usuário 2", "perfil" => "user"],
    ["id" => 3, "login" => "user3", "senha" => "1234", "nome" => "Usuário 2", "perfil" => "user"],
    ["id" => 4, "login" => "user4", "senha" => "1234", "nome" => "Usuário 2", "perfil" => "user"],
    ["id" => 5, "login" => "user5", "senha" => "1234", "nome" => "Usuário 2", "perfil" => "user"],
    // ... outros usuários
];

// Rota GET para listar usuários
$app->get('/usuarios', function (Request $request, Response $response) use ($usuarios) {
    $response->getBody()->write(json_encode(array_slice($usuarios, 0, 5)));
    return $response->withHeader('Content-Type', 'application/json');
});

// Rota POST para criar usuário
$app->post('/usuarios', function (Request $request, Response $response) use (&$usuarios) {
    $data = $request->getParsedBody();
    
    if (!isset($data['login']) || !isset($data['senha'])) {
        $response->getBody()->write(json_encode(["erro" => "Login e senha são obrigatórios"]));
        return $response->withStatus(400);
    }
    
    $novoUsuario = [
        "id" => count($usuarios) + 1,
        "login" => $data['login'],
        "senha" => $data['senha'],
        "nome" => $data['nome'] ?? '',
        "perfil" => $data['perfil'] ?? 'user'
    ];
    
    $usuarios[] = $novoUsuario;
    $response->getBody()->write(json_encode($novoUsuario));
    return $response->withStatus(201);
});

// Rota DELETE para remover usuário
$app->delete('/usuarios/{id}', function (Request $request, Response $response, array $args) use (&$usuarios) {
    $id = (int)$args['id'];
    $usuarios = array_filter($usuarios, fn($user) => $user['id'] !== $id);
    
    $response->getBody()->write(json_encode(["mensagem" => "Usuário excluído com sucesso"]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
 