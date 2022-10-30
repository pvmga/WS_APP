<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        date_default_timezone_set('America/Sao_Paulo');
        parent::__construct();
    }

    public function getConfigEmail($cod_venda, $dadosVenda, $itensVenda, $parametros) {

        /* ESTRUTURA PADRÃO */
        $protocol = 'smtp';
        $smtp_crypto = '';
        $smtp_host = $parametros['ONLINE_SERVER_SMTP_USUARIO'];
        $smtp_user = $parametros['ONLINE_USER_SMTP'];
        $smtp_pass = $parametros['ONLINE_SENHA_EMAIL_USUARIO'];
        $smtp_port = $parametros['ONLINE_PORT_SMTP'];

        $config['protocol'] = $protocol;
        $config['smtp_host'] = $smtp_host;
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_crypto'] = $smtp_crypto;
        $config['smtp_timeout'] = '60';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
        $config['validate'] = TRUE; // define se haverá validação dos endereços de email

        $config['mailtype'] = 'html';

        // Inicializa a library Email, passando os parâmetros de configuração
        $this->email->initialize($config);

        // Define remetente e destinatário
		$this->email->from($dadosVenda['dadosCliente']['email_vendedor'], $parametros['ONLINE_NOME_EMAIL_USUARIO']);
		//$this->email->to($dadosVenda['dadosCliente']['email']); // Destinatário
		$this->email->to('vpaulo95@yahoo.com.br'); // Destinatário
		//$this->email->cc(array($parametros['EMAIL_RESPONSAVEL'], $dadosVenda['dadosCliente']['email_vendedor'])); // Cópia
        
        // Define o assunto do email
		$this->email->subject('PEDIDO: ' . $cod_venda);
		
		$data['dados_pedido'] = $dadosVenda;
		$data['dados_itens'] = $itensVenda;
		$data['parametros'] = $parametros;
		$data['cod_venda'] = $cod_venda;
		
		$this->email->message($this->load->view('view_email_template', $data, TRUE));
		//return $this->load->view('view_email_template', $data, TRUE);

        if ($this->email->send()) {
            return '1';
        } else {
            return '0';
        }
    }

}
