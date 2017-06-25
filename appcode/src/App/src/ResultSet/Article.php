<?php
namespace App\ResultSet;

use App\Model\Article as ArticleModel;

/**
 * Description of Article
 *
 * @author andylowe
 */
class Article
{
    private $count;
    private $totalCount;
    
    private $source = [];
    
    public function __construct(array $data)
    {
        $this->mapData($data);
    }
    
    private function mapData(array $data) : Article
    {
        $this->totalCount   = $data['hits']['total'];
        $this->count        = count($data['hits']['hits']);
        
        foreach ($data['hits']['hits'] as $result) {
            $this->source[] = new ArticleModel($result);
        }
        
        return $this;
    }    
    
    public function count()
    {
        return $this->count;
    }
    
    public function totalCount()
    {
        return $this->totalCount;
    }
    
    public function toArray() : array
    {
        $result = [];
        
        $result['count'] = $this->count;
        $result['totalCount'] = $this->totalCount;
        
        foreach ($this->source as $row) {
            $result['source'][] = $row->toArray();
        }
        return $result;
    }
}