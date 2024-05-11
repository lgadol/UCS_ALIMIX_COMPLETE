# **Tecnologias Utilizadas:** # 
- PHP
- Node.js
- SQLite
- Visual Studio Code

# **Configuração do Ambiente** 

1. **Baixar e Instalar PHP:**
   - Baixe o [PHP](https://windows.php.net/downloads/releases/php-8.3.7-Win32-vs16-x64.zip).
   - Extraia o conteúdo do arquivo zip em uma pasta de sua escolha.
   - Adicione o caminho da pasta PHP às variáveis de ambiente do sistema.
  
2. **Habilitar PDO SQLite:**
   - Na pasta de instalação do PHP, localize o arquivo `php.ini`.
   - Abra o arquivo `php.ini` em um editor de texto.
   - Localize a linha `;extension=pdo_sqlite` e remova o ponto e vírgula no início para descomentá-la.
   - Salve e feche o arquivo `php.ini`.

3. **Instalar Composer:**
   - Faça o download do [Composer](https://getcomposer.org/Composer-Setup.exe).
   - Execute o instalador e siga as instruções na tela.
  
4. **Baixar e Instalar Node.js**
   - Baixe o [NODE.JS](https://nodejs.org/en/download/).
   - Instale o node.js.
   
5. **Configurar o Ambiente de Desenvolvimento no VSCode:**
   - Abra o projeto no Visual Studio Code.
   - (Opcional) Instale a extensão para banco de dados SQLite clicando com o botão direito no arquivo `db.sqlite` e selecionando "New Query". Você pode encontrar a extensão em [Extensão SQLITE](https://marketplace.visualstudio.com/items?itemName=alexcvzz.vscode-sqlite).

6. **Instalação das dependências do Projeto:**
   - No terminal, com o node.js já instalado, navegue até a raiz do projeto e execute o seguinte comando:
      - `npm run i:all`
        
7. **Executar a aplicação**
   - No terminal, execute o comando `npm run start:all`. Isso iniciará a aplicação.

---
**Endpoints Disponíveis da API:**

- `GET /api/todasmovimentacoes`: Retorna informações detalhadas sobre todas as movimentações.
- `GET /api/movimentacoes`: Retorna uma lista simplificada das movimentações.
