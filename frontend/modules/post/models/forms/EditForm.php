<?php


namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Comments;
use frontend\models\User;
use frontend\models\Post;
use frontend\models\events\CommentSentEvent;

class EditForm extends Model
{
    const MAX_DESCRIPTION_LENGHT = 1000;

    public $description;

    public function rules()
    {
        return [
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
        ];
    }

    public function __construct()
    {
//        $this->on(self::EVENT_COMMENT_SENT, [Yii::$app->feedService, 'addToFeeds']);
    }

    /**
     * @return boolean
     */
    public function save($id)
    {
        if ($this->validate()) {
            $post = new Post();
            $post->description = $this->description;
            return $post->editPost($post->description, $id);
        }

    }

}