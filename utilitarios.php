<?php declare(strict_types=1);

// dados dos clientes
$clientes = [
    [
        "nome" => "  ANA CLARA SILVA ",
        "cpf" => "123.456.789-00",
        "email" => "ana.clara@email.com",
        "contrato" => 1500.00,
        "ativo" => true
    ],
    [
        "nome" => "Carlos Souza",
        "cpf" => "987.654.321-00",
        "email" => "carlos.souza@email.com",
        "contrato" => 850.50,
        "ativo" => false
    ],
    [
        "nome" => "  Pietro Correa Teodoro Olimpio ",
        "cpf" => "439.105.508-27",
        "email" => "pietro.olimpio@edu.senai.br",
        "contrato" => 1600.00,
        "ativo" => true
    ],
    [
        "nome" => "  Rodolfo Leonardo Da Silva Pereira ",
        "cpf" => "404.202.335-10",
        "email" => "rodolfo.leo3w@gmail.com",
        "contrato" => 700.00,
        "ativo" => false
    ]
];


// formatar moeda
function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}


// formatar o nome
function formatarNome(string $nome): string
{
    return ucwords(strtolower(trim($nome)));
}


// limpa cpf
function limparCPF(string $cpf): string
{
    return str_replace(['.', '-', ' '], '', trim($cpf));
}


// formatar cpf
function formatarCPF(string $cpf): string
{
    $cpf = limparCPF($cpf);

    if (strlen($cpf) === 11) {

        return substr($cpf, 0, 3) . "." .
               substr($cpf, 3, 3) . "." .
               substr($cpf, 6, 3) . "-" .
               substr($cpf, 9, 2);

    } else {

        return $cpf;

    }
}


// validar cpf
function cpfValido(string $cpf): bool
{
    $cpf = limparCPF($cpf);

    if (strlen($cpf) === 11 && is_numeric($cpf)) {

        return true;

    } elseif (strlen($cpf) === 0) {

        return false;

    } else {

        return false;

    }
}


// validar email
function validarEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}


// validar nome
function validarNome(string $nome): bool
{
    $nome = trim($nome);

    if ($nome === "") {

        return false;

    } elseif (strlen($nome) < 3) {

        return false;

    } else {

        return true;

    }
}


// validar contrato
function validarContrato(float $valor): bool
{
    if ($valor > 0) {

        return true;

    } elseif ($valor === 0.0) {

        return false;

    } else {

        return false;

    }
}


// buscar cliente
function buscarCliente(array $clientes, string $opcap): ?array
{
    $nomeBusca = strtolower(trim($opcap));

    foreach ($clientes as $cliente) {

        $nomeCliente = strtolower(trim($cliente["nome"]));

        if ($nomeCliente === $nomeBusca) {

            return $cliente;

        }
    }

    return null;
}


//calcular contratos
function calcularTotalContratosAtivos(array $clientes): float
{
    $total = 0.0;

    foreach ($clientes as $cliente) {

        if ($cliente["ativo"] === true) {

            $total = $total + $cliente["contrato"];

        }
    }

    return $total;
}


// calcular média dos contratos
function calcularMediaContratos(array $clientes): float
{
    if (count($clientes) === 0) {

        return 0.0;

    }

    $total = 0.0;

    foreach ($clientes as $cliente) {

        $total = $total + $cliente["contrato"];

    }

    return $total / count($clientes);
}


// reajuste
function aplicarReajuste(float &$contrato, float $percentual): void
{
    $reajuste = $contrato * ($percentual / 100);

    $contrato = $contrato + $reajuste;
}


//contar clientes

function contarClientesAtivos(array $clientes): int
{
    $total = 0;

    foreach ($clientes as $cliente) {

        if ($cliente["ativo"] === true) {

            $total++;

        }
    }

    return $total;
}


// maior contrato
function maiorContrato(array $clientes): float
{
    if (count($clientes) === 0) {

        return 0.0;

    }

    $maior = 0.0;

    foreach ($clientes as $cliente) {

        if ((float) $cliente["contrato"] > $maior) {

            $maior = (float) $cliente["contrato"];

        }
    }

    return $maior;
}

?>