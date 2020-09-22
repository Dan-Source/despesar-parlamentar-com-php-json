<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despesas do Parlamento</title>
</head>
    <body>
   <h2>Despesas pela Cota para Exercício da Atividade Parlamentar</h2>
   <p>
   Dados sobre as despesas cobertas pela Cota para Exercício da Atividade Parlamentar de cada deputado desde 2008.
   </p>

   <table>
   <tr>
   <th>Ano</th>
   <th>Despesas<th>
   </tr>
   <td>hello world</td>
   
   </table>

    <?php
        //Variaveis
        $total = 0;
        $total_anual_deputados = 0;

        
        // Link para Carregar Json com dados de todos os deputados do ano 2020
         $url = "https://dadosabertos.camara.leg.br/api/v2/deputados";
         $ch = curl_init($url);
     
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
        $deputados = json_decode(curl_exec($ch));

        //retorna uma lista de ids dos deputados a partir de Json

        function pegarIds($deputados)
        {
            $listaDeIdDeputados = array();
            foreach($deputados -> dados as $key)
            {
            $idDeputado = $key -> id;
            array_push($listaDeIdDeputados, $idDeputado);
            };
            return $listaDeIdDeputados;
        };

        // pegando a url das desspesas dos deputados
        function preencherUrlComIdEAno($id, $ano){
            $url = "https://dadosabertos.camara.leg.br/api/v2/deputados/$id/despesas/?ano=$ano";
            return $url;
        };

        // somar a despesas de um deputado por ano
        function somarDadosPorUrl($url, $total)
        {
            //echo $url."<br>";
            $x = curl_init($url);

            curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);

            $despesas_liquidas_do_deputado = json_decode(curl_exec($x));

            foreach($despesas_liquidas_do_deputado -> dados as $key){
                $valorLiquido = $key -> valorLiquido;
                $total = $total + $valorLiquido;
            };
            echo $total;

            if(pegarProximoUrl($despesas_liquidas_do_deputado) !== false){
                somarDadosPorUrl(pegarProximoUrl($despesas_liquidas_do_deputado, $total));
            };
            echo $total;
        };


        // pegar proximo url ate que não retorne nada
        function pegarProximoUrl($despesas_liquidas_do_deputado){
            foreach($despesas_liquidas_do_deputado -> links as $key){
                if($key -> rel == "next"){
                   $url = $key -> href;
                   return $url;
                };
            };
            return false;
         }

        // despesas de todos os deputados do ano de 2020

        function somarTotalDespesas($listaDeIdDeputados, $ano){
            global $total_anual_deputados;
            foreach($listaDeIdDeputados as $key){
                // $url = preencherUrlComIdEAno($key, $ano);
                // $valorPorDeputado = somarDadosPorUrl($url);
                // echo $valorPorDeputado;
                // $total_anual_deputados += $valorPorDeputado;
            };
            
        };

        //somarTotalDespesas(pegarIds($deputados), 2020);
        $id = 204554;
        $ano= 2020;
        
        echo somarDadosPorUrl(preencherUrlComIdEAno($id, $ano), 0);

        // echo $total;

        // echo $total_anual_deputados;

        //print_r(pegarIds($deputados));

    ?>
    </body>
</html>