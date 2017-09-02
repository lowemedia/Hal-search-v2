<?php
$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/search', App\Action\HomePageAction::class, 'search');
$app->get('/summary', App\Action\SummaryAction::class, 'summary');

$app->get('/category/code/{slug}', App\Action\CategoryAction::class, 'category')
    ->setOptions([
        'tokens' => ['slug' => '[0-9a-zA-Z-]+'],
    ]);