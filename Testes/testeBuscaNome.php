<?php declare(strict_types=1); 

//array
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

//funções

// formatar moeda
function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}


// formatar o nome
function formatarNome(string $nome): string
{
    return ucfirst(strtolower(trim($nome)));
}


// limpa cpf
function limparCPF(string $cpf): string
{
    return str_replace(['.', '-'], '', $cpf);
}


// validar cpf
function cpfValido(string $cpf): bool
{
    $cpf = limparCPF($cpf);

    return strlen($cpf) === 11 && is_numeric($cpf);
}

// validar email
function validarEmail(string $email): bool
{
    return str_contains($email, "@");
}



// lista cliente
foreach ($clientes as $cliente) {

    echo "Nome: " . formatarNome($cliente["nome"]) . "\n";
    
    if (cpfValido($cliente["cpf"])) {
        echo "CPF: válido\n";
    } else {
        echo "CPF: inválido\n";
    }

   

    if (validarEmail($cliente["email"])) {
        echo "email: valido\n";
    } else {
        echo "email: invalido\n";
    }

    if ($cliente["ativo"]) {
        echo "Situação: Ativo\n";
    } else {
        echo "Situação: Inativo\n";
    }
}


// Busca por nome
$opcap = readline("Busque pelo cliente pelo seu nome: ");

function buscarCliente(array $clientes, string $opcap): ?array
{
    $nomeBusca = strtolower(trim($opcap));

    foreach ($clientes as $cliente) {

        $nomeCliente = strtolower(trim($cliente["nome"]));

        if ($nomeCliente === $nomeBusca) {

            echo "\nCliente encontrado\n";
            echo "Nome: " . formatarNome($cliente["nome"]) . "\n";
            echo "CPF: " . $cliente["cpf"] . "\n";
            echo "Email: " . $cliente["email"] . "\n";
            echo "Contrato: " . formatarMoeda($cliente["contrato"]) . "\n";

            if ($cliente["ativo"]) {
                echo "Situação: Ativo\n";
            } else {
                echo "Situação: Inativo\n";
            }

            return $cliente;
        }
    }

    echo "\nencontrei nada não, digita certo burro\n";

    return null;
}

?>