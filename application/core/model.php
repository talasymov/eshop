<?php
namespace core;

/**
 * Абстрактный класс Model
 * @author Mazur Alexandr
 * @category Models class
 * @package core
 * <pre>
 * Описывает обобщенную модель для приложения.
 * </pre>
 */
abstract class Model
{
    #region Public & Static members

    /**
     * @var string Строка подключения (хост) к серверу MySQL
     * @static
     */
    public static $host = '127.0.0.1';
    /**
     * @var string Имя базы данных MySQL
     * @static
     */
    public static $dbname = "talas-shop";
    /**
     * @var string Логин к базе данных MySQL
     * @static
     */
    public static $username = 'Admin';
    /**
     * @var string Пароль к базе данных MySQL
     * @static
     */
    public static $password = 'admin';

    /**
     * @param $arr1
     * @param $arr2
     * @return mixed
     * @static
     */
    public static function fillKeyValueArray($arr1, $arr2)
    {
        foreach ($arr2 as $key => $value) {
            $arr1[$key] = $value;
        }
        return $arr1;
    }
    #endregion

    #region Abstract members
    /**
     * @return array в котором хранятся данные для представления (View)
     * @access protected
     * @todo Выборка нужных данных для страницы представления (View) и возвращения ее в виде массива (массив mixed (ассоциативный и/или индексный))
     */
    public abstract function get_data();

    #endregion

    #region Protected members

    //будет объявлен как private и вызываться в 'get_product_template_data()' методе, для построения шаблона страницы продукта
    /**
     * @param $id_category ID категории, для которой состоится выборка данных (характеристика товаров)
     * @return array с данными для сайдбара
     * <pre>
     * Вывод форматированных данных в виде массива для сайдбара,
     * по которым будет осуществлятся поиск необходимых пользователю товаров
     * </pre>
     * @access protected
     */
    protected function get_product_search_characteristic($id_category)
    {
        $tmp_conn = new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
        $data = [];
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

        $producers = [];
        $stmt = $tmp_conn->prepare("SELECT ProducerName 
                FROM Producer 
                JOIN Product ON Producer.ID_producer = Product.ProductProducer_FK 
                JOIN SubCategory ON SubCategory.ID_subCategory = Product.ProductCategory_FK 
                WHERE Product.ProductCategory_FK = ? ORDER BY ProducerName");
        $stmt->bind_param('i', $id_category);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($producers, $row);
        }
        $result->free_result();

        $data['Producers'] = $producers;

        $prices = [];
        $stmt = $tmp_conn->prepare("SELECT MIN(ProductPrice), MAX(ProductPrice)
        FROM Product p JOIN SubCategory sc ON p.ProductCategory_FK = sc.ID_subCategory
        WHERE p.ProductCategory_FK = ?");
        $stmt->bind_param('i', $id_category);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($prices, $row);
        }
        $result->free_result();
        $data['Prices'] = $prices;

        $stmt->close();
        $tmp_conn->close();
        return $data;
    }


    /**
     * @return array с данными для шаблона продуктов
     * @access protected
     * @uses $this->get_footer_data();
     * @uses $this->get_header_data();
     * <pre>
     * Получение данных для шаблона (футер, сайдбар, хидер) страницы товара.
     * </pre>
     */
    protected function get_product_template_data()
    {

    }

    /**
     * @return array с данными для шаблона страниц приложения
     * @access protected
     * @uses $this->get_footer_data();
     * @uses $this->get_header_data();
     * <pre>
     * Получение данных для шаблона (футер, сайдбар, хидер) остальных страниц сайта (главная... и т.д.)
     * </pre>
     */
    protected function get_main_template_data()
    {
        $data = [];
        $data['Footer'] = $this->get_footer_data();
        $data['Header'] = $this->get_header_data();
        $data['Sidebar'] = $this->get_sidebar_main_data();
        return $data;
    }

    /**
     * @return array с данными для шаблона продуктов
     * @access protected
     * <pre>
     * получение данных для шаблона админ-панели приложения
     * </pre>
     * @uses $this->get_admin_footer_data() для получения данных для отображения footer'а
     * @uses $this->get_admin_header_data() для получения данных для отображения header'а
     */
    protected function get_admin_template_data()
    {

    }
    #endregion

    #region Private members

    /**
     * @return array|null с данными о футере или null, если записи о футере отсутсвуют в БД
     * @throws \Exception, если данных о футере нету или не удалось подключиться к серверу MySQL
     * @access private
     * <pre>
     * Получение данных для футера.
     * </pre>
     */
    private function get_footer_data()
    {
        try {
            if ($tmp_conn =
                new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname)
            ) {
                $data = [];
                if ($stmt = $tmp_conn->prepare("
                  SELECT 
                  Footer.Name as LinkName,
                  Footer.Link as Link
                  FROM Footer
                  ORDER BY FooterID")
                ) {
                    $stmt->execute();
                    $footer = [];
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        array_push($footer, $row);
                    }
                    $data['Footer'] = $footer;
                    unset($footer);
                    $result->free_result();
                    $stmt->close();
                    return $data;
                } else {
                    throw new \Exception("В базе отсутсвуют данные для футера!");
                }
            }
        } finally {
            $tmp_conn->close();
        }
    }


    /**
     * @access private
     * @return array|null с данными header'a или null, если их нету.
     * @throws \Exception если данных header'а нету или не удалось подключиться к серверу MySQL.
     * <pre>
     * Получение данных для header'a
     * </pre>
     */
    private function get_header_data()
    {
        try {
            if ($tmp_conn =
                new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname)
            ) {
                $data = [];
                if ($stmt = $tmp_conn->prepare(
                    "SELECT 
                     Header.Name as LinkName,
                     Header.Link as Link
                     FROM Header
                     ORDER BY HeaderID")
                ) {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $header = [];
                    while ($row = $result->fetch_assoc()) {
                        array_push($header, $row);
                    }
                    $data['Header'] = $header;
                    unset($header);
                    $result->free_result();
                    $stmt->close();
                    return $data;
                } else {
                    throw new \Exception("В базе данных нету записей о Header'е!");
                }
            } else {
                throw new \Exception("Не удалось подключиться к серверу БД!");
            }
        } finally {
            $tmp_conn->close();
        }
    }

    private function get_admin_header_data()
    {
        $tmp_conn = new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    }

    private function get_admin_footer_data()
    {
        $tmp_conn = new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    }

    /**
     * @return array|null с данными для сайдбара (категории и подкатегории)
     * @throws \Exception если отсутсвуют какие-либо категории в базе данных или не удалось подключиться к серверу MySQL
     * @access private
     * <pre>
     * Получение данных для сайдбара главных и им подобных страниц (страница не товара или поиска)
     * </pre>
     */
    private function get_sidebar_main_data()
    {
        try {
            if ($tmp_conn =
                new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname)
            ) {
                $data = [];
                //Выбираем главные категории
                if ($stmt = $tmp_conn->prepare("
                    SELECT DISTINCT 
                    RootCategory.CategoryName as RootCategory, 
                    RootCategory.ID_rootCategory as RootCategoryID
                    FROM RootCategory 
                    ORDER BY RootCategory.CategoryName")
                ) {
                    $stmt->execute();
                    $root_category = [];
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        array_push($root_category, $row);
                    }
                    $data['MainCategory'] = $root_category;
                    unset($root_category);
                    $result->free_result();
                    $stmt->close();
                } else {
                    throw new \Exception("Главные категории отсутствуют");
                }
                //Выбираем подкатегории
                if ($stmt = $tmp_conn->prepare("
                    SELECT DISTINCT 
                    SubCategory.CategoryName, 
                    SubCategory.MainCategory_FK as MainCategoryID
                    FROM SubCategory 
                    ORDER BY SubCategory.CategoryName")
                ) {
                    $stmt->execute();
                    $sub_category = [];
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        array_push($sub_category, $row);
                    }
                    $data['SubCategory'] = $sub_category;
                    unset($sub_category);
                    $result->free_result();
                    $stmt->close();
                } else {
                    throw new \Exception("Подкатегории отсутсвуют");
                }
                return $data;
            } else {
                throw new \Exception("Ошибка подключения к серверу MySQL");
            }
        } finally {
            $tmp_conn->close();
        }
    }

    private function get_sidebar_product_data()
    {
        $tmp_conn = new \mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    }
    #endregion
}

?>
