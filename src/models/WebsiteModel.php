<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/31/2019
 * Time: 18:15
 */
namespace lookup\models;

use lookup\models\entities\Website;
use PDO;
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;
use phpchassis\mvc\db\SqlBuilder;

/**
 * Class WebsiteModel
 * @package lookup\models
 */
class WebsiteModel extends Model {

    /**
     * WebsiteModel constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null) {
        
        parent::__construct($connection);
        $this->entityTable = Website::TABLE_NAME;
    }

    /**
     * Returns the total count for a given search term
     * @param $term     // Search term
     * @return int
     */
    public function findCount($term): int {

        $sql = SqlBuilder::count($this->entityTable, "total")
            ->where()->like("title", ":term")
            ->or()->like("url", ":term")
            ->or()->like("keywords", ":term")
            ->or()->like("description", ":term")
            ->build();
            
        $statement = $this->connection->prepare($sql);
        $searchTerm = "%" . $term . "%";
        $statement->bindParam(":term", $searchTerm);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /**
     *
     *
     * @param $page         // Current page num
     * @param $pageSize     // Num of rows to be returned
     * @param $term         // Search criteria user entered
     * @return
     */
    public function findAllByCriteria($page, $pageSize, $term): ?array {

        $pageSize = (ConfigLoader::instance()->searchResults('sites'))['limit']['page'];

        /*
         * USed to specify the offset of the first row to be returned,
         *  Example: In the case pageSize = 20:
         *      Page 1 : (1 - 1) * 20 = 0
         *      Page 2 : (2 - 1) * 20 = 20
         *      Page 3 : (3 - 1) * 20 = 40
         */
        $pageOffset = ($page - 1) * $pageSize;

        try {

            $sql = SqlBuilder::select($this->entityTable)
                ->where()->like("title", ":term")
                ->or()->like("url", ":term")
                ->or()->like("keywords", ":term")
                ->or()->like("description", ":term")
                ->orderBy("clicks", SqlBuilder::ORDER_DESC)
                ->limit(":pageSize")
                ->offset(":pageOffset")
                ->build();

            $statement = $this->connection->prepare($sql);
            $searchTerm = '%' . $term . '%';
            $statement->bindParam(":term", $searchTerm);
            $statement->bindParam(":pageOffset", $pageOffset, PDO::PARAM_INT);
            $statement->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, Website::class);
        }
        catch (\PDOException $e) {
            echo 'Exception Caught: ' . get_class($e) . ':' . $e->getMessage() . PHP_EOL . '<br>';
        }
    }
}