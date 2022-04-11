<?php
    $nrData         = 1;
    $nrProposta     = 1;
    $nrLaudo        = 1;
    $nrCliente      = 1;
    $nrEngenheiro   = 1;
    $nrProfissional = 1;
    $nrDiretoria    = 1;
    $nrDocumento    = 1;
    $nrEditor       = 1;

    function setNr($nr){
        echo $nr++;
        return $nr;
    }

?>
<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis do editor</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrEditor = setNr($nrEditor); ?></td>
                    <td>Anexos</td>
                    <td>{{ANEXOS}}</td>
                </tr>
                <tr>
                    <td><?php $nrEditor = setNr($nrEditor); ?></td>
                    <td>Quebra de página</td>
                    <td>{{QUEBRA-PAGINA}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis de data</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrData = setNr($nrData); ?></td>
                    <td>Dia</td>
                    <td>{{DIA}}</td>
                </tr>
                <tr>
                    <td><?php $nrData = setNr($nrData); ?></td>
                    <td>Mes por extenso</td>
                    <td>{{MES.EXTENSO}}</td>
                </tr>
                <tr>
                    <td><?php $nrData = setNr($nrData); ?></td>
                    <td>Ano completo</td>
                    <td>{{ANO}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis da proposta</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrProposta = setNr($nrProposta); ?></td>
                    <td>Código da propósta</td>
                    <td>{{PROPOSTA.CD}}</td>
                </tr>
                <tr>
                    <td><?php $nrProposta = setNr($nrProposta); ?></td>
                    <td>Valor da propósta</td>
                    <td>{{PROPOSTA.VALOR}}</td>
                </tr>
                <tr>
                    <td><?php $nrProposta = setNr($nrProposta); ?></td>
                    <td>Tipo de serviço</td>
                    <td>{{PROPOSTA.TIPO_SERVICO}}</td>
                </tr>
                <tr>
                    <td><?php $nrProposta = setNr($nrProposta); ?></td>
                    <td>serviços</td>
                    <td>{{PROPOSTA.SERVICOS}}</td>
                </tr>
                <tr>
                    <td><?php $nrProposta = setNr($nrProposta); ?></td>
                    <td>condição de pagamento</td>
                    <td>{{PROPOSTA.CONDICAO_PAGTO}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis do documento</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrDocumento = setNr($nrDocumento); ?></td>
                    <td>Descrição do documento</td>
                    <td>{{DOCUMENTO.DESCRICAO}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis do laudo</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrLaudo = setNr($nrLaudo); ?></td>
                    <td>data de inspeção do laudo</td>
                    <td>{{LAUDO.DT_INSPECAO}}</td>
                </tr>
                <tr>
                    <td><?php $nrLaudo = setNr($nrLaudo); ?></td>
                    <td>número do ART do laudo</td>
                    <td>{{LAUDO.ART}}</td>
                </tr>
                <tr>
                    <td><?php $nrLaudo = setNr($nrLaudo); ?></td>
                    <td>ANEXOS</td>
                    <td>{{ANEXOS}}</td>
                </tr>              
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis do cliente</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Nome/empresa do cliente</td>
                    <td>{{CLIENTE.EMPRESA}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>E-mail do cliente</td>
                    <td>{{CLIENTE.EMAIL}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Telefone do cliente</td>
                    <td>{{CLIENTE.TELEFONE}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Celular do cliente</td>
                    <td>{{CLIENTE.CELULAR}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>CPF/CNPJ do cliente</td>
                    <td>{{CLIENTE.DOCUMENTO}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Endereço do cliente</td>
                    <td>{{CLIENTE.ENDERECO}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Bairro do cliente</td>
                    <td>{{CLIENTE.BAIRRO}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>CEP do cliente</td>
                    <td>{{CLIENTE.CEP}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Contato do cliente</td>
                    <td>{{CLIENTE.RESPONSAVEL}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Cidade do cliente</td>
                    <td>{{CLIENTE.CIDADE}}</td>
                </tr>
                <tr>
                    <td><?php $nrCliente = setNr($nrCliente); ?></td>
                    <td>Sigla do estado do cliente</td>
                    <td>{{CLIENTE.ESTADO.SIGLA}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis do engenheiro</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrEngenheiro = setNr($nrEngenheiro); ?></td>
                    <td>Nome do engenheiro</td>
                    <td>{{ENGENHEIRO.NOME}}</td>
                </tr>
                <tr>
                    <td><?php $nrEngenheiro = setNr($nrEngenheiro); ?></td>
                    <td>CREA do engenheiro</td>
                    <td>{{ENGENHEIRO.CREA}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de variaveis da diretoria</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Campo</th>
                    <th>Variavel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $nrDiretoria = setNr($nrDiretoria); ?></td>
                    <td>Nome do diretor</td>
                    <td>{{DIRETOR.NOME}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>