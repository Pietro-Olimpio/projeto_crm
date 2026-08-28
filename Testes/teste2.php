<?php
declare(strict_types=1);

// Array
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

// Funções

function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}

function formatarNome(string $nome): string
{
    return ucfirst(strtolower(trim($nome)));
}

function limparCPF(string $cpf): string
{
    return str_replace(['.', '-'], '', $cpf);
}

function cpfValido(string $cpf): bool
{
    $cpf = limparCPF($cpf);

    return strlen($cpf) === 11 && is_numeric($cpf);
}

function validarEmail(string $email): bool
{
    return str_contains($email, "@");
}

function buscarCliente(array $clientes, string $opcap): ?array
{
    $nomeBusca = strtolower(trim($opcap));

    foreach ($clientes as $cliente) {

        $nomeCliente = strtolower(trim($cliente["nome"]));

        if ($nomeCliente === $nomeBusca) {

            echo "\nCliente encontrado!\n";
            echo "Nome: " . formatarNome($cliente["nome"]) . "\n";

            if (cpfValido($cliente["cpf"])) {
                echo "CPF: válido\n";
            } else {
                echo "CPF: inválido\n";
            }

            if (validarEmail($cliente["email"])) {
                echo "E-mail: válido\n";
            } else {
                echo "E-mail: inválido\n";
            }

            echo "Contrato: " . formatarMoeda($cliente["contrato"]) . "\n";

            if ($cliente["ativo"]) {
                echo "Situação: Ativo\n";
            } else {
                echo "Situação: Inativo\n";
            }

            return $cliente;
        }
    }

    echo "\nCliente não encontrado.\n";

    return null;
}


// Primeiro pergunta o nome
$opcap = readline("Digite o nome do cliente que deseja buscar: ");

// Depois procura e mostra os dados
buscarCliente($clientes, $opcap);

?>