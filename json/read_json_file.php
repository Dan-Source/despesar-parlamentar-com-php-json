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
        $data = file_get_contents("ano2020.json");
        
        var_dump($data);

        $deputados = json_decode($data);

        var_dump($deputados);

        function listarDeputados($deputados){
            foreach($deputados -> dados as $key){
            echo $key -> valorLiquido;
            }
        };

        listarDeputados($deputados)


        
    ?>
</body>
</html>