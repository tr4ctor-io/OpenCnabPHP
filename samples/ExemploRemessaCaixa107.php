<?php
/*
* CnabPHP - Geração de arquivos de remessa e retorno em PHP
*
* LICENSE: The MIT License (MIT)
*
* Copyright (C) 2013 Ciatec.net
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of this
* software and associated documentation files (the "Software"), to deal in the Software
* without restriction, including without limitation the rights to use, copy, modify,
* merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
* permit persons to whom the Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be included in all copies
* or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
* INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
* PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
* OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
* SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace CnabPHP\samples;


require_once ("../autoloader.php");

use CnabPHP\Remessa;

$arquivo = new Remessa('104', 'cnab240_107', array(
    'nome_empresa' =>"MEGA ASSISTENCIA FAMILIAR LTDA", // seu nome de empresa
    'tipo_inscricao' => 2, // 1 para cpf, 2 cnpj
    'numero_inscricao' => '12.457.484/0001-81', // seu cpf ou cnpj completo
    'agencia' => "01584", // agencia sem o digito verificador
    'agencia_dv' => '9', // somente o digito verificador da agencia
    'conta' => '3848', // número da conta
    'conta_dv' => '4', // digito da conta
    'posto' => '', // codigo forncecido pelo sicredi obs: como o dv da agencia não é informado eu armazeno no banco de dados essa valor no dv da agencia
    'codigo_beneficiario' => '251632', // codigo fornecido pelo banco
    'convenio' => '508549', // codigo fornecido pelo banco
    'carteira' => '1', // codigo fornecido pelo banco
    'codigo_beneficiario_dv' => '2', // codigo fornecido pelo banco
    'numero_sequencial_arquivo' => 33069,
    'situacao_arquivo' => 'P', // use T para teste e P para produ��o
    'mensagem_1' => 'Sua mensagem personalizada para todos os boletos do arquivo aqui' // suportado somente para SICOOB cnab400, mudar o numero 1 para 2,3,4,5 para incluir mais mensagens
));

//var_dump($arquivo->getText());die;
$lote  = $arquivo->addLote(array('tipo_servico'=> 1)); // tipo_servico  = 1 para cobrança registrada, 2 para sem registro

$lote->inserirDetalhe(array(
    'codigo_movimento'  => 1, //1 = Entrada de título, para outras opções ver nota explicativa C004 manual Cnab_SIGCB na pasta docs
    // CCNNNNNNNNNNNNNSS
    'nosso_numero'      => '14003306900100270', // numero sequencial de boleto
    'seu_numero'        => '0033069.001',// se nao informado usarei o nosso numero

    /* campos necessarios somente para itau e siccob,  não precisa comentar se for outro layout    */
    'carteira_banco'    => 109, // codigo da carteira ex: 109,RG esse vai o nome da carteira no banco
    'cod_carteira'      => "1", // I para a maioria ddas carteiras do itau
    'codigo_carteira'   => 1, // I para a maioria ddas carteiras do itau
     /* campos necessarios somente para itau,  não precisa comentar se for outro layout    */

    'especie_titulo'    => "NP", // informar dm e sera convertido para codigo em qualquer laytou conferir em especie.php
    'valor'             => 33.90, // Valor do boleto como float valido em php
    'emissao_boleto'    => 2, // tipo de emissao do boleto informar 2 para emissao pelo beneficiario e 1 para emissao pelo banco
    'protestar'         => 3, // 1 = Protestar com (Prazo) dias, 3 = Devolver após (Prazo) dias
    'prazo_protesto'    => 5, // Informar o numero de dias apos o vencimento para iniciar o protesto
    'nome_pagador'      => "CHARLES MUNIZ", // O Pagador é o cliente, preste atenção nos campos abaixo
    'tipo_inscricao'    => 1, //campo fixo, escreva '1' se for pessoa fisica, 2 se for pessoa juridica
    'numero_inscricao'  => '901.419.464-15',//cpf ou ncpj do pagador
    'endereco_pagador'  => 'Rua dos developers,123 sl 103',
    'bairro_pagador'    => 'Bairro da insonia',
    'cep_pagador'       => '12345-123', // com hífem
    'cidade_pagador'    => 'Londrina',
    'uf_pagador'        => 'PR',
    'data_vencimento'   => '2024-07-15', // informar a data neste formato
    'data_emissao'      => '2024-06-27', // informar a data neste formato
    'vlr_juros'         => 0.15, // Valor do juros de 1 dia'
    'codigo_desconto2'  => '1', // comentar se não for usar segundo desconto
    'data_desconto'     => '2024-07-10', // informar a data neste formato
    'data_desconto2'    => '2024-07-10', // informar a data neste formato
    'data_desconto3'    => '2024-07-10', // informar a data neste formato
    'vlr_desconto'      => '0', // Valor do desconto
    'vlr_desconto2'     => '0', // Valor do desconto
    'vlr_desconto3'     => '0', // Valor do desconto
    'baixar'            => 1, // codigo para indicar o tipo de baixa '1' (Baixar/ Devolver) ou '2' (Não Baixar / Não Devolver)
    'prazo_baixar'      => 15, // prazo de dias para o cliente pagar após o vencimento
    'mensagem'          => 'JUROS de 0,15 ao dia'.PHP_EOL."Não receber apos 15 dias",
    'data_multa'        => '2024-07-16', // informar a data neste formato, // data da multa
    'vlr_multa'         => 2, // valor da multa
    'parcela'           => 1, // valor da multa
    'modalidade'        => 1, // valor da multa
    'tipo_formulario'   => 1, // valor da multa

    // campos necessários somente para o sicoob
    //'cod_instrucao1'     => 1, //instrução para cobrar juros novas regras da base de boletos unificada
    //'cod_instrucao2'     => 1, //instrução para cobrar juros novas regras da base de boletos unificada
    //'taxa_multa'         => 0.00, // taxa de multa em percentual
    //'taxa_juros'         => 0.00, // taxa de juros em percentual
));
$lote->inserirDetalhe(array(
    'codigo_movimento'  => 1, //1 = Entrada de título, para outras opções ver nota explicativa C004 manual Cnab_SIGCB na pasta docs
    // CCNNNNNNNNNNNNNSS
    'nosso_numero'      => '140000000004401', // numero sequencial de boleto
    'seu_numero'        => '0000000004401',// se nao informado usarei o nosso numero

    /* campos necessarios somente para itau e siccob,  não precisa comentar se for outro layout    */
    'carteira_banco'    => 109, // codigo da carteira ex: 109,RG esse vai o nome da carteira no banco
    'cod_carteira'      => "1", // I para a maioria ddas carteiras do itau
    'codigo_carteira'   => 1, // I para a maioria ddas carteiras do itau
     /* campos necessarios somente para itau,  não precisa comentar se for outro layout    */

    'especie_titulo'    => "NP", // informar dm e sera convertido para codigo em qualquer laytou conferir em especie.php
    'valor'             => 5.00, // Valor do boleto como float valido em php
    'emissao_boleto'    => 2, // tipo de emissao do boleto informar 2 para emissao pelo beneficiario e 1 para emissao pelo banco
    'protestar'         => 3, // 1 = Protestar com (Prazo) dias, 3 = Devolver após (Prazo) dias
    'prazo_protesto'    => 5, // Informar o numero de dias apos o vencimento para iniciar o protesto
    'nome_pagador'      => "RAMON BARROS", // O Pagador é o cliente, preste atenção nos campos abaixo
    'tipo_inscricao'    => 1, //campo fixo, escreva '1' se for pessoa fisica, 2 se for pessoa juridica
    'numero_inscricao'  => '012.458.370-95',//cpf ou ncpj do pagador
    'endereco_pagador'  => 'Rua Ary Fortunato Garbin, 54 Casa 11',
    'bairro_pagador'    => 'São Caetano',
    'cep_pagador'       => '95095-265', // com hífem
    'cidade_pagador'    => 'Caxias do Sul',
    'uf_pagador'        => 'RS',
    'data_vencimento'   => '2024-07-15', // informar a data neste formato
    'data_emissao'      => '2024-06-27', // informar a data neste formato
    'vlr_juros'         => 0.15, // Valor do juros de 1 dia'
    'codigo_desconto2'  => '1', // comentar se não for usar segundo desconto
    'data_desconto'     => '2024-07-10', // informar a data neste formato
    'data_desconto2'    => '2024-07-10', // informar a data neste formato
    'data_desconto3'    => '2024-07-10', // informar a data neste formato
    'vlr_desconto'      => '0', // Valor do desconto
    'vlr_desconto2'     => '0', // Valor do desconto
    'vlr_desconto3'     => '0', // Valor do desconto
    'baixar'            => 1, // codigo para indicar o tipo de baixa '1' (Baixar/ Devolver) ou '2' (Não Baixar / Não Devolver)
    'prazo_baixar'      => 15, // prazo de dias para o cliente pagar após o vencimento
    'mensagem'          => 'JUROS de 0,15 ao dia'.PHP_EOL."Não receber apos 15 dias",
    'data_multa'        => '2024-07-16', // informar a data neste formato, // data da multa
    'vlr_multa'         => 2, // valor da multa
    'parcela'           => 1, // valor da multa
    'modalidade'        => 1, // valor da multa
    'tipo_formulario'   => 1, // valor da multa

    // campos necessários somente para o sicoob
    //'cod_instrucao1'     => 1, //instrução para cobrar juros novas regras da base de boletos unificada
    //'cod_instrucao2'     => 1, //instrução para cobrar juros novas regras da base de boletos unificada
    //'taxa_multa'         => 0.00, // taxa de multa em percentual
    //'taxa_juros'         => 0.00, // taxa de juros em percentual
));
header("Content-Disposition: attachment;filename=" . $arquivo->getFileName() .";");
echo utf8_decode($arquivo->getText()); // observar a header do seu php para não gerar comflitos de codificação de caracteres

?>
