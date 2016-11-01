<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%admin_login}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $client_ip
 * @property string $client_time
 * @property string $login_status
 *
 * @property Admin $u
 */
class AdminLogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'client_ip', 'client_time'], 'integer'],
            [['login_status'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['uid' => 'id']],
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
        return $this->hasOne(Admin::className(), ['id' => 'uid']);
    }
}
