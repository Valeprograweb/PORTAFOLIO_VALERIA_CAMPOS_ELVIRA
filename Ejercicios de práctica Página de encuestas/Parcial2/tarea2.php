<html>
<head>
    <title>Arreglo Aleatorio</title>
</head>
<style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid blue; padding: 8px; text-align: center; }
        h2 { text-align: center; }
</style>
<body>
    <h2>ARREGLO GENERADO</h2>
    <table>
        <tr>
            <?php
            $arreglo = array();
            for ($i = 0; $i < 21; $i++) {
                $arreglo[$i] = rand(1, 100);
                echo "<th>Elemento $i</th>";
            }
            ?>
        </tr>
        <tr>
            <?php
            for ($i = 0; $i < 21; $i++) {
                echo "<td>{$arreglo[$i]}</td>";
            }
            ?>
        </tr>
    </table>
</body>
</html>
