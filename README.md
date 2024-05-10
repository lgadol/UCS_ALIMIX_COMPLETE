# **Configuração do Ambiente** 

1. **Baixar e Instalar PHP:**
   - Baixe o [PHP](https://windows.php.net/downloads/releases/php-8.3.6-nts-Win32-vs16-x64.zip).
   - Extraia o conteúdo do arquivo zip em uma pasta de sua escolha.
   - Adicione o caminho da pasta PHP às variáveis de ambiente do sistema.

2. **Instalar Composer:**
   - Faça o download do [Composer](https://getcomposer.org/Composer-Setup.exe).
   - Execute o instalador e siga as instruções na tela.

3. **Habilitar PDO SQLite:**
   - Na pasta de instalação do PHP, localize o arquivo `php.ini`.
   - Abra o arquivo `php.ini` em um editor de texto.
   - Localize a linha `;extension=pdo_sqlite` e remova o ponto e vírgula no início para descomentá-la.
   - Salve e feche o arquivo `php.ini`.

4. **Configurar o Ambiente de Desenvolvimento no VSCode:**
   - Abra o projeto no Visual Studio Code.
   - (Opcional) Instale a extensão para banco de dados SQLite clicando com o botão direito no arquivo `db.sqlite` e selecionando "New Query". Você pode encontrar a extensão em [Extensão SQLITE](https://marketplace.visualstudio.com/items?itemName=alexcvzz.vscode-sqlite).

5. **Executar o Projeto:**
   - No terminal, navegue até a raiz do projeto.
   - Execute os seguintes comandos:
     1. `composer install`
     2. `composer dumpautoload`
     3. `composer start` - Isso iniciará a API.

**Endpoints Disponíveis:**

- `GET /api/todasmovimentacoes`: Retorna informações detalhadas sobre todas as movimentações.
- `GET /api/movimentacoes`: Retorna uma lista simplificada das movimentações.
