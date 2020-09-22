<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despesas do Parlamento</title>
</head>
<body>
    <h1> Deputados </h1>

    <?php
    $id = 204554;
    $ano= 2020;
    $total = 0;
    $url = "https://dadosabertos.camara.leg.br/api/v2/deputados/$id/despesas/?ano=$ano";

    function somarDadosPorUrl($url)
     {
        global $total;
        echo $url."<br>";
        $x = curl_init($url);

        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);

        $despesas_liquidas_do_deputado = json_decode(curl_exec($x));
        foreach($despesas_liquidas_do_deputado -> dados as $key){
            $valorLiquido = $key -> valorLiquido;
            $total = $total + $valorLiquido;
        };
        echo $total."<br>";;

        if(pegarProximoUrl($despesas_liquidas_do_deputado) !== false){
            somarDadosPorUrl(pegarProximoUrl($despesas_liquidas_do_deputado));
        }
     };

     function pegarProximoUrl($despesas_liquidas_do_deputado){
        foreach($despesas_liquidas_do_deputado -> links as $key){
            if($key -> rel == "next"){
               $url = $key -> href;
               return $url;
            };
        };
        return false;
     }

    somarDadosPorUrl("https://dadosabertos.camara.leg.br/api/v2/deputados/$id/despesas/?ano=$ano");

    


    ?>
</body>
</html>