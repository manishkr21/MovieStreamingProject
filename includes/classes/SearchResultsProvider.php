<?php 

class SearchResultsProvider{

    private $connection, $username;

    public function __construct($connection, $username){
        $this->connection = $connection;
        $this->username = $username;

    }

    public function getResults($inputText){
        $entities = EntityProvider::getSearchEntities($this->connection, $inputText);
        $html = "<div class='previewCategories noScroll'>";

        $html .= $this->getResultHtml($entities);

        return $html . "</div>";

    }

    private function getResultHtml($entities){
        if(sizeof($entities)==0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->connection , $this->username);
        foreach($entities as $entity){
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        // return $entitiesHtml . "<br>";
        return "<div class='category'>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}

?>