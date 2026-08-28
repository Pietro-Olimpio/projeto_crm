## Projeto CRM SENAI - Central de Atendimento e Cadastro
- **Integrantes:** Sofia Cristina, Mayne e Pietro.
---
>1- **Sobre o Projeto:**

O `Projeto CRM SENAI — Central de Atendimento e Cadastro` é uma aplicação desenvolvida em PHP com o objetivo de organizar informações de clientes e contratos de uma empresa de serviços.

O sistema simula uma pequena biblioteca de funções para tratamento de dados de um CRM, permitindo:

- Cadastrar clientes;
- Listar clientes cadastrados;
- Pesquisar clientes pelo nome;
- Limpar e padronizar dados;
- Validar CPF, e-mail e valor do contrato;
- Formatar valores como moeda brasileira;
- Calcular informações financeiras;
- Aplicar reajustes nos contratos;
- Gerar um resumo geral dos clientes.

*O projeto utiliza arrays como banco de dados simulado, não sendo necessário banco de dados ou sistema de autenticação.*

---
>2- **Objetivos:**

O principal objetivo é `desenvolver uma aplicação organizada e reutilizável`, evitando a repetição de códigos e seguindo o princípio ***DRY (Don't Repeat Yourself)***.

---
>3- **Organização do Projeto:**

Para iniciarmos o projeto, decidimos dividir as responsabilidades entre os integrantes da equipe. Mayne e Sofia ficaram responsáveis pela documentação, realização dos testes e desenvolvimento da interface gráfica do projeto, enquanto Pietro ficou encarregado do desenvolvimento da biblioteca de funções. Para iniciarmos o projeto, decidimos dividir as responsabilidades entre os integrantes da equipe. Mayne e Sofia ficaram responsáveis pela documentação, realização dos testes e desenvolvimento da interface gráfica do projeto, enquanto Pietro ficou encarregado do desenvolvimento da biblioteca de funções.

---
>4- **Estrutura do Projeto:**

A estrutura utilizada é:

![alt text](image.png)

`utilitarios.php`:
Contém as funções responsáveis pelo processamento dos dados.
Entre elas estão funções para:
- Formatação de nomes;
- Limpeza e validação de CPF;
- Validação de e-mail;
- Formatação de valores;
- Busca de clientes;
- Cálculos financeiros;
- Contagem de clientes ativos;
- Aplicação de reajustes.
---
`index.php`:
É a tela principal do sistema.

Esse arquivo utiliza `require_once` para importar a biblioteca `utilitarios.php` e é responsável pela apresentação dos dados, como tabelas, mensagens e resultados.

---
`testes/testes.php`:
Arquivo utilizado para testar as funções da biblioteca e verificar se o sistema apresenta os resultados esperados.

---
`README.md`:
Documento que apresenta o projeto, sua estrutura, funcionamento, requisitos, testes e instruções de execução.

---
---
## Desenvolvimento da Biblioteca (`utilitarios.php`)

### Teste 1: Listagem de Clientes
![alt text](image-4.png)

> Neste teste, verificamos a **listagem dos clientes cadastrados** no sistema. Utilizamos o `foreach` para percorrer o array e apresentar, um por um, os dados dos quatro clientes. Também verificamos a formatação dos nomes, a validação dos CPFs e e-mails, a apresentação dos valores dos contratos em moeda brasileira e a situação de cada cliente, identificando quais estão ativos e quais estão inativos. Com esse teste, confirmamos que o sistema conseguiu percorrer e exibir corretamente todos os registros cadastrados.
---
### Teste 2: Busca por Nome
![alt text](image-3.png)

> Neste teste, verificamos a funcionalidade de **busca por nome de um cliente existente**. Informamos o nome **Ana Clara Silva** e o sistema conseguiu localizar corretamente o cadastro correspondente. Após encontrar o cliente, conseguimos visualizar seus dados, como o nome formatado, a validação do CPF e do e-mail, o valor do contrato apresentado como **R$ 1.500,00** e sua situação como **Ativo**. Com isso, confirmamos que a função de busca e a exibição das informações do cliente estavam funcionando corretamente.
---
### Teste 3: Cadastro de Cliente
![alt text](image-5.png)

> Neste teste, realizamos o **cadastro de um novo cliente utilizando dados válidos**. Informamos o nome **Ana Clara Silva**, o CPF **123.456.789-00**, o e-mail **[ana.clara@email.com](mailto:ana.clara@email.com)**, o valor do contrato de **R$ 1.500,00** e definimos o cliente como ativo. Após o preenchimento, o sistema realizou as validações dos dados e, como as informações estavam de acordo com os critérios estabelecidos, o cadastro foi concluído com sucesso, apresentando a mensagem **“Cliente adicionado com sucesso!”**.
---
### Teste 4: Limpeza de dados
Para realizar a limpeza e a padronização dos nomes, utilizamos a combinação das funções |`trim(), strtolower() e ucfirst()`. O `trim()` remove espaços desnecessários no início e no final do nome, o `strtolower()` transforma todas as letras em minúsculas e o `ucfirst()` deixa a primeira letra do texto em maiúscula. Dessa forma, conseguimos padronizar os nomes antes de apresentá-los no sistema.
```php
function formatarNome(string $nome): string
{
    return ucfirst(strtolower(trim($nome)));
}
```
---
### Teste 5: Formatação


> 
---
## Desenvolvimento da Interface Gráfica (`index.php`)
A responsabilidade pelo desenvolvimento inicial do arquivo `index.php` ficou com a Sofia. Primeiramente, foi criado o arquivo que seria utilizado como página principal do sistema e, em seguida, iniciada a estruturação do código HTML. Para isso, foi utilizado o `<!DOCTYPE html>`, responsável por indicar ao navegador que o documento segue o padrão HTML5. A partir dessa estrutura inicial, a página começou a ser organizada para posteriormente receber as funcionalidades e informações do sistema CRM.



```html
<!DOCTYPE html>
<html lang="pt-BR" >
  <head>
    <meta charset="UTF-8">
    <title> ProjetoCRM.html </title> 
  </head>
<body>

    <header>
        <!-- Cabeçalho principal com o nome da empresa -->
        <h1 style="color: #f0f2f5;">Projeto CRM - Central de Atendimento e Cadastro</h1>

    </header>

    <main>
        <!-- Primeiro Parágrafo: Mensagem de boas-vindas -->
        <p>
            Seja muito bem-vindo ao <strong>Nosso site</strong>! 
        </p>
        <style>

        /* =====================================================
           CONFIGURAÇÃO GERAL
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: Arial, sans-serif;

            background-color: #f4f8fc;

            color: #333;
        }
         /* =====================================================
           CABEÇALHO
        ===================================================== */

        header {

            background: linear-gradient(
                135deg,
                #075bb5,
                #2385e8
            );

            color: white;

            padding: 20px 7%;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

```

Essa primeira parte do código é fundamental, pois representa o início da construção da interface gráfica do sistema. Nessa etapa, são definidos elementos básicos da estrutura da página, como a tag `<title>ProjetoCRM.html</title>`. Inicialmente, HOUVE UM ERRO em relação à função dessa tag, pois acreditávamos que ela correspondia ao primeiro título exibido dentro da página (KSKSKKSKS). Entretanto, o `<title>` é responsável por definir o nome que aparece na aba do navegador, identificando a página aberta pelo usuário.

![alt text](image-1.png)

// Para fazer o primeiro título do nome da empresa utilizamos:

 <header>
        <!-- Cabeçalho principal com o nome da empresa -->
        <h1 style="color: #f0f2f5;">Projeto CRM - Central de Atendimento e Cadastro</h1>

