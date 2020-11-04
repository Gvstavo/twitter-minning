<html>
<head>
    <title>Bem vindo ao sistema de minerar tweets</title>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../view/estilos.css">
    <script src="../view/form.home.js"></script>
</head>

<body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" class="active" href="#">Sistema de minerar tweets</a>
        </div>
        <div align="right">
            <p>Seja bem vindo Nataniel<b><span id="nomeusuario" type="text"></span></b></p>
        </div>
    </div>
    </nav>
    <div>
        <h1 class="centralizar-titulo">Sistema de minerar tweets</h1>
        <h2 class="centralizar-titulo">Nataniel Cainelli, Jonas Marcon, Gustavo Paiva</h2>
    </div>
    <br><br><br><br>
    <div class="container">
        <div class="centralizar-titulo">
            <div class="centralizar-titulo" id="divInformar">
                <input class="form" id="tagTweet" style="width: 200px" placeholder="Tag do twitter">
                <button type="button" class="btn btn-primary" id="informarTagTweet">Informar tag a ser minerada</button>
            </div> <br>
            <div class="centralizar-titulo">
                <input class="form" id="idTweet" style="width: 200px" placeholder="Id do tweet">
                <button type="button" class="btn btn-primary" id="informarIdTweet">Informar ID do tweet a ser buscado</button>
            </div>
            <br>
            <div class="centralizar-titulo" id="divInformar">
                <input class="form" id="idArvore" style="width: 200px" placeholder="id da arvore">
                <button type="button" class="btn btn-primary" id="informarArvore">Informar endereço da arvore para ser buscado</button>
            </div> <br>
            <div class="centralizar-titulo" id="divInformar">
                <input class="form" id="hashArvore" style="width: 200px" placeholder="hash">
                <button type="button" class="btn btn-primary" id="informarHash">Informar indice hash para ser buscado</button>
            </div> <br>
            <div class="centralizar-titulo">
                <button type="button" class="btn btn-primary" id="criarIndice">Criar arquivo de indices</button>
            </div>
            <br>
            <div class="centralizar-titulo" id="divListar">
                <button type="button" class="btn btn-primary" id="mostrarLocal" >Listar localização mais comum acessada</button>
            </div> <br>
            <div class="centralizar-titulo" id="divListar">
                <button type="button" class="btn btn-primary" id="listarTodos" >Listar ultimos tweets</button>
            </div> <br>
            <div class="centralizar-titulo" id="divListar"> 
                <button type="button" class="btn btn-primary" id="mostrarArvore" >Mostrar arvore</button>
            </div> <br>

        </div>
    </div>
    <br><br>
    <table id="tabelaListagem" class="table table-striped" style="display: none;">
        <thead class="thead-dark">
            <tr> 
                <th>Id Tweet</th>
                <th>Data</th>
                <th>Localização</th>
                <th>Nome usuário</th>
                <th>Tweet</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table id="tabelaLocal" class="table table-striped" style="display: none;">
        <thead class="thead-dark">
            <tr> 
                <th>Localização</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table id="tabelaArvore" class="table table-striped" style="display: none;">
        <thead class="thead-dark">
            <tr> 
                <th>Id</th>
                <th>Endereço no arquivo(linha)</th>
                <th>Hash</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="centralizar-titulo" id="divVoltar" style="display:none;"> 
        <button type="button" class="btn btn-primary" id="voltar">Voltar</button>
    </div>

<div id="saiu" style="display:none;" class="centralizar-titulo">
    <h1>Você saiu! Obrigado por usar o programa!</h1>
</div>
</body>
</html>