# Documentação da Arquitetura - Impermax Backend

## Visão Geral

Este projeto é uma aplicação web construída em PHP seguindo o padrão arquitetural **MVC (Model-View-Controller)**. Ele serve tanto como um backend API (JSON) para consumo público/frontend quanto como uma aplicação renderizada no servidor (SSR) para painéis administrativos.

### Tecnologias Principais
*   **Linguagem:** PHP 8+
*   **Gerenciador de Dependências:** Composer
*   **Roteamento:** `bramus/router`
*   **Banco de Dados:** MySQL (via PDO)
*   **Frontend Admin:** HTML/CSS/JS renderizado pelo PHP
*   **Frontend Público:** Consome APIs do próprio backend (ex: `index.php` na raiz consome `/backend/api/...`)

---

## Estrutura de Diretórios

A estrutura do projeto separa claramente a lógica de negócios (backend) dos assets públicos.

```
/
├── index.php             # Entry point do site público (Landing Page)
├── assets/               # Imagens, ícones e recursos estáticos do site público
├── backend/              # Lógica da aplicação
│   ├── index.php         # Entry point do sistema/admin (Bootstrap e Rotas)
│   ├── Config/           # Configurações (Banco de dados, etc)
│   ├── Controllers/      # Controladores (Lógica de entrada)
│   ├── Models/           # Modelos (Acesso a dados)
│   ├── Views/            # Templates HTML (Blade-like ou PHP puro)
│   ├── Rotas/            # Definição de rotas da aplicação
│   ├── Core/             # Núcleo do framework (View, Database, Session)
│   ├── Validadores/      # Classes de validação de dados
│   ├── Database/         # Conexão e configuração do BD
│   └── public/           # Assets do painel administrativo (CSS, JS)
└── vendor/               # Dependências do Composer
```

---

## Fluxo da Informação

O fluxo de uma requisição típica segue o padrão MVC:

1.  **Entrada (Entry Point):**
    *   Todas as requisições para o sistema administrativo ou API passam pelo arquivo `backend/index.php`.
    *   O servidor web (Apache/Nginx) deve estar configurado para redirecionar as requisições para este arquivo (via `.htaccess`).

2.  **Roteamento:**
    *   O arquivo `backend/index.php` inicializa o roteador (`Bramus\Router`).
    *   As rotas são carregadas da classe `App\Impermax\Rotas\Rotas`, que define o mapeamento URL -> Controller@Action.
    *   O roteador despacha a requisição para o controlador correspondente.

3.  **Controller:**
    *   Recebe a requisição e valida os dados de entrada (usando classes em `Validadores/`).
    *   Chama os **Models** para buscar ou persistir dados.
    *   Define a resposta:
        *   **Para API:** Retorna JSON (ex: `PublicApiController`).
        *   **Para Admin:** Renderiza uma **View** HTML (ex: `UsuarioController::viewListarUsuarios`).

4.  **Model:**
    *   Abstrai o acesso ao banco de dados.
    *   Utiliza a classe `Database` (Singleton) para obter a conexão PDO.
    *   Executa queries SQL preparadas (prepared statements) para prevenir injeção de SQL.

5.  **View (Apenas Admin):**
    *   Recebe os dados do Controller.
    *   Os arquivos de template estão em `backend/Views/`.
    *   A classe `Core\View` injeta cabeçalho e rodapé automaticamente.

---

## Detalhes de Implementação

### Conexão com Banco de Dados
A conexão é gerenciada pela classe `App\Impermax\Database\Database`. Ela utiliza o padrão **Singleton** para garantir uma única instância de conexão por requisição. As configurações são lidas de `App\Impermax\Config\Config`.

### Validação
A validação é feita via classes estáticas dedicadas em `Validadores/`. O Controller chama `Validador::ValidarEntradas($dados)` e recebe um array de erros.

### Segurança
*   **CSRF:** Implementado manualmente (`App\Impermax\Core\CSRF`). Tokens são gerados na sessão e verificados em formulários POST.
*   **Senhas:** Armazenadas como hashes (`password_hash`).
*   **SQL Injection:** Mitigado pelo uso consistente de PDP Prepared Statements nos Models.

---

## Como Utilizar (Desenvolvedor)

1.  **Instalação:**
    *   Clone o repositório.
    *   Rode `composer install` na raiz para baixar as dependências.
    *   Configure o banco de dados em `backend/Config/Config.php`.

2.  **Criar Nova Rota:**
    *   Adicione a entrada no array em `backend/Rotas/Rotas.php`.
    *   Exemplo: `'/minha-rota' => 'MeuController@minhaAcao'`

3.  **Criar Controller:**
    *   Crie a classe em `backend/Controllers/`.
    *   Se for API, use `header('Content-Type: application/json')` e `echo json_encode(...)`.
    *   Se for View, use `View::render('pasta/arquivo', $dados)`.

4.  **Criar Model:**
    *   Crie a classe em `backend/Models/`.
    *   Receba `$db` no construtor.
