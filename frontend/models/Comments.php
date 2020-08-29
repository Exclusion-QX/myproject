<?php


namespace frontend\models;

use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
            'comment' => 'Comment',
            'author_comment' => 'Author Comment',
            'author_picture' => 'Author Picture',
            'created_at' => 'Created At',
        ];
    }

    public function setPicture($id, $picture)
    {
        $model = Comments::find()->where(['user_id' => $id])->all();
        $model->author_picture = $picture;
        $model->update();
        return true;
    }

}