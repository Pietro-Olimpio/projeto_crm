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

Neste teste, verificamos a **listagem dos clientes cadastrados** no sistema. Utilizamos o `foreach` para percorrer o array e apresentar, um por um, os dados dos quatro clientes. Também verificamos a formatação dos nomes, a validação dos CPFs e e-mails, a apresentação dos valores dos contratos em moeda brasileira e a situação de cada cliente, identificando quais estão ativos e quais estão inativos. Com esse teste, confirmamos que o sistema conseguiu percorrer e exibir corretamente todos os registros cadastrados.
---
### Teste 2: Busca por Nome
![alt text](image-3.png)

Neste teste, verificamos a funcionalidade de **busca por nome de um cliente existente**. Informamos o nome **Ana Clara Silva** e o sistema conseguiu localizar corretamente o cadastro correspondente. Após encontrar o cliente, conseguimos visualizar seus dados, como o nome formatado, a validação do CPF e do e-mail, o valor do contrato apresentado como **R$ 1.500,00** e sua situação como **Ativo**. Com isso, confirmamos que a função de busca e a exibição das informações do cliente estavam funcionando corretamente.
---
### Teste 3: Cadastro de Cliente
![alt text](image-5.png)

Neste teste, realizamos o **cadastro de um novo cliente utilizando dados válidos**. Informamos o nome **Ana Clara Silva**, o CPF **123.456.789-00**, o e-mail **[ana.clara@email.com](mailto:ana.clara@email.com)**, o valor do contrato de **R$ 1.500,00** e definimos o cliente como ativo. Após o preenchimento, o sistema realizou as validações dos dados e, como as informações estavam de acordo com os critérios estabelecidos, o cadastro foi concluído com sucesso, apresentando a mensagem **“Cliente adicionado com sucesso!”**.
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
### Teste 5: Aplicação do Reajuste
Fizemos esse código para testar algumas das funções que foram pedidas no exercício e entender melhor como elas funcionam na prática.

Primeiro, criamos um array chamado `$clientes` para guardar os dados dos clientes, como nome, CPF, e-mail, valor do contrato e se o cliente está ativo ou não. A gente colocou alguns dados de exemplo para conseguir testar as funções.

Também usamos o `declare(strict_types=1)` para deixar o PHP mais rigoroso com os tipos de dados. Assim, quando uma função espera receber um `float`, por exemplo, o código trabalha de uma forma mais controlada.

Depois criamos a função `formatarMoeda()`. Fizemos essa função para não precisar ficar formatando o valor do contrato toda hora. Ela pega um número, como 1500.00, e transforma em R$ 1.500,00, que é o formato de dinheiro que usamos no Brasil.

A parte principal do código foi a função `aplicarReajuste()`. A gente criou essa função para conseguir aumentar o valor do contrato de um cliente de acordo com uma porcentagem. Nesse caso, usamos um reajuste de 10%.

O mais importante nessa função é o `&` antes de `$contrato`. A gente colocou o `&` porque o exercício pede uma alteração por referência. Isso faz com que a função altere o valor original do contrato dentro do array, e não apenas uma cópia dele.

Por exemplo, o primeiro cliente tinha um contrato de R$ 1.500,00. Quando a gente aplica 10% de reajuste, são acrescentados R$ 150,00, então o contrato passa para R$ 1.650,00. Como usamos o `&`, esse novo valor fica salvo diretamente no contrato do cliente.

Por último, usamos o echo para mostrar o resultado na tela. Então, no final, aparece "Contrato reajustado: R$ 1.650,00".

---
### Teste 6: Total de Clientes Ativos
Fizemos esse código para calcular o valor total dos contratos dos clientes que estão ativos.

Primeiro, criamos o array $clientes com os dados de cada cliente. Nele temos o nome, CPF, e-mail, valor do contrato e se o cliente está ativo ou não. Para identificar isso, usamos true para clientes ativos e false para clientes inativos.

Depois criamos a função `calcularTotalContratosAtivos()`. A função serve justamente para descobrir quanto vale, no total, todos os contratos que estão ativos.

Dentro dela, criamos a variável $total começando com zero. Depois usamos o foreach para passar por cada cliente do array.

Em seguida, usamos o `if` para verificar se o cliente está ativo:

`if ($cliente["ativo"] === true)`

Se estiver ativo, o valor do contrato é adicionado ao `$total`. Se estiver inativo, o contrato não é contado.

Nesse exemplo, a Ana está ativa e tem um contrato de R$ 1.500,00. O Pietro também está ativo e tem um contrato de R$ 1.600,00. Já o Carlos e o Rodolfo estão inativos, então os contratos deles não entram na conta.

Por isso, o total dos contratos ativos fica:

R$ 1.500,00 + R$ 1.600,00 = R$ 3.100,00.

Depois, colocamos o resultado dentro da variável `$totalAtivos`:

`$totalAtivos = calcularTotalContratosAtivos($clientes);`

Por último, usamos o echo para mostrar o resultado na tela e usamos a função `formatarMoeda()` para deixar o valor no formato de moeda brasileira.

Fizemos esse código porque o objetivo desse teste é mostrar o total financeiro dos clientes ativos. Assim, o sistema consegue ignorar os clientes inativos e mostrar somente quanto valem os contratos que estão atualmente ativos.

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

Essa parte do código é responsável por construir e estilizar o início da interface gráfica do nosso sistema CRM. Aqui a gente define a estrutura da página, o cabeçalho e também algumas configurações visuais para deixar o sistema mais organizado e agradável de usar.

Primeiro, usamos <!DOCTYPE html>, que informa ao navegador que estamos trabalhando com HTML5. Depois temos a tag <html lang="pt-BR">, que indica que a página está em português do Brasil.

Dentro do <head>, colocamos <meta charset="UTF-8">. Isso é importante porque permite que o navegador reconheça corretamente caracteres como acentos e ç. Também colocamos a tag <title>, que define o nome que aparece na aba do navegador.

No <body>, começamos a parte que realmente aparece para o usuário. Criamos um <header>, que representa o cabeçalho da página. Dentro dele, colocamos um <h1> com o nome do nosso projeto: "Projeto CRM - Central de Atendimento e Cadastro". Esse é o título principal que aparece na interface.

Depois criamos o <main>, que representa o conteúdo principal da página. Dentro dele, colocamos um parágrafo de boas-vindas usando a tag <p>. Também usamos <strong> para deixar a expressão "Nosso site" em destaque.

Na parte do CSS, começamos usando *, que seleciona todos os elementos da página. Colocamos `margin: 0` e `padding: 0` para remover os espaçamentos padrão do navegador. Já o `box-sizing: border-box` ajuda a controlar melhor o tamanho dos elementos.

No body, definimos a fonte como Arial, colocamos uma cor de fundo azul bem clara com `background-color: #f4f8fc` e definimos a cor padrão dos textos como #333.

Depois começamos a estilizar o `header`. Colocamos um `background: linear-gradient(...)` para criar um degradê em tons de azul, deixando o cabeçalho com uma aparência mais moderna. O `color: white` define a cor padrão dos textos dentro do cabeçalho como branca.

Também usamos `padding: 20px 7%` para criar um espaço interno no cabeçalho, evitando que o conteúdo fique grudado nas bordas. O `display: flex` permite organizar os elementos do cabeçalho de forma mais prática. Já o `justify-content: space-between` distribui os elementos, colocando espaço entre eles, enquanto o `align-items: center` mantém os elementos alinhados verticalmente no centro.