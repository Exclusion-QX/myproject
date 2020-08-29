<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string|null $description
 * @property int $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function __construct()
    {
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'saveDecriptionInFeed']);
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function like(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    public function unlike(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    /**
     * Check whether given user liked current post
     * @param \frontend\models\User $user
     * @return integer
     */
    public function isLikedBy(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    public function complain(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";

        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }
    }

    public function isReported(User $user)
    {
        /* @var $redis connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->id}:complaints", $user->getId());
    }

    public function getComments()
    {
        $order = ['created_at' => SORT_DESC];
        return $this->hasMany(Comments::className(), ['post_id' => 'id'])->orderBy($order)->all();
    }

    public function getPostAuthor($id)
    {
        return User::findOne(['id' => $id]);
    }

    public function getUserPost($id)
    {
        return Post::findOne(['id' => $id]);
    }

    public function getCommentById($id)
    {
        return Comments::findOne(['id' => $id]);
    }

    public function deleteComment($id)
    {
        return Comments::findOne(['id' => $id])->delete();
    }

    public function editPost($description, $id)
    {
        $model = Post::findOne($id);
        $model->description = $description;
        $model->update();
        return true;
    }

    public function deleteFeeds()
    {
        Feed::deleteAll('post_id = :id', [':id' => $this->id]);

        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);
    }

    public function deleteLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->del("post:{$this->id}:likes");
//        $redis->del("user:*:likes", $this->id());
    }

    public function saveDecriptionInFeed()
    {
        return Yii::$app->db->createCommand()->update('feed', ['post_description' => $this->description], 'post_id = :id', [':id' => $this->id])->execute();
    }
}
