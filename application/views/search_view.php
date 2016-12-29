<?php
if(isset($data['Product_category'])) $product_category = $data['Product_category']; else $product_category = 0;
$category = <<<EOF
<span style="display:none" id="search_category">{$product_category}</span>
EOF;
echo $category;
?>

<div class="search-wrap">
    <aside id="characteristics-sidebar">
        <form id="characteristics-form" action="#" method="post">
            <?php
            if (isset($data['Product_category']) && $data['Product_category'] != 0 ) {
                $prices = [];
                $cValue = [];
                $producers = [];
                foreach ($data as $key => $item) {
                    if ($key == 'SimilarProducts') {
                        continue;
                    }
                    if ($key == 'Producers') {
                        foreach ($item as $producer) {
                            array_push($producers, $producer);
                        }
                    }
                    if ($key == 'CharacteristicsValue') {
                        foreach ($item as $value) {
                            array_push($cValue, $value);
                        }
                    }
                    if ($key == 'Prices') {
                        foreach ($item as $price) {
                            array_push($prices, $price);
                        }
                    }
                }

                $min_price = $prices[0]['MIN(ProductPrice)'];
                $max_price = $prices[0]['MAX(ProductPrice)'];

                echo '<div class="searchCategoryBlock"><button class="searchSlideBtn"><span><i class="fa fa-chevron-down" aria-hidden="true"></i>Стоимость</span></button>';
                echo '<div class="searchSlideBlock">';
                echo "<div id=\"price-slider\">
            <span id=\"min-price\" data-min=\"$min_price\" style=\"display: none;\"></span>
            <span id=\"max-price\" data-max=\"$max_price\" style=\"display: none;\"></span>
</div>";
                echo "<div id=\"price-search-result\"><span class=\"min-price-select\" data-min-price=\"$min_price\">$min_price грн - </span>
                    <span class=\"max-price-select\" data-max-price=\"$max_price\">$max_price грн</span></div>";

                echo '</div></div>';

                echo '<div class="searchCategoryBlock">
<button class="searchSlideBtn"><span><i class="fa fa-chevron-down" aria-hidden="true"></i>Производитель</span></button>';
                echo "<div class=\"searchSlideBlock\">";
                foreach ($producers as $row) {
                    foreach ($row as $item) {
                        printf("<input type=\"checkbox\" data-schema=\"ProducerName\" data-value=\"%s\"> %s <br>",
                            $item, $item);
                    }
                }
                echo '</div></div>';

                $tmp_key = 'cSchema_Name';
                $tmp_value = $cValue[0][$tmp_key];
                $schema_name = $tmp_value;
                echo '<div class="searchCategoryBlock"><button class="searchSlideBtn"><span><i class="fa fa-chevron-down" aria-hidden="true"></i>' . $tmp_value . "</span></button><div class=\"searchSlideBlock\">";
                $i = 1;
                foreach ($cValue as $item) {
                    foreach ($item as $key => $value) {
                        if ($tmp_value != $item[$key]) {
                            if ($key == 'cSchema_Name') {
                                print('<div class="searchCategoryBlock"><button class="searchSlideBtn"><span>
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>'
                                    . $value . "</span></button>
                                <div class=\"searchSlideBlock\">");
                                $schema_name = $value;
                            } else {
                                printf("<input type=\"checkbox\" data-schema=\"%s\" data-value=\"%s\"> %s <br>",
                                    $schema_name, $value, $value);
                            }
                        }
                        if ($tmp_key == $key) {
                            $tmp_value = $item[$key];
                        }
                    }
                    if ($cValue[$i - 1][$tmp_key] != $cValue[$i][$tmp_key]) {
                        echo '</div></div>';
                    }
                    if ($i + 1 != count($cValue))
                        $i++;
                }
                echo "</div>
            <div class=\"searchBtns\">
                <input type=\"reset\" id=\"resetProdSearchBtn\" value=\"СБРОС\">
                <input type=\"submit\" id=\"submitProdSearchBtn\" value=\"ИСКАТЬ\">
            </div>";
            }
            ?>

        </form>
    </aside>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="finded-product-container">
                    <?php
                    if (isset($data['Found_product'])) {
                        foreach ($data['Found_product'] as $value) {
                            $product_images = explode(';', $value['ProductImages']);
                            echo <<<EOF
    <div class="found-product_sub_pages-block">        
        <div class="found-product_sub_pages-description">
            <h4>{$value['ProductName']}</h4>
            <p> {$value['ProductDescription']} </p>
        </div>
        <div class="found-product_sub_pages-image">
            <img src="{$product_images[0]}">
        </div>
        <div class="found-product_sub_pages-price">
            <p>{$value['ProductPrice']} грн.</p>        
        </div>
        <div class="found-product_sub_pages-more">
            <a href="/Product/{$value['ProductUrl']}">Подробнее</a>
        </div>
    </div>                                
EOF;
                        }
                    } else {
                        printf("<h2>%s</h2>", $data['SearchResult']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="cb"></div>
</div>