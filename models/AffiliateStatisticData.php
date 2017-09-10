<?php

namespace mipotech\affiliates\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "filemanager_mediafile".
 *
 * @property integer $id
 * @property string $aff_id
 * @property string $camp_id
 * @property string $url
 * @property string $ip
 * @property integer $type
 * @property integer $price
 * @property integer $created_at
 * 
 */

class AffiliateStatisticData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%affiliate_statistic_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aff_id'], 'required'],
            [['aff_id', 'camp_id', 'url', 'ip'], 'string'],
            [['type', 'created_at', 'price'], 'integer'],
            [['aff_id', 'camp_id', 'ip'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('main', 'ID'),
            'aff_id' => Module::t('main', 'Affiliate ID'),
            'camp_id' => Module::t('main', 'Campaign'),
            'url' => Module::t('main', 'Url'),
            'ip' => Module::t('main', 'IP'),
            'type' => Module::t('main', 'type'),
            'price' => Module::t('main', 'price'),
            'created_at' => Module::t('main', 'Created'),
        ];
    }

}
