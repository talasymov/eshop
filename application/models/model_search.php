<?php
namespace core\models;

use core as c;

/**
 * Class Model_Search
 * @package core\models
 * @category Models class
 * @author Mazur Alexandr
 * <pre>
 * Описывает модель с данными для отображения страницы поиска и найденных товаров.
 * </pre>
 */
class Model_Search extends c\Model
{
    /**
     * @return array|null с результатами поиска
     * @access private
     * <pre>
     * Возвращает результаты поиска или null,
     * если ничего не найдено или страница обновилась или запустилась второй раз
     * или была запущена прямой ссылкой.
     * Получает данные для поиска используя механизм сессий.
     * Проверяется массив на пустоту в представлении (View)
     * </pre>
     */
    private function get_search_from_filter_result()
    {
        $data = [];
        if (!isset($_SESSION['SearchCondition'])) {
            $data['Product_category'] = 0;
            $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
            return $data;
        }

        if (!isset($_SESSION['SearchCondition']['SearchType']) OR $_SESSION['SearchCondition']['SearchType'] != 'filter') {
            $data['Product_category'] = 0;
            $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
            return $data;
        }

        $condition = $_SESSION['SearchCondition'];
        $data['Product_category'] = $condition['Product_category'];

//        unset($_SESSION['SearchCondition']);

        $search_query = "
        SELECT DISTINCT 
          ID_product
        FROM 
          Product 
          JOIN CharacteristicsSchema ON CharacteristicsSchema.cSchema_Category_FK = Product.ProductCategory_FK 
          JOIN CharacteristicsValue ON CharacteristicsValue.cValueSchema_FK = CharacteristicsSchema.ID_cSchema 
          AND CharacteristicsValue.cValueProduct_FK = Product.ID_product 
          JOIN Producer ON Product.ProductProducer_FK = Producer.ID_producer 
        WHERE 
          Product.ProductCategory_FK = {$condition['SearchCategory']}
          AND ";

        foreach ($condition as $condition_key => $condition_item) {
            if ($condition_key == 'minimum_price') {
                $search_query .= "ProductPrice BETWEEN $condition_item AND ";
            }
            if ($condition_key == 'maximum_price') {
                $search_query .= "$condition_item";
            }
            if ($condition_key == 'ProducerName') {
                $search_query .= " AND ( ";
                $i = 0;
                foreach ($condition_item as $producer) {
                    if ($i == 0) {
                        $search_query .= "ProducerName LIKE '$producer'";
                        $i++;
                    } else {
                        $search_query .= " OR ProducerName LIKE '$producer'";
                    }
                }
                $search_query .= ")";
            }
            if ($condition_key == 'cValueValue') {
                $search_query .= " AND (";
                $i = 0;
                foreach ($condition_item as $value) {
                    if ($i == 0) {
                        if (stripos($value, "'")) {
                            $value .= "'";
                        }
                        $search_query .= " cValueValue LIKE '$value'";
                        $i++;
                    } else {
                        if (stripos($value, "'")) {
                            $value .= "'";
                        }
                        $search_query .= " OR cValueValue LIKE '$value'";
                    }
                }
                $search_query .= ")";
            }
        }
        $search_query .= " ORDER BY ID_product";

        $tmp_conn = new \mysqli(c\Model::$host, c\Model::$username, c\Model::$password, c\Model::$dbname);
        if ($stmt = $tmp_conn->prepare($search_query)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $found_id = [];
            while ($row = $result->fetch_assoc()) {
                array_push($found_id, $row);
            }
            $result->free_result();
            $stmt->close();
        } else {
            return $data['SearchResult'] = "Мы не смогли ничего найти по Вашему запросу!";
        }
        $found_product_query = "
              SELECT DISTINCT 
                ProductName, ProductDescription, ProductPrice, ProductImages, ProductUrl 
              FROM 
                Product 
              WHERE ";
        $i = 0;
        foreach ($found_id as $id) {
            if ($i == 0) {
                $found_product_query .= "ID_product = {$id['ID_product']}";
                $i++;
            } else {
                $found_product_query .= " OR ID_product = {$id['ID_product']} ";
            }
        }

        $stmt = $tmp_conn->prepare($found_product_query);
        $stmt->execute();
        $result = $stmt->get_result();
        $found_product = [];
        while ($row = $result->fetch_assoc()) {
            array_push($found_product, $row);
        }
        $result->free_result();
        $data['Found_product'] = $found_product;
        $data = c\Model::fillKeyValueArray($data, $this->get_product_search_characteristic($data['Product_category']));
//        echo "<pre>";
//        var_dump($data);
//        echo "</pre>";
        $stmt->close();
        $tmp_conn->close();
        return $data;
    }


    private function get_fulltext_search()
    {
        if (!isset($_SESSION['SearchCondition']['search']) OR (strlen(trim($_SESSION['SearchCondition']['search'])) == 0)) {
            $data['Product_category'] = 0;
            $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
            return $data;
        }

        if (!isset($_SESSION['SearchCondition']['SearchType']) OR $_SESSION['SearchCondition']['SearchType'] != 'fulltext') {
            $data['Product_category'] = 0;
            $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
            return $data;
        }


        try {
            if ($search_conn =
                new \mysqli(c\Model::$host, c\Model::$username, c\Model::$password, c\Model::$dbname)
            ) {
                //Не используем htmlspecialchars для преобразования строки,
                //поскольку идет запрос только на SELECT, там они нам не страшны ;)
                $search_param = $search_conn->real_escape_string($_SESSION['SearchCondition']['search']);
//                unset($_SESSION['SearchCondition']);
//                $search_param = str_replace(" ", "|", $search_param);
                $ttt = "SELECT DISTINCT
                     ID_product
                     FROM Product 
                     JOIN Producer ON Product.ProductProducer_FK = Producer.ID_producer
                     JOIN CharacteristicsValue ON Product.ID_product = CharacteristicsValue.cValueProduct_FK
                     JOIN CharacteristicsSchema ON CharacteristicsSchema.cSchema_Category_FK = Product.ProductCategory_FK
                     JOIN SubCategory ON Product.ProductCategory_FK = SubCategory.ID_subCategory
                     JOIN RootCategory ON RootCategory.ID_rootCategory = SubCategory.MainCategory_FK
                     WHERE
                     Product.ProductName LIKE '%$search_param%'
                     OR Product.ProductDescription LIKE '%$search_param%'
                     OR Producer.ProducerName LIKE '%$search_param%'
                     OR RootCategory.CategoryName LIKE '%$search_param%'
                     OR SubCategory.CategoryName LIKE '%$search_param%'
                     OR CharacteristicsSchema.cSchema_Name LIKE '%$search_param%'
                     OR CharacteristicsValue.cValueValue LIKE '%$search_param%'
                     ORDER BY ID_product
                     ";
                echo $ttt;
                if ($stmt = $search_conn->prepare(
                    "SELECT DISTINCT
                     ID_product
                     FROM Product 
                     JOIN Producer ON Product.ProductProducer_FK = Producer.ID_producer
                     JOIN CharacteristicsValue ON Product.ID_product = CharacteristicsValue.cValueProduct_FK
                     JOIN CharacteristicsSchema ON CharacteristicsSchema.cSchema_Category_FK = Product.ProductCategory_FK
                     JOIN SubCategory ON Product.ProductCategory_FK = SubCategory.ID_subCategory
                     JOIN RootCategory ON RootCategory.ID_rootCategory = SubCategory.MainCategory_FK
                     WHERE
                     Product.ProductName LIKE '%$search_param%'
                     OR Product.ProductDescription LIKE '%$search_param%'
                     OR Producer.ProducerName LIKE '%$search_param%'
                     OR RootCategory.CategoryName LIKE '%$search_param%'
                     OR SubCategory.CategoryName LIKE '%$search_param%'
                     OR CharacteristicsSchema.cSchema_Name LIKE '%$search_param%'
                     OR CharacteristicsValue.cValueValue LIKE '%$search_param%'
                     ORDER BY ID_product
                     "
                )
                ) {
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $found_id = [];
                        while ($row = $result->fetch_assoc()) {
                            array_push($found_id, $row);
                        }
                        $result->free_result();
                        $stmt->close();
                    } else {
                        $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
                        return $data;
                    }
                } else {
                    $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
                    return $data;
                }

                $found_product_query = "
                SELECT DISTINCT 
                ProductName, ProductDescription, ProductPrice, ProductImages, ProductUrl 
                FROM 
                Product 
                WHERE ";
                $i = 0;
                foreach ($found_id as $id) {
                    if ($i == 0) {
                        $found_product_query .= "ID_product = {$id['ID_product']}";
                        $i++;
                    } else {
                        $found_product_query .= " OR ID_product = {$id['ID_product']} ";
                    }
                }
                if (
                $stmt = $search_conn->prepare($found_product_query)
                ) {
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $found_product = [];
                        while ($row = $result->fetch_assoc()) {
                            array_push($found_product, $row);
                        }
                        $result->free_result();
                        $data['Found_product'] = $found_product;
                        return $data;
                        $stmt->close();
                    } else {
                        $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
                        return $data;
                    }
                } else {
                    $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
                    return $data;
                }
            } else {
                return $data['SearchResult'] = "Не удалось установить соединение с сервером MySQL!";
            }
        } finally {
            $search_conn->close();
        }
    }

    /**
     * @return array|null с результатами поиска
     * @uses get_search_from_filter_result() для получения данных через фильтры or
     * @uses get_fulltext_search() для получения данных со строки поиска
     * @access public
     * @see  c\Model_Search->get_search_result()
     * <pre>
     * Возвращает данные для отображения результатов поиска.
     * @see  c\Model_Search->get_search_from_filter_result()
     * </pre>
     */
    public function get_data()
    {
        session_start();
        if (!isset($_SESSION['SearchCondition']['SearchType'])) {
            $data['Product_category'] = 0;
            $data['SearchResult'] = "К сожалению, мы не смогли найти ничего по Вашему запросу!";
            return $data;
        }
        switch ($_SESSION['SearchCondition']['SearchType']) {
            case 'fulltext':
                return $this->get_fulltext_search();
                break;
            case 'filter':
                return $this->get_search_from_filter_result();
                break;
            default:
                return null;
        }
    }
}