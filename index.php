<?php declare(strict_types=1);

require_once "utilitarios.php";

session_start();


// salva os clientes na sessão
if (!isset($_SESSION["clientes"])) {

    $_SESSION["clientes"] = $clientes;

}


// usa os clientes salvos na sessão
$clientes = $_SESSION["clientes"];


$mensagem = "";
$tipoMensagem = "";

$resultadoBusca = null;


/* ==========================================
   PROCESSAMENTO DOS FORMULÁRIOS
   ========================================== */

// busca de cliente

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["buscar"])) {

        $nomeBusca = trim($_POST["nome_busca"] ?? "");


        if ($nomeBusca === "") {

            $mensagem = "Digite o nome do cliente.";
            $tipoMensagem = "erro";

        } else {

            $resultadoBusca = buscarCliente(
                $clientes,
                $nomeBusca
            );


            if ($resultadoBusca === null) {

                $mensagem = "Cliente não encontrado.";
                $tipoMensagem = "erro";

            }
        }
    }


    // cadastro de cliente

    if (isset($_POST["cadastrar"])) {

        $nome = trim($_POST["nome"] ?? "");

        $cpf = trim($_POST["cpf"] ?? "");

        $email = trim($_POST["email"] ?? "");


        $contratoTexto = $_POST["contrato"] ?? "0";

        $contratoTexto = str_replace(
            ",",
            ".",
            $contratoTexto
        );


        $contrato = (float) $contratoTexto;


        $ativo = isset($_POST["ativo"]);


        if (!validarNome($nome)) {

            $mensagem = "Nome inválido. Digite pelo menos 3 caracteres.";
            $tipoMensagem = "erro";

        } elseif (!cpfValido($cpf)) {

            $mensagem = "CPF inválido. Digite 11 números.";
            $tipoMensagem = "erro";

        } elseif (!validarEmail($email)) {

            $mensagem = "E-mail inválido.";
            $tipoMensagem = "erro";

        } elseif (!validarContrato($contrato)) {

            $mensagem = "O valor do contrato deve ser maior que zero.";
            $tipoMensagem = "erro";

        } else {

            $novoCliente = [
                "nome" => formatarNome($nome),
                "cpf" => limparCPF($cpf),
                "email" => $email,
                "contrato" => $contrato,
                "ativo" => $ativo
            ];


            $clientes[] = $novoCliente;


            // salva o novo cliente na sessão
            $_SESSION["clientes"] = $clientes;


            $mensagem = "Cliente cadastrado com sucesso!";

            $tipoMensagem = "sucesso";

        }
    }


    // reajuste de contrato

    if (isset($_POST["reajustar"])) {

        $indice = (int) ($_POST["cliente_reajuste"] ?? -1);

        $percentual = (float) ($_POST["percentual"] ?? 0);


        if (!isset($clientes[$indice])) {

            $mensagem = "Cliente não encontrado.";

            $tipoMensagem = "erro";

        } elseif ($percentual <= 0) {

            $mensagem = "Digite um percentual maior que zero.";

            $tipoMensagem = "erro";

        } else {

            $contratoAntes = $clientes[$indice]["contrato"];


            aplicarReajuste(
                $clientes[$indice]["contrato"],
                $percentual
            );


            $contratoDepois = $clientes[$indice]["contrato"];


            // salva o reajuste na sessão
            $_SESSION["clientes"] = $clientes;


            $mensagem =
                "Reajuste aplicado com sucesso! O contrato passou de " .
                formatarMoeda($contratoAntes) .
                " para " .
                formatarMoeda($contratoDepois) .
                ".";


            $tipoMensagem = "sucesso";

        }
    }
}


/* ==========================================
   CÁLCULOS DO RELATÓRIO
   ========================================== */

$totalClientes = count($clientes);


$clientesAtivos = contarClientesAtivos(
    $clientes
);


$totalContratosAtivos = calcularTotalContratosAtivos(
    $clientes
);


$mediaContratos = calcularMediaContratos(
    $clientes
);


$maiorContratoCadastrado = maiorContrato(
    $clientes
);

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Projeto CRM</title>


    <style>

        /* ==========================================
           CONFIGURAÇÃO GERAL
           ========================================== */

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


        /* ==========================================
           CABEÇALHO
           ========================================== */

        header {

            background: linear-gradient(
                135deg,
                #075bb5,
                #2385e8
            );

            color: white;

            padding: 25px 7%;

            text-align: center;

        }


        header h1 {

            font-size: 32px;

        }


        /* ==========================================
           ÁREA PRINCIPAL
           ========================================== */

        main {

            width: 90%;

            max-width: 1100px;

            margin: 40px auto;

        }


        /* ==========================================
           BOAS-VINDAS
           ========================================== */

        .boas-vindas {

            text-align: center;

            margin-bottom: 30px;

        }


        .boas-vindas h2 {

            color: #075bb5;

            margin-bottom: 10px;

        }


        .boas-vindas p {

            font-size: 18px;

        }


        /* ==========================================
           BOTÕES
           ========================================== */

        .botoes {

            display: flex;

            justify-content: center;

            gap: 20px;

            margin-top: 30px;

            flex-wrap: wrap;

        }


        button {

            background-color: #075bb5;

            color: white;

            border: none;

            padding: 13px 25px;

            border-radius: 8px;

            cursor: pointer;

            font-size: 16px;

        }


        button:hover {

            background-color: #06478d;

        }


        /* ==========================================
           CARDS
           ========================================== */

        .card {

            background-color: white;

            padding: 30px;

            margin: 25px auto;

            border-radius: 12px;

            box-shadow: 0 4px 15px rgba(0,0,0,0.10);

        }


        .card h2 {

            color: #075bb5;

            margin-bottom: 20px;

            text-align: center;

        }


        /* ==========================================
           FORMULÁRIO
           ========================================== */

        label {

            display: block;

            margin-top: 15px;

            margin-bottom: 5px;

            font-weight: bold;

        }


        input,

        select {

            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 15px;

        }


        .formulario-botao {

            width: 100%;

            margin-top: 20px;

        }


        /* ==========================================
           MENSAGENS
           ========================================== */

        .sucesso {

            background-color: #d4edda;

            color: #155724;

            padding: 15px;

            border-radius: 7px;

            margin-bottom: 20px;

            text-align: center;

        }


        .erro {

            background-color: #f8d7da;

            color: #721c24;

            padding: 15px;

            border-radius: 7px;

            margin-bottom: 20px;

            text-align: center;

        }


        /* ==========================================
           RESULTADO DA BUSCA
           ========================================== */

        .resultado {

            margin-top: 20px;

            padding: 20px;

            background-color: #f4f8fc;

            border-radius: 8px;

        }


        .resultado h3 {

            color: #075bb5;

            margin-bottom: 15px;

        }


        .resultado p {

            margin: 10px 0;

        }


        /* ==========================================
           TABELA
           ========================================== */

        .tabela-container {

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;

        }


        th {

            background-color: #075bb5;

            color: white;

            padding: 14px;

            text-align: left;

        }


        td {

            padding: 14px;

            border-bottom: 1px solid #ddd;

        }


        tr:hover {

            background-color: #f1f6fb;

        }


        .ativo {

            color: #16803c;

            font-weight: bold;

        }


        .inativo {

            color: #c62828;

            font-weight: bold;

        }


        /* ==========================================
           RESUMO
           ========================================== */

        .resumo {

            display: grid;

            grid-template-columns: repeat(
                auto-fit,
                minmax(200px, 1fr)
            );

            gap: 20px;

            margin-top: 20px;

        }


        .resumo-card {

            background-color: #075bb5;

            color: white;

            padding: 25px;

            border-radius: 10px;

            text-align: center;

        }


        .resumo-card h3 {

            font-size: 16px;

            margin-bottom: 10px;

        }


        .resumo-card p {

            font-size: 24px;

            font-weight: bold;

        }


        /* ==========================================
           CHECKBOX
           ========================================== */

        .checkbox-container {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-top: 15px;

        }


        .checkbox-container input {

            width: auto;

        }


        /* ==========================================
           RESPONSIVIDADE
           ========================================== */

        @media (max-width: 700px) {

            header h1 {

                font-size: 24px;

            }


            main {

                width: 95%;

            }


            .card {

                padding: 20px;

            }

        }

    </style>

</head>


<body>


    <!-- ==========================================
         CABEÇALHO
         ========================================== -->

    <header>

        <h1>
            Projeto CRM - Central de Atendimento e Cadastro
        </h1>

    </header>


    <!-- ==========================================
         CONTEÚDO PRINCIPAL
         ========================================== -->

    <main>


        <!-- BOAS-VINDAS -->

        <div class="boas-vindas">

            <h2>
                Seja muito bem-vindo ao nosso site!
            </h2>

            <p>
                Controle seus clientes e contratos.
            </p>

        </div>


        <!-- ==========================================
             MENSAGEM DO PHP
             ========================================== -->

        <?php if ($mensagem != ""): ?>

            <div class="<?php echo htmlspecialchars($tipoMensagem); ?>">

                <?php echo htmlspecialchars($mensagem); ?>

            </div>

        <?php endif; ?>


        <!-- ==========================================
             BOTÕES
             ========================================== -->

        <div class="botoes">

            <button onclick="mostrarSecao('cadastro')">

                Cadastre-se

            </button>


            <button onclick="mostrarSecao('busca')">

                Buscar cliente

            </button>


            <button onclick="mostrarSecao('reajuste')">

                Reajustar contrato

            </button>


            <button onclick="mostrarSecao('clientes')">

                Ver clientes

            </button>


            <button onclick="mostrarSecao('resumo')">

                Relatório

            </button>

        </div>


        <!-- ==========================================
             CADASTRO
             ========================================== -->

        <div
            class="card"
            id="cadastro"
        >

            <h2>
                Cadastre-se
            </h2>


            <form method="POST">


                <label>
                    Nome:
                </label>

                <input
                    type="text"
                    name="nome"
                    placeholder="Digite o nome completo"
                    required
                >


                <label>
                    CPF:
                </label>

                <input
                    type="text"
                    name="cpf"
                    placeholder="000.000.000-00"
                    maxlength="14"
                    required
                >


                <label>
                    E-mail:
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="cliente@email.com"
                    required
                >


                <label>
                    Valor do contrato:
                </label>

                <input
                    type="number"
                    name="contrato"
                    placeholder="0.00"
                    min="0"
                    step="0.01"
                    required
                >


                <div class="checkbox-container">

                    <input
                        type="checkbox"
                        name="ativo"
                        id="ativo"
                        checked
                    >

                    <label for="ativo">
                        Cliente ativo
                    </label>

                </div>


                <button
                    type="submit"
                    name="cadastrar"
                    class="formulario-botao"
                >

                    Criar cadastro

                </button>


            </form>

        </div>


        <!-- ==========================================
             BUSCA
             ========================================== -->

        <div
            class="card"
            id="busca"
        >

            <h2>
                Buscar Cliente
            </h2>


            <form method="POST">


                <label>
                    Nome do cliente:
                </label>

                <input
                    type="text"
                    name="nome_busca"
                    placeholder="Digite o nome do cliente"
                    required
                >


                <button
                    type="submit"
                    name="buscar"
                    class="formulario-botao"
                >

                    Buscar cliente

                </button>


            </form>


            <?php if ($resultadoBusca !== null): ?>

                <div class="resultado">

                    <h3>
                        Cliente encontrado
                    </h3>


                    <p>

                        <strong>
                            Nome:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            formatarNome(
                                $resultadoBusca["nome"]
                            )
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            CPF:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            formatarCPF(
                                $resultadoBusca["cpf"]
                            )
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            E-mail:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            $resultadoBusca["email"]
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            Contrato:
                        </strong>

                        <?php

                        echo formatarMoeda(
                            (float) $resultadoBusca["contrato"]
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            Situação:
                        </strong>


                        <?php if ($resultadoBusca["ativo"]): ?>

                            <span class="ativo">
                                Ativo
                            </span>

                        <?php else: ?>

                            <span class="inativo">
                                Inativo
                            </span>

                        <?php endif; ?>


                    </p>

                </div>

            <?php endif; ?>

        </div>


        <!-- ==========================================
             REAJUSTE
             ========================================== -->

        <div
            class="card"
            id="reajuste"
        >

            <h2>
                Reajuste de Contrato
            </h2>


            <form method="POST">


                <label>
                    Cliente:
                </label>


                <select
                    name="cliente_reajuste"
                    required
                >

                    <option value="">
                        Selecione um cliente
                    </option>


                    <?php foreach ($clientes as $indice => $cliente): ?>

                        <option value="<?php echo $indice; ?>">

                            <?php

                            echo htmlspecialchars(
                                formatarNome(
                                    $cliente["nome"]
                                )
                            );

                            ?>

                        </option>

                    <?php endforeach; ?>


                </select>


                <label>
                    Percentual de reajuste:
                </label>


                <input
                    type="number"
                    name="percentual"
                    placeholder="Ex: 10"
                    min="0.01"
                    step="0.01"
                    required
                >


                <button
                    type="submit"
                    name="reajustar"
                    class="formulario-botao"
                >

                    Aplicar reajuste

                </button>


            </form>

        </div>


        <!-- ==========================================
             LISTAGEM DE CLIENTES
             ========================================== -->

        <div
            class="card"
            id="clientes"
        >

            <h2>
                Lista de Clientes
            </h2>


            <div class="tabela-container">


                <table>

                    <thead>

                        <tr>

                            <th>
                                Nome
                            </th>

                            <th>
                                CPF
                            </th>

                            <th>
                                E-mail
                            </th>

                            <th>
                                Valor do contrato
                            </th>

                            <th>
                                Situação
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php foreach ($clientes as $cliente): ?>

                            <tr>

                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        formatarNome(
                                            $cliente["nome"]
                                        )
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        formatarCPF(
                                            $cliente["cpf"]
                                        )
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        $cliente["email"]
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php

                                    echo formatarMoeda(
                                        (float) $cliente["contrato"]
                                    );

                                    ?>

                                </td>


                                <td>


                                    <?php if ($cliente["ativo"]): ?>

                                        <span class="ativo">
                                            Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="inativo">
                                            Inativo
                                        </span>

                                    <?php endif; ?>


                                </td>

                            </tr>

                        <?php endforeach; ?>


                    </tbody>

                </table>


            </div>

        </div>


        <!-- ==========================================
             RESUMO FINANCEIRO
             ========================================== -->

        <div
            class="card"
            id="resumo"
        >

            <h2>
                Relatório Final
            </h2>


            <div class="resumo">


                <div class="resumo-card">

                    <h3>
                        Total de clientes
                    </h3>

                    <p>
                        <?php echo $totalClientes; ?>
                    </p>

                </div>


                <div class="resumo-card">

                    <h3>
                        Clientes ativos
                    </h3>

                    <p>
                        <?php echo $clientesAtivos; ?>
                    </p>

                </div>


                <div class="resumo-card">

                    <h3>
                        Contratos ativos
                    </h3>

                    <p>

                        <?php

                        echo formatarMoeda(
                            $totalContratosAtivos
                        );

                        ?>

                    </p>

                </div>


                <div class="resumo-card">

                    <h3>
                        Média dos contratos
                    </h3>

                    <p>

                        <?php

                        echo formatarMoeda(
                            $mediaContratos
                        );

                        ?>

                    </p>

                </div>


                <div class="resumo-card">

                    <h3>
                        Maior contrato
                    </h3>

                    <p>

                        <?php

                        echo formatarMoeda(
                            $maiorContratoCadastrado
                        );

                        ?>

                    </p>

                </div>


            </div>

        </div>


    </main>


    <!-- ==========================================
         JAVASCRIPT
         ========================================== -->

    <script>


        function mostrarSecao(secao) {

            const secoes = [
                "cadastro",
                "busca",
                "reajuste",
                "clientes",
                "resumo"
            ];


            secoes.forEach(function(nomeSecao) {

                document.getElementById(nomeSecao).style.display = "none";

            });


            document.getElementById(secao).style.display = "block";


            document.getElementById(secao).scrollIntoView({
                behavior: "smooth"
            });

        }


        // mostra cadastro ao abrir a página

        mostrarSecao("cadastro");


    </script>


</body>

</html>
