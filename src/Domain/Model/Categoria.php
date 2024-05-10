<?php

namespace Alimix\Pdo\Domain\Model;

class Categoria
{
    public ?int $id;
    public ?string $nome;
    public TipoMovimentacao $tipoMovimentacao;

    function __construct(?int $id, ?string $nome, TipoMovimentacao $tpmov)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->tipoMovimentacao = $tpmov;
    }
}