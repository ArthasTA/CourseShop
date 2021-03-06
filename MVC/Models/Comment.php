<?php


namespace MVC\Models;

/**
 * Class Comment
 * @package MVC\Models
 * @table(Comments)
 */
class Comment
{
    const PARENT_TYPE_ARTICLE = 0;
    const PARENT_TYPE_COMMENT = 1;

    /**
     * Unique key for comment
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $id;

    /**
     * Unique key for User
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Count of likes
     *
     * @columnType(INT(11) UNSIGNED)
     * @var int
     */
    private $likes;

    /**
     * Count of dislikes
     *
     * @columnType(INT(11) UNSIGNED)
     * @var int
     */
    private $dislikes;

    /**
     * Body of article
     *
     * @columnType(TEXT NOT NULL)
     * @var String
     */
    private $body;

    /**
     * Date of creation
     *
     * @columnType(TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $created;

    /**
     * Parent Id - id of parent article, or parent comment,
     * or something else...
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @selector(parentType)
     * @foreignModel(MVC\Models\Article,MVC\Models\Comment)
     * @foreignField(id)
     * @var Article|Comment
     */
    private $parent;

    /**
     * Type of parent
     *
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var int
     */
    private $parentType;

    /**
     * @param Article $article
     * @return $this
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param int $likes
     * @return $this
     */
    public function setLikes(int $likes)
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @param int $dislikes
     * @return $this
     */
    public function setDislikes(int $dislikes)
    {
        $this->dislikes = $dislikes;
        return $this;
    }

    /**
     * @param String $body
     * @return $this
     */
    public function setBody(String $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @param Article|Comment $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param mixed $parentType
     * @return $this
     */
    public function setParentType($parentType)
    {
        $this->parentType = $parentType;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @return String
     */
    public function getBody(): String
    {
        return $this->body;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return Article|Comment
     */
    public function getParent()
    {
        if ($this->getParentType() === static::PARENT_TYPE_ARTICLE) {
            return new Article();
        } else {
            return new Comment();
        }
    }

    /**
     * @return int
     */
    public function getParentType(): int
    {
        return $this->parentType;
    }



}