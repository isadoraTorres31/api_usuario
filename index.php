<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Projetux\Tarefas\Service;
use Projetux\Math\Service\TarefaService;
use Projetux\info\debug;
use Projetux\Math\Basic;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// middleware é um evento que ocorre antes da requisição chegar na rota.

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});


$app->get('/teste/soma/{num1}/{num2}', function (Request $request, Response $response, array $args) {
    $basic = new Basic();
    $resultado = $basic->soma($args['num1'], $args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefa_service = new TarefaService();
    $tarefas = $tarefa_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('content-type', 'application/json');
});
$app->post('/tarefas', function (Request $request, Response $response, array $args) {
    $paramentos = (array) $request->getParsedBody();
    if (!array_key_exists('titulo', $paramentos) || empty($paramentos['titulo'])) {
        $response->getBody()->write(json_encode([
            "mensagem" => "titulo é obrigatorio"
        ]));
        return $response->withHeader('content-type', 'application/json')->withStatus(400);
    }
    $tarefa = array_merge(['titulo' => '', 'concluido' => false], $paramentos);
    $tarefa_service = new TarefaService();
    $tarefa_service->createTarefa($tarefa);

    return $response->withStatus(201);
});


$app->delete('/tarefas', function (Request $request, Response $response, array $args) {

    return $response->withStatus(204);
});
$app->put('/tarefas', function (Request $request, Response $response, array $args) {
    return $response->withStatus(201);
});

$app->delete('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    return $response->withStatus(204);
});

$app->put('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    if (array_key_exists('titulo', $dados_para_atualizar) && empty($dados_para_atualizar['titulo'])) {
        $response->getBody()->write(json_encode([
            "mensagem" => "titulo é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa_service = new Tarefaservice();
    $tarefa_service->updateTarefa($id, $dados_para_atualizar);

    return $response->withStatus(201);
});



$app->run();
