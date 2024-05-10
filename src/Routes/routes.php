<?php

use Alimix\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alimix\Pdo\Infrastructure\Repository\PdoMovimentacoesRepository;
use Alimix\Pdo\Infrastructure\Repository\PdoTodasMovimentacoesRepository;


$connectionCreator = ConnectionCreator::createConnection();

$repositoryMovimentacoes = new PdoMovimentacoesRepository($connectionCreator);
$repositoryTodasMovimentacoes = new PdoTodasMovimentacoesRepository($connectionCreator);


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/api/todasmovimentacoes')
        handleListagemMovimentacoes($repositoryTodasMovimentacoes);
    if ($_SERVER['REQUEST_URI'] === '/api/movimentacoes')
        handleListagemMovimentacoes($repositoryMovimentacoes);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' &&
    preg_match('/\/api\/movimentacoes\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {

    $idMovimentacao = $matches[1];

    $movimentacao = $repositoryMovimentacoes->BuscarPorId($idMovimentacao);

    if (!empty($movimentacao)) {
        $movimentacaoRemovida = $repositoryMovimentacoes->Remover($movimentacao[0]);

        if ($movimentacaoRemovida) {
            echo json_encode(['status' => 200, 'mensagem' => 'Movimentação removida com sucesso'], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['status' => 500, 'mensagem' => 'Erro ao remover a movimentação'], JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode(['status' => 404, 'mensagem' => 'Movimentação não encontrada'], JSON_PRETTY_PRINT);
    }
    exit;
}

function handleListagemMovimentacoes($repository)
{
    try {
        $movimentacoes = $repository->listar();

        if (!empty($movimentacoes)) {
            echo json_encode(['status' => 200, 'movimentacoes' => $movimentacoes], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['status' => 404, 'mensagem' => 'Nenhuma movimentação encontrada'], JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 500, 'mensagem' => 'Erro ao processar a requisição']);
    }
}
