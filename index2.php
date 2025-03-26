<?php
require 'vendor/autoload.php';
 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
 
$app = AppFactory::create();
 
$usuarios = [];
 
$app->post('/usuarios', function (Request $request, Response $response, $args) use (&$usuarios) {
    $dados = $request->getParsedBody();
 
    if (!isset($dados['login']) || !isset($dados['senha'])) {
        $response->getBody()->write(json_encode(["erro" => "Login e senha são obrigatórios."]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
 
    $novoUsuario = [
        'id' => count($usuarios) + 1,
        'login' => $dados['login'],
        'senha' => password_hash($dados['senha'], PASSWORD_DEFAULT),
        'nome' => $dados['nome'] ?? null,
        'perfil' => $dados['perfil'] ?? null,
    ];
 
    $usuarios[] = $novoUsuario;
    $response->getBody()->write(json_encode($novoUsuario));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});
 
$app->get('/usuarios', function (Request $request, Response $response, $args) use ($usuarios) {
    $response->getBody()->write(json_encode(array_slice($usuarios, 0, 5)));
    return $response->withHeader('Content-Type', 'application/json');
});
 
$app->delete('/usuarios/{id}', function (Request $request, Response $response, $args) use (&$usuarios) {
    $id = (int)$args['id'];
 
    foreach ($usuarios as $index => $usuario) {
        if ($usuario['id'] === $id) {
            array_splice($usuarios, $index, 1);
            $response->getBody()->write(json_encode(["mensagem" => "Usuário removido com sucesso."]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
 
    $response->getBody()->write(json_encode(["erro" => "Usuário não encontrado."]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});
 
$app->run();
 