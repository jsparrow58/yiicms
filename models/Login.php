<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%login}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $client_ip
 * @property string $client_time
 * @property string $login_status
 *
 * @property User $u
 */
class Login extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'client_ip', 'client_time'], 'integer'],
            [['login_status'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'client_ip' => 'Client Ip',
            'client_time' => 'Client Time',
            'login_status' => 'Login Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}
