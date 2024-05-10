<?php

namespace Alimix\Pdo\Infrastructure\Repository;

use Alimix\Pdo\Domain\Model\Movimentacoes;
use Alimix\Pdo\Domain\Repository\RepositorioMovimentacoes;
use PDO;


class PdoMovimentacoesRepository implements RepositorioMovimentacoes
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function Remover($mov): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM movimentacoes WHERE id = ?");
        $stmt->bindValue(1, $mov->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function Salvar(Movimentacoes $mov): bool
    {
        if ($mov->id() === null)
            return $this->Inserir($mov);

        return $this->Atualizar($mov);
    }

    public function Listar(): array
    {
        $sqlQuery = 'select Id, DataHora, IdCategoria, Valor from Movimentacoes;';
        $smtm = $this->connection->query($sqlQuery);

        return $this->AlimentarListaMovimentacoes($smtm);
    }

    public function AlimentarListaMovimentacoes(\PDOStatement $stmt): array
    {
        $movimentacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$movimentacoes) {
            return [];
        }

        $listaMovimentacoes = [];

        foreach ($movimentacoes as $item) {

            $valorCorrigido = floatval($item['Valor']);

            try {
                $listaMovimentacoes[] = new Movimentacoes(
                    $item['Id'], // int
                    $item['IdCategoria'], // int
                    $valorCorrigido,
                    $item['DataHora']
                );
            } catch (\Exception $e) {
                continue;
            }
        }
        return $listaMovimentacoes;
    }

    function Inserir(Movimentacoes $mov): bool
    {
        $insertQuery = 'INSERT INTO MOVIMENTACOES (datahora, idcategoria, valor) VALUES (:datahora, :idcategoria, :valor)';
        $stmt = $this->connection->prepare($insertQuery);

        $sucesso = $stmt->execute([
            ':datahora' => $mov->datahora()->format('Y-m-d H:i:s'),
            ':idcategoria' => $mov->idcategoria(),
            ':valor' => $mov->valor()
        ]);

        if ($sucesso) {
            $mov->defineId($this->connection->lastInsertId());
        }
        return $sucesso;
    }

    function Atualizar(Movimentacoes $mov): bool
    {
        $updateQuery = 'UPDATE MOVIMENTACOES SET DATAHORA = :datahora, IDCATEGORIA = :idcategoria, VALOR = :valor where ID = :ID';

        $smtm = $this->connection->prepare($updateQuery);

        $smtm->bindValue(':datahora', $mov->datahora()->format('Y-m-d H:i:s'));
        $smtm->bindValue(':idcategoria', $mov->idcategoria());
        $smtm->bindValue(':valor', $mov->valor());
        $smtm->bindValue(':ID', $mov->id(), PDO::PARAM_INT);

        return $smtm->execute();
    }

    public function BuscarPorId(?int $id): ?Movimentacoes
    {
        $sqlQuery = "SELECT * FROM MOVIMENTACOES WHERE id = :id";
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movimentacao) {
            return null; // Retorna nulo se não encontrar a movimentação com o ID fornecido
        }

        // Substituir a vírgula por um ponto para que o PHP possa entender como um número de ponto flutuante
        $valor = isset($movimentacao['valor']) ? (float)str_replace(',', '.', $movimentacao['valor']) : null;

        try {
            return new Movimentacoes(
                $movimentacao['Id'], // int
                $movimentacao['IdCategoria'], // int
                $valor,
                $movimentacao['DataHora']
            );
        } catch (\Exception $e) {
            return null;
        }
    }
}