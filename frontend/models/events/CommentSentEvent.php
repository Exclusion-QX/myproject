<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\models\User;
use frontend\models\Post;
use frontend\models\Comments;

class CommentSentEvent extends Event
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var Comments
     */
    public $comments;

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getComment(): Comments
    {
        return $this->comments;
    }

}