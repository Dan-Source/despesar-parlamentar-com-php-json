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
        $listaDeIdDeputados = array();

         $url = "https://dadosabertos.camara.leg.br/api/v2/deputados";
         
         $ch = curl_init($url);
     
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
        $deputados = json_decode(curl_exec($ch));

        function listarDeputados($deputados)
        {
            global $listaDeIdDeputados;
            foreach($deputados -> dados as $key)
            {
            $idDeputado = $key -> id;
            array_push($listaDeIdDeputados, $idDeputado);
            };
        };
        listarDeputados($deputados);

        print_r($listaDeIdDeputados);

    ?>
    </body>
</html>