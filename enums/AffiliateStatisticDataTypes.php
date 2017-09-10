<?php

namespace mipotech\affiliates\enums;

use Yii;
use yii2mod\enum\helpers\BaseEnum;

class AffiliateStatisticDataTypes extends BaseEnum
{
	const CLICK = 1;
	const SELL = 2;
		
	public static function getList()
	{
		return [
			self::CLICK => Yii::t('affiliate_statistic_data_types', 'Click on affiliate link'),
			self::INNER	=> Yii::t('affiliate_statistic_data_types', 'Sell with affiliate'),
		];
	}
}
