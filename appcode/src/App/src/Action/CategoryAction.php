<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class CategoryAction implements ServerMiddlewareInterface
{
    private $apiConfig = [];
    private $response = [];
    
    public function __construct(array $config)
    {
        $this->apiConfig = $config;
    }
    
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->response['count'] = 0;
        $this->response['totalCount'] = 0;
        
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $this->apiConfig['category'] . 'category/code/' . $request->getAttribute('slug'));
        
        $data = json_decode($res->getBody());
        
        if (count($data->category->childCategories) > 0) {
            $this->response['category']['name'] = $data->category->name;
            foreach ($data->category->childCategories as $category) {
                $this->processCategory($request, $category, 25);
            }
        } else {
            $this->processCategory($request, $data->category, 100);
        }
        
        return new JsonResponse($this->response);
    }
    
    private function processCategory($request, $category, $size)
    {
        $params = $request->getQueryParams();
        
        $search = new \App\Query\Search();
        
        $params['sort'] = ['publishDate:desc'];
        $params['page'] = 1;
        $params['size'] = $size;
        $params['category'] = [$category->code];
        
        $results = $search->fetch($params);
        
        $results['code'] = $category->code;
        
        $results['name'] = '';
        if (isset($category->parentCategory)) {
            $results['name'] .= $category->parentCategory->name . ' - ';
        }
        $results['name'] .= $category->name;
        
        
        $this->response['articles'][$category->code] = $results;
        $this->response['count'] += (int) $results['count'];
        $this->response['totalCount'] += (int) $results['totalCount'];
        
        return $this;
    }
}
