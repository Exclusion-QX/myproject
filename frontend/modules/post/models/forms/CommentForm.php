<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Comments;
use frontend\models\User;
use frontend\models\Post;
use frontend\models\events\CommentSentEvent;

class CommentForm extends Model
{
    const MAX_COMMENT_LENGHT = 1000;
    const EVENT_COMMENT_SENT = 'post_created';

    public $comment;

    private $user;

    public $post;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'max' => self::MAX_COMMENT_LENGHT],
        ];
    }

    public function __construct()
    {
//        $this->user = $user;

        $this->on(self::EVENT_COMMENT_SENT, [Yii::$app->feedService, 'addToFeeds']);
    }

    /**
     * @return boolean
     */
    public function save($id, $username)
    {
        if ($this->validate()) {
            $comment = new Comments();
            $this->post = new Post();
            $this->user = Yii::$app->user->identity;
            $comment->comment = $this->comment;
            $comment->created_at = time();
            $comment->post_id = $id;
            $comment->user_id = Yii::$app->user->id;
            $comment->author_comment = $username;
            $comment->author_picture = $this->user->getPicture();
//            if ($comment->save(false)) {
//                $event = new CommentSentEvent();
//                $event->user = $this->user;
//                $event->post = $this->post;
//                $event->comments = $comment;
//                $this->trigger(self::EVENT_COMMENT_SENT, $event);
//                return true;
//            }
            return $comment->save();
        }

//        return false;
    }

}