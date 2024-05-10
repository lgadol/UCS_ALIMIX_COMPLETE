-- Criação da tabela TiposMovimentacao no SQLite
CREATE TABLE TiposMovimentacao (
                                   IdTipoMovimentacao INTEGER PRIMARY KEY AUTOINCREMENT,
                                   TipoMovimento TEXT
);

CREATE TABLE Categorias (
                            IdCategoria INTEGER PRIMARY KEY AUTOINCREMENT,
                            IdTipoMovimentacao INTEGER,
                            Nome TEXT,
                            FOREIGN KEY (IdTipoMovimentacao) REFERENCES TiposMovimentacao(IdTipoMovimentacao)
);

-- Criação da tabela Movimentacoes no SQLite com chave estrangeira referenciando TiposMovimentacao
CREATE TABLE Movimentacoes (
                               Id INTEGER PRIMARY KEY AUTOINCREMENT,
                               DataHora Text,
                               IdCategoria INTEGER,
                               Valor TEXT,
                               FOREIGN KEY (IdCategoria) REFERENCES Categorias(IdCategoria)
);
