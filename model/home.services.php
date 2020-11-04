<?php 
	require_once '../vendor/autoload.php';

    $post = $_POST['action'];
    
    switch($post) {
        case 'listar': 
            header('Content-Type: application/json');
            echo json_encode(getListar($_POST['id']), true);
            break;
        case 'listarTodos': 
            header('Content-Type: application/json');
            echo json_encode(getAll(), true);
            break;
        case 'obter':
            header('Content-Type: application/json');
            echo json_encode(getTweet($_POST['tag']), true);
            break;
        case 'criarIndices':
            header('Content-Type: application/json');
            echo json_encode(createIndex(), true);
            break;
        case 'mostrarLocal':
            header('Content-Type: application/json');
            echo json_encode(getLocal(), true);
            break;            
    }

    function getListar($id) {
        $conteudoArquivo = obterConteudoArquivoResultado();
        $response = buscaBinaria($id, $conteudoArquivo);
        return $response;
    }

    function getAll() {
        return obterConteudoArquivoResultado();
    }

    function getTweet($tag) {
        $settings = array(
            'oauth_access_token' => "159069804-i4AN3jITKEG4IPnTNHjJycis1FBiga8G5QuspjTi",
            'oauth_access_token_secret' => "HYV6TCJb9uSyh7tg9BeXNIZrQfEOiXD2cXtLHvUxMPgyL",
            'consumer_key' => "s3NyAKsQbSGIo8NHDCoFpUZcr",
            'consumer_secret' => "iTUKO5Jeqk1OqkNWI9WrfESe8e6B7NlvPLnksNzN1xgbT3gIXe"
        );

        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=#'. $tag;
        $requestMethod = 'GET';
    
        $twitter = new TwitterAPIExchange($settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    
        $filename = '../resultado.csv';
        $retorno =  json_decode($response, true);
        $file = fopen($filename, 'a+');
        if (filesize($filename) == 0) {
            $header = ['data_criacao', 'id', 'linguagem', 'tweet', 'nome_usuario', 'localizacao_usuario'];
            fputcsv($file , $header, ';');
        }
        foreach ($retorno as $key => $tweet) {
            foreach ($tweet as $index => $content) {
                if ($content['id'] > 1) {
                    if (strlen($content['text']) < 200) {
                        $content['text'] = str_replace(";",",", $content['text']);
                        $tweetText = str_pad(str_replace("\n","  ", $content['text']), 200);
                    }
                    if (strlen($content['lang']) < 3) {
                        $tweetLang = str_pad($content['lang'], 3);
                    }
                    if (strlen($content['user']['name']) < 20) {
                        $nomeUsuario = str_pad($content['user']['name'], 20);
                    }
                    if (strlen($content['user']['location']) < 30) {
                        $localizacaoUsuario = str_pad($content['user']['location'], 30);
                    }
                    $dadosRelevantes = [$content['created_at'], $content['id'], $tweetLang, $tweetText, $nomeUsuario, $localizacaoUsuario];
                    fputcsv($file , $dadosRelevantes, ';');
                }
            }
        }
        fclose($file);

        return $tag;
    }

    function createIndex() {
        $conteudoArquivo = obterConteudoArquivoResultado();

        foreach ($conteudoArquivo as $index => $content) {
            if (!empty($content['id'])) {
                $tweets[intval($content['id'])] = [
                    'localizacao' => $content['localizacaoUsuario'],
                    'nomeUsuario' => $content['nomeUsuario']
                ];
            }
        }

        $conteudoTweets = [];
        foreach ($tweets as $id => $value) {
            if (!empty($value) && $id > 1) {
                $conteudoTweets[$id] = [$id, $value['localizacao'], $value['nomeUsuario']];
            }
        }
        //toda vez que for criar o arquivo de indices serão criados todos os indices novamente de forma ordenada
        $filename = '../indices.json';
        $file = fopen($filename, 'wr');
        $header = ['id', 'localizacao', 'nomeUsuario'];
        fputcsv($file , $header, ';');

        foreach ($conteudoTweets as $key => $value) {
            fputcsv($file, $value, ';');
        }
        fclose($file);
    }

    function obterConteudoArquivoResultado() {
        $handle = fopen("../resultado.csv", "r");
        $row = 0;
        $conteudoArquivo = [];
        while ($line = fgetcsv($handle, 1000, ";")) {
            if ($row++ == 0) {
                continue;
            }
            $conteudoArquivo[] = [
                'dataCriacao' => $line[0],
                'id' => $line[1],
                'linguagem' => $line[2],
                'tweet' => $line[3],
                'nomeUsuario' => $line[4],
                'localizacaoUsuario' => $line[5],
                'hash' => md5($line[1])
            ];
        }
        fclose($handle);

        return $conteudoArquivo;
    }

    function buscaBinaria($idTweet, $conteudoArquivo) {
        foreach ($conteudoArquivo as $key => $value) {
            $lista[$value['id']] = $value;
        }
        if ($lista[$idTweet]) { //se encontrar no primeiro endereço da memória retorna o tweet direto
            return $lista[$idTweet];
        }
        $el = $idTweet; // Elemento a ser encontrado
        $id = 0;
        while (is_array($lista)){
            $ini = 0; // Elemento inicial da lista
            $mid = floor(count($lista)/2); // Elemento no meio da lista
            $end = count($lista)-1; // Elemento final da lista

            if ($lista[$mid] < $el){ // Se o elemento estiver na segunda parte da lista
                $tmp = Array();
                for($i = $mid; $i <= $end; $i++)
                    $tmp[] = $lista[$i];

                $id += $mid;
                $lista = $tmp;
            } elseif ($lista[$mid] > $el) { // Se o elemento estiver na primeira parte da lista
                $tmp = Array();
                for($i = $ini; $i < $mid; $i++)
                    $tmp[] = $lista[$i];

                $lista = $tmp;
            } else { // Elemento no meio da lista
                $id += $mid;
                $lista = PHP_EOL.'Encontrado: '.$lista[$mid].' | ID: '.$id;
            }

            // Checou todos os itens e não encontrou.
            if ($ini == $end && is_array($lista) ) $lista = 'O Item nao existe!'; 
        }
        return $lista[$mid];
    }

    
    function getLocal() {
        $localizacoes = [];
        $conteudoArquivo = obterConteudoArquivoResultado();
        foreach ($conteudoArquivo as $key => $value) {
            $localizacoes[] = rtrim($value['localizacaoUsuario']);
        }
        $aLocal = array_count_values($localizacoes);

        return  ['local' => array_keys($aLocal, max($aLocal)), 'quantidade' => max($aLocal)];
    }
?>