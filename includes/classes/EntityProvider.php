<?php

class EntityProvider {

    public static function getEntities($connection, $categoryId, $limit){

        $sql = "SELECT * FROM entities ";

        if($categoryId != null) {
            $sql .= "WHERE categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $connection->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($connection, $row);
        }

        return $result;
    }


    public static function getTVShowsEntities($connection, $categoryId, $limit){

        $sql = "SELECT DISTINCT(entities.id) FROM entities
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 0 "; //SPACE REQUIRED BECAUSE BELOW QUERY IS ALSO CAN BE ADDED

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $connection->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($connection, $row["id"]);
        }

        return $result;
    }


    public static function getMoviesEntities($connection, $categoryId, $limit){

        $sql = "SELECT DISTINCT(entities.id) FROM entities
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 1 "; //SPACE REQUIRED BECAUSE BELOW QUERY IS ALSO CAN BE ADDED

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $connection->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($connection, $row["id"]);
        }

        return $result;
    }

    public static function getSearchEntities($connection, $term){

        $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30"; //SPACE REQUIRED BECAUSE BELOW QUERY IS ALSO CAN BE ADDED

        $query = $connection->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($connection, $row);
        }

        return $result;
    }

}

?>