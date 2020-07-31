<?php

namespace frontend\modules\comments\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Comments;
use frontend\models\User;
use frontend\models\Post;

class CommentsForm extends Model
{
    const MAX_COMMENT_LENGHT = 1000;
    const EVENT_POST_CREATED = 'post_created';

    public $comment;

    private $user;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'max' => self::MAX_COMMENT_LENGHT],
        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->on(self::EVENT_POST_CREATED, [Yii::$app->feedService, 'addToFeeds']);
//        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    /**
     * @return boolean
     */
    public function save()
    {

    }

}