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

// formatar moeda
function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}

//calcular contratos
function calcularTotalContratosAtivos(array $clientes): float
{
    $total = 0;

    foreach ($clientes as $cliente) {
        if ($cliente["ativo"] === true) {
            $total = $total + $cliente["contrato"];
        }
    }

    return $total;
}

$totalAtivos = calcularTotalContratosAtivos($clientes);

echo "Valor total dos contratos ativos: " . formatarMoeda($totalAtivos) . "\n";
?>