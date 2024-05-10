<?php

namespace Alimix\Pdo\Domain\Model;

class TipoMovimentacao
{
    public int $id;
    public string $nome;

    function __construct(int $id, string $nome)
    {
        $this->id = $id;
        $this->nome = $nome;
    }
}