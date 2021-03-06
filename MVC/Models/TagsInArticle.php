<?php

namespace MVC\Models;

/**
 * Class Tag
 * @package MVC\Models
 * @table(Tags_In_Article)
 */
class TagsInArticle
{
    /**
     * key for Article
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\Article)
     * @foreignField(id)
     * @var Article
     */
    private $article;

    /**
     * key for tag
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\Tag)
     * @foreignField(id)
     * @var Tag
     */
    private $tag;


    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

}