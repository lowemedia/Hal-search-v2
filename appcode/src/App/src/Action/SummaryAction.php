<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class SummaryAction implements ServerMiddlewareInterface
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P3M'));
        
        
        $params = [
            'index' => 'articles',
            'type'  => 'article',
            'size'  => 22,
            'date-fr' => $date->format('c'),
            'sort' => 'publishDate:desc',
            'exists' => ['featured', 'image']
        ];
        
        $search = new \App\Query\Search();
        $featured = $search->buildClient()->fetch($params);
        
        $slugs = [];
        
        foreach ($featured['source'] as $article) {
            $slugs[] = $article['slug'];
        }
        
        $params['size'] = 250;
        unset($params['exists']); // = ['featured'];
        
        $params['excludes'] = ['slug' => $slugs];
        
        $latest = $search->fetch($params);
        
        return new JsonResponse([
            'total' => 0,
            'articles' => [
                'featured' => $featured,
                'latest' => $latest
            ]
        ]);
    }
}
