<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Launch;
use App\Models\Event;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles'), true);



        array_map(function ($article) {
            $newArticle = Article::create(['id' => $article['id'], 'featured' => $article['featured'], 'title' => $article['title'], 'url' => $article['url'], 'imageUrl' => $article['imageUrl'], 'newsSite' => $article['newsSite'], 'summary' => $article['summary'], 'publishedAt' => $article['publishedAt']]);
            $launches = $article['launches'];
            $events = $article['events'];

            foreach ($launches as $launch) {
             Launch::create(['id' => $launch['id'], 'provider' => $launch['provider'], 'article_id' => $article['id']]);
            }
            foreach ($events as $event) {
             Event::create(['id' => $event['id'], 'provider' => $event['provider'], 'article_id' => $article['id']]);
         }

     }, $json);

    }
}
