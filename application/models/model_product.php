<?php
namespace core\models;

use core as c;

/**
 * Class Model_Product
 * @package core\models
 * @category Models category
 * @author Mazur Alexandr
 * <pre>
 * Используется для получения данных для страницы товара.
 * </pre>
 */
class Model_Product extends c\Model
{
    /**
     * @return array с данными для построения страницы товара
     * @throws \Exception, если такого товара (указанного в ссылке на страницу (action)) нету в базе данных
     * @access public
     * <pre>
     * Используется для получения данных для отображения страницы товара.
     * </pre>
     */
    public function get_data()
    {
        $tmp_conn = new \mysqli(c\Model::$host, c\Model::$username, c\Model::$password, c\Model::$dbname);
        if ($tmp_conn->connect_errno) {
            printf("Соединение не удалось: %s\n", $tmp_conn->connect_error);
            exit();
        }
        $data = [];
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        $url = $routes[2];
        $stmt = $tmp_conn->prepare("SELECT ProductName, ProductImages, ProductDescription,
                ProductPrice, ProductAddDate, ID_product, ProductCategory_FK
                FROM Product
                WHERE ProductUrl = ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        $result->free_result();
        if (isset($data[0])) {
            $id_prod = $data[0]['ID_product'];
            $id_category = $data[0]['ProductCategory_FK'];
        } else {
            throw new \Exception('Такого товара не существует');
        }
        $stmt = $tmp_conn->prepare("
                SELECT 
                  cSchema_Name, cValueValue 
                FROM 
                  CharacteristicsValue
                JOIN 
                  CharacteristicsSchema 
                ON 
                  CharacteristicsValue.cValueSchema_FK = CharacteristicsSchema.ID_cSchema 
                WHERE 
                  cValueProduct_FK = ? AND cSchema_Category_FK = ?");
        $stmt->bind_param('ii', $id_prod, $id_category);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        $result->free_result();

        $similar_prod = [];
        $stmt = $tmp_conn->prepare("SELECT ProductName, ProductImages 
                FROM Product 
                WHERE ProductCategory_FK = $id_category AND NOT ID_product = $id_prod");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($similar_prod, $row);
        }
        $result->free_result();
        $data['SimilarProducts'] = $similar_prod;

        $characteristicsValue = [];
        $stmt = $tmp_conn->prepare("SELECT DISTINCT cSchema_Name, cValueValue
        FROM CharacteristicsSchema cs JOIN CharacteristicsValue cv ON cv.cValueSchema_FK = cs.ID_cSchema
        WHERE cs.cSchema_Category_FK = $id_category ORDER BY cSchema_Name, cValueValue");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($characteristicsValue, $row);
        }
        $result->free_result();
        $data['CharacteristicsValue'] = $characteristicsValue;

        $data['Product_category'] = $id_category;

        $data = c\Model::fillKeyValueArray($data, $this->get_product_search_characteristic($id_category));

        $stmt->close();
        $tmp_conn->close();
        return $data;
    }

}