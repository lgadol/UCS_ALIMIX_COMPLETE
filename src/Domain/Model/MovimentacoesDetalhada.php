<?php

namespace Alimix\Pdo\Domain\Model;

use DateTimeImmutable;

class MovimentacoesDetalhada
{
    public ?int $IdMovimentacao;
    public float $valor = 0;
    public \DateTimeInterface $datahora;
    public Categoria $categoria;

    public function __construct($IdMovimentacao, $valor, $datahora, Categoria $categoria) {
        $this->IdMovimentacao = $IdMovimentacao;
        $this->valor = $valor;
        $dataHoras = new DateTimeImmutable($datahora);
        $this->datahora = $dataHoras;
        $this->categoria = $categoria;
    }
}