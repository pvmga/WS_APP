<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MySoapServer extends MY_Controller {

    function __construct() {
        parent::__construct();
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: false');
    }

    public function index() {
        
    }

    public function getUsuarios() {

        $this->load->model('mysoap_models');
        $usuario = $_GET['usuario'];
        $senha = $_GET['senha'];

        $usuarios = $this->mysoap_models->getUsuariosModels($usuario, $senha);
        echo json_encode($usuarios);
    }

    public function getClientes() {
        $this->load->model('mysoap_models');

        $vendedor = $_GET['vendedor'];
        $clientes = $this->mysoap_models->getClientesModels($vendedor);
        echo json_encode($clientes);
    }

    public function getProdutos() {
        $this->load->model('mysoap_models');
        $codigoProduto = isset($_GET['codigoProduto']) ? $_GET['codigoProduto'] : 0;

        $produtos = $this->mysoap_models->getProdutosModels($codigoProduto);
        echo json_encode($produtos);
    }

    public function getDadosVendas() {
        $this->load->model('mysoap_models');

        $num_venda = $_GET['num_venda'];

        $vendas = $this->mysoap_models->getDadosVendasModels($num_venda);
        echo json_encode($vendas);
    }

    public function getVendas() {
        $this->load->model('mysoap_models');

        $vendedor = $_GET['vendedor'];
        $datas = $this->input->post('datas');

        $data_venda_inicial = explode("/", empty($datas['dt_inicial']) ? '01/01/1993' : $datas['dt_inicial']);
        $data_venda_final = explode("/", empty($datas['dt_final']) ? date('Ymd') : $datas['dt_final']);

        $data_inicial = $data_venda_inicial[2] . $data_venda_inicial[1] . $data_venda_inicial[0];
        $data_final = $data_venda_final[2] . $data_venda_final[1] . $data_venda_final[0];

        $vendas = $this->mysoap_models->getVendasModels($vendedor, $data_inicial, $data_final);
        echo json_encode($vendas);
    }

    public function getCondPagamentos() {
        $this->load->model('mysoap_models');

        $cond_pagamento = $this->mysoap_models->getCondPagamentosModels();
        echo json_encode($cond_pagamento);
    }

    public function getTipoPagamentos() {
        $this->load->model('mysoap_models');

        $tipo_pagamentos = $this->mysoap_models->getTipoPagamentosModels();
        echo json_encode($tipo_pagamentos);
    }

    public function getEstados() {
        $this->load->model('mysoap_models');

        $estados = $this->mysoap_models->getEstadosModels();
        echo json_encode($estados);
    }

    public function getNbmi() {
        $this->load->model('mysoap_models');

        $nbmi = $this->mysoap_models->getNbmiModels();
        echo json_encode($nbmi);
    }

    public function getParametros() {
        $this->load->model('mysoap_models');

        $parametros = $this->mysoap_models->getParametrosModels();
        echo json_encode($parametros);
    }

    public function inserirVenda() {
        $this->load->model('mysoap_models');
        $dadosVenda = $this->input->post('dadosVenda');
        $itensVenda = $this->input->post('itensVenda');

        //$cliente = $this->mysoap_models->getClientesModels();

        $parametros = $this->mysoap_models->getParametrosModels();

        $numero_venda = $this->mysoap_models->geraCodigoVenda();
        $codigo_venda = $numero_venda['GEN_VALUE'];

        $valor_total_itens = 0;
        $valor_total_ipi = 0;
        $valor_st = 0;

        for ($x = 0; $x < count($itensVenda); $x++) {
            $valor_unitario = str_replace(",", ".", $itensVenda[$x]['valor_unitario_original']);
            $valor_total = str_replace(",", ".", $itensVenda[$x]['valor_total']);

            $dadosItens = array(
                'COD_VENDA' => $codigo_venda,
                'COD_PROD' => $itensVenda[$x]['cod_produto'],
                'SEQUENCIA' => ($x + 1),
                'UNIDADE' => $itensVenda[$x]['unidade'],
                'QUANTIDADE' => $itensVenda[$x]['quantidade'],
                'QTDE_RESERVADA' => $itensVenda[$x]['quantidade'],
                'DESCONTO' => $itensVenda[$x]['percentual_desconto'],
                'ACRESCIMO' => $itensVenda[$x]['percentual_acrescimo'],
                'IPI' => $itensVenda[$x]['aliquota_ipi'],
                'FABRICAR' => 'N',
                'LARGURA' => 0,
                'GARANTIA' => 'N',
                'RETIRAR' => 'N',
                'VP' => 'N',
                'CUSTO_PRODUTO' => $itensVenda[$x]['custo_bruto'], // tipo preço depende do par_cash
                'COD_GRUPO' => $itensVenda[$x]['cod_grupo'],
                'VALOR_UNIT' => $valor_unitario,
                'VALOR_CUSTO' => $valor_unitario,
            );
            $dadosItens2[] = $dadosItens;
            $valor_total_itens += round($valor_total, 2);
        }

        $dados_itens[] = $this->mysoap_models->inserirVendaItens($dadosItens2);

        $dados = array(
            'COD_VENDA' => $codigo_venda,
            'COD_CLIENTE' => $dadosVenda['cod_clie'],
            'COD_PAGAMENTO' => empty($dadosVenda['condicao']) ? $parametros['COD_CONDPGTO_PADRAO'] : $dadosVenda['condicao'],
            'TIPO_PAGTO' => $dadosVenda['tipo'],
            'FRETE' => 0,
            'DATA_VENDA' => date('Ymd'),
            'PEDIDO_ECM' => 0,
            'COD_TRANSP' => empty($dadosVenda['transportadora']) ? $parametros['TRANSP_PADRAO'] : $dadosVenda['transportadora'],
            'CLASSIFICACAO' => 'I',
            'SITUACAO' => 'V',
            'DATA_HORA_VENDA' => date('Ymd h:i:s'),
            'ENVIADO_CAIXA' => 'N',
            'CONCLUIDA' => 'N',
            'PED_WEB' => 'S',
            'CONTATO' => 'APP',
            'NOTAFISCAL' => 'N',
            'USUARIO' => $dadosVenda['usuario'],
            'COD_VENDEDOR_EXT' => $dadosVenda['vendedor_externo'],
            'PAR_EMPRESA' => $parametros['CODIGO'],
            'TRANSPORTE' => $parametros['FRETE_PADRAO'],
            'COD_VENDEDOR' => empty($dadosVenda['codigo_vendedor']) ? $parametros['ONLINE_COD_VEND_INTERNO_PADRAO'] : $dadosVenda['codigo_vendedor'],
            'OBS_COMP' => addslashes($dadosVenda['observacao']),
            'IMPRIMIU' => 'N',
            'VALOR_PAGO' => $valor_total_itens,
            'TOTAL_VENDA' => $valor_total_itens,
            'VALOR_DESC' => $valor_total_itens,
            'VALOR_OUTROS' => round($valor_st - $valor_total_ipi, 2), // EM TESTE
            'VALOR_IPI' => round($valor_total_ipi, 2), // EM TESTE
        );

        $dados_venda = $this->mysoap_models->inserirVendaModels($dados);

        echo json_encode(array(
            'cod_venda' => $codigo_venda
        ));
    }

    public function existeVenda() {
        $this->load->model('mysoap_models');

        $cod_venda = $this->input->post('codVenda');

        $venda = $this->mysoap_models->verificaExistenciaVenda($cod_venda);

        echo json_encode(array('msg' => 'Venda inserida com sucesso !', 'dados' => $venda));
    }

    public function inserirCliente() {
        $dadosCliente = $this->input->post('dadosCliente');
        //$codigo_vendedor = $this->input->post('codigo_vendedor');
        $cod_vendedor_externo = $this->input->post('cod_vendedor_externo');

        if ($dadosCliente['natureza'] == 'J') {
            $CGC = $dadosCliente['cgc'];
            $CPF = NULL;
            $RG = NULL;
            $INSCRICAO = $dadosCliente['inscricao'];
        } else {
            $CGC = '00.000.000/0000-00';
            $CPF = $dadosCliente['cpf'];
            $RG = $dadosCliente['inscricao'];
            $INSCRICAO = NULL;
        }

        $this->load->model('mysoap_models');

        // Verifica a existência do codigo interno, caso exista será considerado alteração de registro.
        if ($dadosCliente['ref_codigo'] == '') {
            $CODIGO = $this->mysoap_models->gerarCodigoCliente();
        } else {
            $CODIGO = $dadosCliente['ref_codigo'];
        }

        $parametros = $this->mysoap_models->getParametrosModels();

        $dados = array(
            'CODIGO' => $CODIGO,
            'NATUREZA' => $dadosCliente['natureza'],
            'CGC' => $CGC,
            'INSCRICAO' => $INSCRICAO,
            'CPF' => $CPF,
            'RG' => $RG,
            'RAZAO_SOCIAL' => ($this->uppercasebr(addslashes($dadosCliente['razao_social']))),
            'NOME_FANTASIA' => ($this->uppercasebr($dadosCliente['nome_fantasia'])),
            'CEP' => $dadosCliente['cep'],
            'ENDERECO' => ($this->uppercasebr($this->formataTextoAspas(addslashes($dadosCliente['endereco'])))),
            'NUM_END_PRINCIPAL' => $dadosCliente['num_end_principal'],
            'COMP_ENDERECO' => ($this->uppercasebr(addslashes($dadosCliente['comp_endereco']))),
            'BAIRRO' => ($this->uppercasebr(addslashes($dadosCliente['bairro']))),
            'CIDADE' => ($this->uppercasebr(addslashes($dadosCliente['cidade']))),
            'ESTADO' => ($this->uppercasebr(addslashes($dadosCliente['estado']))),
            'TELEFONE' => $dadosCliente['telefone'],
            'CELULAR' => $dadosCliente['celular'],
            //'FAX' => $this->input->post('dados')[12],
            'CONTATO' => ($this->uppercasebr(addslashes($dadosCliente['contato']))),
            //'WEBSITE' => ($this->uppercasebr(addslashes($this->input->post('dados')[14]))),
            'TRANSPORTADORA' => $parametros['TRANSP_PADRAO'],
            'EMAIL' => ($this->uppercasebr(addslashes($dadosCliente['email']))),
            'OBS_CADASTRO' => ($this->uppercasebr(($dadosCliente['obs_cadastro']))),
            'TIPO_CLIENTE' => 'A',
            'TIPO' => 'A',
            'DATA_CADASTRO' => date('Ymd'),
            'USUARIO_CADASTRO' => 'APP',
            'ECOMMERCE' => 'S',
            'CODIGO_VENDEDOR' => $parametros['ONLINE_COD_VEND_INTERNO_PADRAO'],
            'VENDEDOR_EXTERNO' => $cod_vendedor_externo
        );

        if ($dadosCliente['ref_codigo'] == '') {
            $this->mysoap_models->inserirCliente($dados);
        } else {
            $this->mysoap_models->updateCliente($dados);
        }
        echo json_encode($CODIGO);
    }

    public function uppercasebr($str) {

        return strtoupper(strtr($str, "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
    }

    public function formataTextoAspas($string) {
        $search = array("'", "‘", "’");
        $replace = array(" ", " ", " ");
        $string = str_replace($search, $replace, $string);
        return $string;
    }

    public function enviarEmailPedido() {
        $this->load->model('mysoap_models');
        $cod_venda = $this->input->post('codVenda');
        $dadosVenda = $this->input->post('dadosVenda');
        $itensVenda = $this->input->post('itensVenda');

        //echo json_encode(array('dadosVenda' => $dadosVenda, 'itensVenda' => $itensVenda));
        //exit();

        $parametros = $this->mysoap_models->getParametrosModels();

        if (filter_var($dadosVenda['dadosCliente']['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $this->getConfigEmail($cod_venda, $dadosVenda, $itensVenda, $parametros);
        } else {
            // quando o e-mail do cliente está incorreto.
            $email = '2';
        }
        //echo json_encode(array('email' => $email, 'dados' => $dados));
        echo json_encode($email);
        exit();
    }

}
