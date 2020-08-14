<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string|null $description
 * @property int $created_at
 * @property int|null $complaints
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
            'complaints' => 'Complaints',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findComplaints()
    {
        return Post::find()->where('complaints > 0')->orderBy('complaints DESC');
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function approve()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);

        $this->complaints = 0;
        return $this->save(false, ['complaints']);
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

}
