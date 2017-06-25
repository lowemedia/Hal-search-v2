<?php
namespace App\Model;

/**
 * Description of Result
 *
 * @author andylowe
 */
class Article
{
    private $id;
    private $title;
    private $slug;
    private $summary;
    private $content;
    private $author;
    private $publishDate;
    private $image;
    private $categories = [];

    public function __construct(array $data)
    {
        $this->mapData($data);
    }
    
    
    private function mapData(array $data)
    {
        $this->setIndex($data['_index'])
                ->setType($data['_type'])
                ->setScore($data['_score'])
                ->setId($data['_id'])
                ->setTitle($data['_source']['title'])
                ->setSlug($data['_source']['slug'])
                ->setSummary($data['_source']['summary'])
                ->setContent($data['_source']['content'])
                ->setAuthor($data['_source']['author'])
                ->setImage($data['_source']['image'])
                ->setSource($data['_source']['source'])
                ->setPublishDate($data['_source']['publishDate'])
                ->setCategories($data['_source']['categories'])
                ;
        
        return $this;
    }
    
    public function setId(int $id) : Article
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId() : int
    {
        return $this->id;
    }
    
    public function setTitle(string $title) : Article
    {
        $this->title = (string) $title;
        return $this;
    }
    
    public function getTitle() : string
    {
        return $this->title;
    }
    
    public function setSlug(string $slug) : Article
    {
        $this->slug = (string) $slug;
        return $this;
    }
    
    public function getSlug() : string
    {
        return $this->slug;
    }
    
    public function setSummary(string $summary) : Article
    {
        $this->summary = (string) $summary;
        return $this;
    }
    
    public function getSummary() : string
    {
        return $this->summary;
    }
    
    public function setContent(string $content) : Article
    {
        $this->content = (string) $content;
        return $this;
    }
    
    public function getContent() : string
    {
        return $this->content;
    }
    
    public function setAuthor(string $author) : Article
    {
        $this->author = (string) $author;
        return $this;
    }
    
    public function getAuthor() : string
    {
        return $this->author;
    }
    
    public function setImage($image) : Article
    {
        $this->image = (string) $image;
        return $this;
    }
    
    public function getImage() : string
    {
        return $this->image;
    }
    
    public function setSource(string $source) : Article
    {
        $this->source = (string) $source;
        return $this;
    }
    
    public function getSource() : string
    {
        return $this->source;
    }
    
    public function setPublishDate(string $publishDate) : Article
    {
        $this->publishDate = new \DateTime((string) $publishDate);
        return $this;
    }
    
    public function getPublishDate($format = 'c') : string
    {
        if (! $this->publishDate instanceof \DateTime) {
            throw new \InvalidArgumentException('Publish date time has not be set correctly');
        }
        return $this->publishDate->format((string) $format);
    }
    
    public function setCategories(array $categories) : Article
    {
        $this->categories = $categories;
        return $this;
    }
    
    public function getCategories() : array
    {
        return $this->categories;
    }
    
    public function setIndex(string $index) : Article
    {
        $this->index = $index;
        return $this;
    }
    
    public function getIndex() : string
    {
        return $this->index;
    }
    
    public function setType(string $type) : Article
    {
        $this->type = $type;
        return $this;
    }
    
    public function getType() : string
    {
        return $this->type;
    }
    
    public function setScore(int $score) : Article
    {
        $this->score = $score;
        return $this;
    }
    
    public function getScore() : int
    {
        return (int) $this->score;
    }
    
    public function toArray() : array
    {
        $result = [];
        foreach ($this as $key => $property) {
            $method = 'get' . ucwords($this->removeUnderScore($key));
            $result[$key] = $this->$method();
        }
        return $result;
    }
    
    protected function removeUnderScore($column) {
        // preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $text)
        $colArray = explode("_",$column);

        $property = NULL;
        $numWords = count($colArray);
        for($n=0;$n<$numWords;$n++) {
            if ($n > 0) {
                $property .= ucwords($colArray[$n]);
            } else {
                $property .= $colArray[$n];
            }
        }
        return $property;
    }

}