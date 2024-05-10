<?php

namespace Alimix\Pdo\Domain\Model;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;

class Movimentacoes
{
    public ?int $id;
    public ?int $idCategoria;
    public ?float $valor;
    public ?DateTimeInterface $dataHora;

    public function __construct(?int $id, ?int $idCategoria, ?float $valor, ?string $dataHora)
    {
        $dataHoras = new DateTimeImmutable($dataHora);
        $this->id = $id;
        $this->idCategoria = $idCategoria;
        $this->valor = $valor;
        $this->dataHora = $dataHoras;
    }
    public function serialize(){
        return json_encode(get_object_vars ($this));
    }
    public function id(): ?int
    {
        return $this->id;
    }

    public function datahora(): ?DateTimeInterface
    {
        return $this->dataHora;
    }

    public function idcategoria(): ?int
    {
        return $this->idCategoria;
    }

    public function valor(): ?float
    {
        return $this->valor;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new DomainException('Você só pode definir o ID uma vez');
        }

        $this->id = $id;
    }
}