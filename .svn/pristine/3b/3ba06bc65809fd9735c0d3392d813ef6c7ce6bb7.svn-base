<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>E-mail referente a pedidos do sistema Online !</title>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="60%">		
                <div style="background-color:#f7f7f7; color:#cc0000; font:bold 15px Arial; font-weight:bold; padding:10px;"><?= $parametros['NOME_FANTASIA'] ;?></div>
            </td>
            <td align="right">
				<img src="data:image/jpge;base64,<?= base64_encode(''); ?>" width="120">
            </td>
    </table>
    <div style="background-color:#f7f7f7; color:#cc0000; font:bold 13px Arial; font-weight:bold; padding:6px;">Informações do cliente</div>

    <table width="100%" style="font:normal 12px Arial;">
        <tr>
            <td width="10%">Vendedor:</td>
            <td width="70%"><strong><?= $dados_pedido['vendedor_externo'] . ' - ' . $dados_pedido['dadosCliente']['nome_vendedor'] ?></strong></td>
        </tr>

        <tr>
            <td width="10%">Razão social / Nome:</td>
            <td width="70%"><strong><?= $dados_pedido['cod_clie'] . ' - ' . $dados_pedido['dadosCliente']['razao_social']; ?></strong></td>
        </tr>

        <tr>
            <td width="10%">Cidade cliente:</td>
            <td width="70%"><strong><?= $dados_pedido['dadosCliente']['cidade'] . '-' . $dados_pedido['dadosCliente']['estado']; ?></strong></td>
        </tr>
    </table>
    
    <div style="background-color:#f7f7f7; color:#cc0000; font:bold 13px Arial; font-weight:bold; padding:6px;">Produtos</div>
    <table width="100%">
        <thead>
            <tr style="background-color:#f7f7f7;color:#000000;font:normal 12px Arial; ">
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Código</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Descrição</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Sequencia</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Unidade</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Quantidade</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Valor Original.</b></th>
				<th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>(%) Acresc.</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>(%) Desc.</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Unit. Liq.</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Total Liq.</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>ST/IPI</b></th>
                <th style="padding:3px;font:normal 12px Arial; text-align: left;"><b>Total Produto</b></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($dados_itens as $key => $gridProdutos) {
                ?>
                <tr>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['cod_produto']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['descricao_produto']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $key +1; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['unidade']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['quantidade']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= 'R$'.$gridProdutos['valor_unitario_original']; ?></td>
					<td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['percentual_acrescimo']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['percentual_desconto']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['valor_unitario']; ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= number_format($gridProdutos['valor_unit_liq'], 2, ',', '.'); ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= number_format($gridProdutos['st_ipi'], 2, ',', '.'); ?></td>
                    <td style="border-bottom:1px solid #f0f0f0;font:normal 11px Arial;vertical-align:top"><?= $gridProdutos['valor_total']; ?></td>
                </tr>
            <?php } ?>
        </tbody>  
    </table>
    <div style="background-color:#f7f7f7; color:#cc0000; font:bold 13px Arial; font-weight:bold;  padding:6px;">Informações valores</div>

    <table width="100%" style="font:normal 12px Arial;">
        <tr>
            <td width="10%">Produtos</td>
            <td width="70%">R$ <strong><?= $dados_pedido['total_produtos']; ?></strong></td>
        </tr>
        <tr>
            <td width="10%">IPI/ST</td>
            <td width="70%">R$ <strong><?= $dados_pedido['total_st_ipi']; ?></strong></td>
        </tr>
        <tr>
            <td width="10%">Total</td>
            <td width="70%">R$ <strong><?= $dados_pedido['total_venda']; ?></strong></td>
        </tr>
    </table>
    
    <div style="background-color:#f7f7f7; color:#cc0000; font:bold 13px Arial; font-weight:bold;  padding:6px;">Informações do pedido</div>

    <table width="100%" style="font:normal 12px Arial;">
        <tr>
            <td width="10%">Observação:</td>
            <td width="70%"><strong><?= $dados_pedido['observacao']; ?></strong></td>
        </tr>
        <!--<tr>
            <td width="10%">Transportadora:</td>
            <td width="70%"><strong><?php //$dados_pedido['transportadora']; ?></strong></td>
        </tr>-->
        <tr>
            <td width="10%">Cond. de pagamento:</td>
            <td width="70%"><strong><?= $dados_pedido['condicao_descricao']; ?></strong></td>
        </tr
        <tr>
            <td width="10%">Tipo de pagamento:</td>
            <td width="70%"><strong><?= $dados_pedido['tipo_descricao']; ?></strong></td>
        </tr>
        <tr>
            <td width="10%">Número pedido:</td>
            <td width="70%"><strong><?= $cod_venda; ?></strong></td>
        </tr>
    </table>

    <div style="color:#cc0000; font:bold 13px Arial; font-weight:bold; font-style:italic;">E-mail do pedido enviado pelo representante.</div>
</body>
</html>
