<?php

namespace Alimix\Pdo\Infrastructure\Repository;

use Alimix\Pdo\Domain\Model\Categoria;
use Alimix\Pdo\Domain\Model\MovimentacoesDetalhada;
use Alimix\Pdo\Domain\Model\TipoMovimentacao;
use Alimix\Pdo\Domain\Repository\RepositorioViewTodasMovimentacoes;
use PDO;

class PdoTodasMovimentacoesRepository implements RepositorioViewTodasMovimentacoes
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function Listar(): array
    {
        $sqlQuery = "select M.id idMovimentacao,
                        M.IdCategoria CategoriaID,
                        C.Nome CategoriaNome,
                        C.IdTipoMovimentacao TipoMovimentoID,
                        tm.TipoMovimento TipoMovimentoNome,
                        M.DataHora DataHoraMovimentacao,
                        M.Valor ValorMovimentacao
                  from Movimentacoes M
                  join Categorias C on M.IdCategoria = C.IdCategoria
                  join main.TiposMovimentacao TM on C.IdTipoMovimentacao = TM.IdTipoMovimentacao;";

        $stmt = $this->connection->query($sqlQuery); // Changed $smtm to $stmt

        return $this->AlimentarListaMovimentacoes($stmt);
    }

    private function AlimentarListaMovimentacoes($smtm): array
    {
        $movimentacoes = $smtm->fetchAll(PDO::FETCH_ASSOC);

        if (!$movimentacoes) {
            return [];
        }

        $listaMovimentacoes = [];

        foreach ($movimentacoes as $item) {

            $valor = isset($item['ValorMovimentacao']) ? (float)str_replace(',', '.', $item['ValorMovimentacao']) : 0;

            $tipoMovimento = new TipoMovimentacao($item['TipoMovimentoID'],$item['TipoMovimentoNome']);

            $categoria = new Categoria($item['CategoriaID'], $item['CategoriaNome'], $tipoMovimento);

            try {
                $listaMovimentacoes[] = new MovimentacoesDetalhada(
                    $item['idMovimentacao'],
                    $valor,
                    $item['DataHoraMovimentacao'],
                    $categoria
                );
            } catch (\Exception $e) {
                continue;
            }
        }

        return $listaMovimentacoes;

    }

}