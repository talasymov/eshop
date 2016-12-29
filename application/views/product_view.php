<?php
$is_logined = $_SESSION['isUserCorrect'] ? "true" : "false";
$category = <<<EOF
<span style="display:none" id="search_category">{$data['Product_category']}</span>
<span style="display:none" id="is_logined">{$is_logined}</span>
EOF;

echo $category;
?>

<div class="product-wrap">
    <aside id="characteristics-sidebar">
        <form id="characteristics-form" action="#" method="post">
            <?php

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
            echo "</div>";
            ?>
            <div class="searchBtns">
                <input type="reset" id="resetProdSearchBtn" value="СБРОС">
                <input type="submit" id="submitProdSearchBtn" value="ИСКАТЬ">
            </div>
        </form>
    </aside>
    <div class="container-fluid">
        <div class="row main-product-preview">
            <div class="col-md-12">
                <div class="row product-header">
                    <h4>
                        <?php
                        //product_sub_pages name here
                        echo $data[0]['ProductName'];
                        ?>
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="preview-img-block">
                            <div class="main-img">
                                <?php
                                //first img main
                                $images = explode(';', $data[0]['ProductImages']);
                                if (isset($images[0]) && $images[0] != '') {
                                    printf("<img src=\"/%s\">", $images[0]);
                                } else {
                                    $default_img = '/img/default_product_img.jpg';
                                    printf("<img src=\"%s\">", $default_img);
                                }
                                ?>
                            </div>
                            <div class="under-main-img">
                                <div class="stars"><img src="/img/stars.jpg" alt=""></div>
                                <div class="feedback"><p>Пользователи оставили:
                                        <?php
                                        echo "2 отзыва";
                                        ?>
                                    </p></div>
                            </div>
                            <div class="carousel-img">
                                <?php
                                //carousel images
                                if (count($images) < 5) {
                                    for ($i = 0;
                                         $i < 4;
                                         $i++) {
                                        printf("
                                            <div class=\"item\">
                                            <img src=\"%s\">
                                            </div>"
                                            , $default_img);
                                    }
                                } else {
                                    $i = 0;
                                    foreach ($images as $image) {
                                        if ($i == 0) {
                                            $i++;
                                            continue;
                                        }
                                        printf("
                                            <div class=\"item\">
                                            <img src=\"/%s\">
                                            </div>"
                                            , $image);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chose-color">
                            <p>Выбор варианта:</p>
                            <select id="color-select" class="form-control">
                                <?php
                                //select color item
                                ?>
                            </select>
                        </div>
                        <div class="price_and_buy">
                            <div class="price">
                            <span class="last-price">
                                <?php
                                //last price here
                                ?>
                            </span>
                            <span class="current-price">
                                <?php
                                //current price here
                                echo "<span><strong>";
                                echo $data[0]['ProductPrice'];
                                echo "</strong> грн.</span>";
                                ?>
                            </span>
                            </div>
                            <div class="buy">
                                <button id="buyBtn">Купить</button>
                            </div>
                            <div class="cb"></div>
                        </div>
                        <div class="compare_and_favorite">
                            <div class="compare"><a href="#">
                                    <i class="fa fa-exchange" aria-hidden="true"></i> Добавить к сравнению
                                </a></div>
                            <div class="favorite"><a href="#" id="toggleFavorite">
                                    <i class="fa fa-star" aria-hidden="true"></i> В избранное
                                </a></div>
                        </div>
                        <div class="text-characteristics">
                            <?php
                            //print technicals characteristic here pls
                            $characteristics = "";
                            //                                                        echo "<pre>";
                            //                                                        print_r($data);
                            //                                                        echo "</pre>";
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
                                if ($key == 'Prices') {
                                    continue;
                                }
                                if ($key == 'Product_category') {
                                    continue;
                                }
                                foreach ($item as $key => $value) {
                                    if ($key == 'cSchema_Name') {
                                        $characteristics .= "<strong>$value: </strong>";
                                    }
                                    if ($key == 'cValueValue') {
                                        $characteristics .= $value . " / ";
                                    }
                                }
                            }

                            $characteristics = substr($characteristics, 0, strlen($characteristics) - 2);
                            echo $characteristics;
                            ?>
                        </div>
                        <div class="like-product">
                            <h4>Понравился товар?</h4>
                            <div class="like-btns">

                            </div>
                        </div>
                        <div class="repost">
                            <h4>Расскажи друзьям</h4>
                            <div class="repost-btns">
                                <div class="share42init"></div>
                                <script type="text/javascript" src="/libs/share42/share42.js"></script>
                            </div>
                        </div>
                        <div class="row product-nav-line">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs product-nav nav-justified">
                                    <li class="active">
                                        <a data-toggle="tab" href="#product-description">
                                            Описание</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#product-characteristics">
                                            Характеристики</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#product-callback">
                                            Отзывы</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row product-description">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="product-description" class="tab-pane fade in active">
                                        <?php include_once 'application/views/product_sub_pages/description.php'; ?>
                                    </div>
                                    <div id="product-characteristics" class="tab-pane fade">
                                        <?php include_once 'application/views/product_sub_pages/characteristics.php'; ?>
                                    </div>
                                    <div id="product-callback" class="tab-pane fade">
                                        <?php include_once 'application/views/product_sub_pages/callback.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row similar-product-header">
                            <div class="col-md-12 text-center">
                                <h3>Похожие товары</h3>
                            </div>
                        </div>
                        <div class="row similar-product-carousel-line">
                            <div class="col-md-12">
                                <div class="similar-product-carousel">
                                    <?php
                                    //similar products carousel blockS with navigation next prev
                                    $similar_products = $data['SimilarProducts'];
                                    //                    var_dump($similar_products);
                                    foreach ($similar_products as $product) {
                                        print('<div class="item">');
                                        foreach ($product as $key => $item) {
                                            if ($key == 'ProductName') {
                                                print('<div class="similar-prod-header text-center"');
                                                print("<h4>$item</h4>");
                                                print('</div>');
                                            }
                                            if ($key == 'ProductImages') {
                                                print('<div class="similar-prod-img">');
                                                print("<img src=\"$item\">");
                                                print('</div>');
                                            }

                                        }
                                        print('<div class="similar-prod-btn text-center">
                                   <button class="similar-prod-more-btn">Подробнее</button>
                                   </div>');
                                        print("</div>");
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cb"></div>
</div>