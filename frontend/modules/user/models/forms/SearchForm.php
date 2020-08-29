<?php


namespace frontend\modules\user\models\forms;

use yii\base\Model;

class SearchForm extends Model
{
    public $username;

    const MIN_USERNAME_LENGHT = 3;
    const MAX_USERNAME_LENGHT = 30;

    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['username'], 'string', 'min' => self::MIN_USERNAME_LENGHT, 'max' => self::MAX_USERNAME_LENGHT],
        ];
    }

    public function __construct()
    {

    }

    public function save()
    {

    }

}