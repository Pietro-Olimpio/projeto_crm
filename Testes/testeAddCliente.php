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


// add de um cliente novo
$nome = readline("Digite o nome: ");
$cpf = readline("Digite o CPF: ");
$email = readline("Digite o e-mail: ");
$contrato = (float) readline("Digite o valor do contrato: ");
$ativo = readline("O cliente está ativo? (sim/nao): ");
//aqui eu pesso pro usuario adicionar as informações do cliente


$novoCliente = [
    "nome" => $nome,
    "cpf" => $cpf,
    "email" => $email,
    "contrato" => $contrato,
    "ativo" => strtolower($ativo) === "sim"
];

array_push($clientes, $novoCliente);

echo "\nCliente adicionado com sucesso!\n";

?>