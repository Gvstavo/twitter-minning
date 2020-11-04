$(function() {
    arvore = [];
    carregarFuncoesInicializacao();
});

function carregarFuncoesInicializacao() {
    $('#informarTagTweet').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'obter', tag: $('#tagTweet').val()},
            success: function(response) {
                $('#tabelaLocal').hide();
                $('#tabelaListagem').hide();
                $('#tabelaArvore').hide();
                alert('Tweets obtidos com sucesso');
            }
        });
    });

    $('#criarIndice').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'criarIndices'},
            success: function(response) {
                $('#tabelaLocal').hide();
                $('#tabelaListagem').hide();
                $('#tabelaArvore').hide();
                alert('Indices criados com sucesso');
            }
        });
    })

    $('#listarTodos').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'listarTodos'},
            success: function(response) {
                $('#tabelaListagem tbody').html('');
                $('#tabelaListagem').show();
                $('#tabelaLocal').hide();
                $('#tabelaArvore').hide();
                for (tweet in response) {
                    arvore.push({id: response[tweet].id, address: tweet, hash: response[tweet].hash});
                    $('#tabelaListagem tbody').append('<tr><td>'+ response[tweet].id +'</td><td>'+ response[tweet].dataCriacao +'</td><td>'+ response[tweet].localizacaoUsuario +'</td><td>'+ response[tweet].nomeUsuario + '</td><td>'+ response[tweet].tweet +'</td></tr>')
                }
            }
        });
    })

    $('#informarIdTweet').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'listar', id: $('#idTweet').val()},
            success: function(response) {
                $('#tabelaListagem tbody').html('');
                $('#tabelaListagem').show();
                $('#tabelaLocal').hide();
                $('#tabelaArvore').hide();
                $('#tabelaListagem tbody').append('<tr><td>'+ response.id +'</td><td>'+ response.dataCriacao +'</td><td>'+ response.localizacaoUsuario +'</td><td>'+ response.nomeUsuario + '</td><td>'+ response.tweet +'</td></tr>')
            }
        });
    })

    $('#mostrarLocal').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'mostrarLocal'},
            success: function(response) {
                $('#tabelaLocal tbody').html('');
                $('#tabelaLocal').show();
                $('#tabelaListagem').hide();
                $('#tabelaArvore').hide();
                $('#tabelaLocal tbody').append('<tr><td>'+ response.local[0] +'</td><td>'+ response.quantidade +' tweets</td></tr>')
            }
        });
    })
    
    $('#mostrarArvore').on('click', function () {
        $('#tabelaArvore tbody').html('');
        $('#tabelaLocal').hide();
        $('#tabelaListagem').hide();
        $('#tabelaArvore').show();
        for (nodo in arvore) {
            $('#tabelaArvore tbody').append('<tr><td>'+ arvore[nodo].id +'</td><td>'+ arvore[nodo].address  +'</td><td>'+ arvore[nodo].hash +'</td></tr>')
        }
    })

    $('#informarArvore').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'listar', id: arvore[$('#idArvore').val()].id},
            success: function(response) {
                $('#tabelaListagem tbody').html('');
                $('#tabelaListagem').show();
                $('#tabelaLocal').hide();
                $('#tabelaArvore').hide();
                $('#tabelaListagem tbody').append('<tr><td>'+ response.id +'</td><td>'+ response.dataCriacao +'</td><td>'+ response.localizacaoUsuario +'</td><td>'+ response.nomeUsuario + '</td><td>'+ response.tweet +'</td></tr>')
            }
        });
    })

    $('#informarHash').on('click', function () {
        $.ajax({
            type: "POST",
            url: "model/home.services.php",
            data: {action: 'listar', id: arvore.find(tweet => tweet.hash === $('#hashArvore').val()).id},
            success: function(response) {
                $('#tabelaListagem tbody').html('');
                $('#tabelaListagem').show();
                $('#tabelaLocal').hide();
                $('#tabelaArvore').hide();
                $('#tabelaListagem tbody').append('<tr><td>'+ response.id +'</td><td>'+ response.dataCriacao +'</td><td>'+ response.localizacaoUsuario +'</td><td>'+ response.nomeUsuario + '</td><td>'+ response.tweet +'</td></tr>')
            }
        });
    })
    
}

function insert(tree, value) {
    if (tree.value) {
        if (value > tree.value) {
            insert(tree.right, value)
        } else {
            insert(tree.left, value)
        }
    } else {
        tree.value = value
        tree.right = {}
        tree.left = {}
    }
}