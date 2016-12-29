<?php
printf("<h3>Технические характеристики <span class=\"product-name-characteristics\">%s</span></h3>", $data[0]['ProductName']);
printf("<table class=\"table table-striped\"><thead><tr><th>Характеристики</th><th>Значения</th></tr></thead><tbody>");
foreach ($data as $key => $item) {
    if ($key == "SimilarProducts") {
        continue;
    }
    if ($key == 'CharacteristicsValue') {
        continue;
    }
    if ($key == 'Producers') {
        continue;
    }
    if ($key == 'Prices'){
        continue;
    }
    if ($key == 'Product_category'){
        continue;
    }
    foreach ($item as $key => $value) {
        if ($key == 'cSchema_Name') {
            echo '<tr>';
            printf("<td>%s</td>", $value);
        }
        if ($key == 'cValueValue') {
            printf("<td>%s</td>", $value);
            echo '</tr>';
        }
    }
}
//var_dump($data);
echo "</tbody>";
echo "</table>";
?>