<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/31/2019
 * Time: 17:59
 */
namespace lookup\models;

use PDO;
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;
use phpchassis\mvc\db\SqlBuilder;
use lookup\models\entities\Image;

/**
 * Class ImageModel
 * @package lookup\models
 */
class ImageModel extends Model {

    /**
     * ImageModel constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null) {

        parent::__construct($connection);
        $this->entityTable = Image::TABLE_NAME;
    }

    /**
     * Returns the total count for a given search term
     * @param $term     // Search term
     * @return mixed
     */
    public function findCount($term) {

        $sql = SqlBuilder::count($this->entityTable, "total")
            ->where()->like("title", ":term")
            ->or()->like("alt", ":term")
            ->and("broken = 0")
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
     * @param $term         // Search term user entered
     * @return
     */
    public function findAllByCriteria($page, $pageSize, $term): ?array {

        $pageSize = (ConfigLoader::instance()->searchResults('images'))['limit']['page'];

        /*
         * USed to specify the offset of the first row to be returned
         *
         * Example: In the case pageSize = 20:
         *  Page 1 : (1 - 1) * 20 = 0
         *  Page 2 : (2 - 1) * 20 = 20
         *  Page 3 : (3 - 1) * 20 = 40
         */
        $pageOffset = ($page - 1) * $pageSize;

        $sql = SqlBuilder::select($this->entityTable)
            ->where()->like("title", ":term")
            ->or()->like("alt", ":term")
            ->and("broken = 0")
            ->orderBy("clicks", SqlBuilder::ORDER_DESC)
            ->limit(":pageSize")
            ->offset(":pageOffset")
            ->build();

        $statement = $this->connection->prepare($sql);
        $searchTerm = "%" . $term . "%";
        $statement->bindParam(":term", $searchTerm);
        $statement->bindParam(":pageOffset", $pageOffset, PDO::PARAM_INT);
        $statement->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, Image::class);
    }
}