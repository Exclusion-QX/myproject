<?php


namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;
use Intervention\Image\ImageManager;
use frontend\models\events\PostCreatedEvent;

class ProfileForm extends Model
{
    const MAX_ABOUT_LENGHT = 1000;
    const MAX_NICKNAME_LENGHT = 20;
    const MAX_USERNAME_LENGHT = 30;
    const MIN_USERNAME_LENGHT = 3;
    const EVENT_COMMENT_SENT = 'changes_saved';

    public $username;
    public $about;
    public $nickname;

    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'min' => self::MIN_USERNAME_LENGHT, 'max' => self::MAX_USERNAME_LENGHT],
            [['about'], 'string', 'max' => self::MAX_ABOUT_LENGHT],
            [['nickname'], 'string', 'max' => self::MAX_NICKNAME_LENGHT],
        ];
    }

    public function __construct()
    {
//        $this->user = $user;

//        $this->on(self::EVENT_COMMENT_SENT, [Yii::$app->feedService, 'addToFeeds']);
    }

    public function save()
    {
        if ($this->validate()){
            $user = new User();
            $user->username = $this->username;
            $user->nickname = $this->nickname;
            $user->about = $this->about;
            return $user->editUser($user->username, $user->nickname, $user->about);
        }
    }

}