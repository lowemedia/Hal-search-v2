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
    private $subtitle;
    private $slug;
    private $summary;
    private $content;
    private $author;
    private $publishDate;
    private $image;
    private $categories = [];
    private $displayCategories = [];

    public function __construct(array $data)
    {
        $this->mapData($data);
    }
    
    
    private function mapData(array $data)
    {
        $this->setIndex($data['_index'])
                ->setType($data['_type'])
                ->setScore($data['_score'])
                ->setId((int) $data['_id'])
                ->setTitle((string) $data['_source']['title'])
                ->setSubtitle((string) $data['_source']['subtitle'])
                ->setSlug((string) $data['_source']['slug'])
                ->setSummary((string) $data['_source']['summary'])
                ->setAuthor((string) $data['_source']['author'])
                ->setSource((string) $data['_source']['source'])
                ->setPublishDate($data['_source']['publishDate'])
                ;
        
        if (isset($data['_source']['content'])) {
            $this->setContent((string) $data['_source']['content']);
        }
        
        if (isset($data['_source']['image'])) {
            $this->setImage((string) $data['_source']['image']);
        }
        if (isset($data['_source']['categories'])) {
            $this->setCategories($data['_source']['categories']);
            if (isset($data['_source']['displayCategories'])) {
                $this->setDisplayCategories($data['_source']['displayCategories']);
            }
        }
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
    
    public function setSubtitle($subtitle) : Article
    {
        $this->subtitle = (string) $subtitle;
        return $this;
    }
    
    public function getSubtitle() : string
    {
        return $this->subtitle;
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
        return $this->content?$this->content:'';
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
        return (string) $this->image;
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
    
    public function setDisplayCategories(array $displayCategories) : Article
    {
        $this->displayCategories = $displayCategories;
        return $this;
    }
    
    public function getDisplayCategories() : array
    {
        return $this->displayCategories;
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