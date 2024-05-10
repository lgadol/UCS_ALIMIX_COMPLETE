<?php

namespace Alimix\Pdo\Domain\Repository;

use Alimix\Pdo\Domain\Model\Movimentacoes;

interface RepositorioMovimentacoes
{
    public function Listar(): array;
    public function BuscarPorId(?int $id): ?Movimentacoes;
    public function Remover(Movimentacoes $mov): bool;
    public function Salvar(Movimentacoes $mov): bool;
    function Inserir(Movimentacoes $mov): bool;
    function Atualizar(Movimentacoes $mov): bool;
}