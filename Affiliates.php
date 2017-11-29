<?php

namespace mipotech\affiliates;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use mipotech\affiliates\models\AffiliateStatisticData;
use mipotech\affiliates\enums\AffiliateStatisticDataTypes;

/**
 * Bootstrap interface to restrict access to the dev environment
 *
 * @link http://www.yiiframework.com/wiki/652/how-to-use-bootstrapinterface/
 * @author Chaim Leichman, MIPO Technologies Ltd
 */
class Affiliates extends Component implements BootstrapInterface
{
	public $affiliateClass;
    public $affiliateIdAttribute;
    public $affiliateIdUrlParam = 'ref';
	public $campaignIdUrlParam = 'camp';
	public $affiliateExpiredDays = 30;
	public $affiliateLinkClickedCallBack = null;
	private $affiliate=null;
	private $affiliateId=null;
	
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
    	$resCookies = Yii::$app->response->cookies;
		$reqCookies = Yii::$app->request->cookies;
		
		// Get affiliateId
		$affiliateId = Yii::$app->request->get($this->affiliateIdUrlParam);
		if($affiliateId){
			if(!$reqCookies->getValue($this->affiliateIdUrlParam, null)){
				$resCookies->add(new \yii\web\Cookie([
				    'name' => $this->affiliateIdUrlParam,
				    'value' => $affiliateId,
				    'expire' => strtotime("now +$this->affiliateExpiredDays days"),
				    'domain' => $_SERVER['HTTP_HOST']
				]));
				$this->affiliate = $this->affiliateClass::findOne([$this->affiliateIdAttribute => $affiliateId]);
			}
		}
		
		// Get campaignId
		$campaignId = Yii::$app->request->get($this->campaignIdUrlParam);
		if($campaignId){
			if(!$reqCookies->getValue($this->campaignIdUrlParam, null)){
				$resCookies->add(new \yii\web\Cookie([
				    'name' => $this->campaignIdUrlParam,
				    'value' => $campaignId,
				    'expire' => strtotime("now +$this->affiliateExpiredDays days"),
				    'domain' => $_SERVER['HTTP_HOST']
				]));
			}
		}

		// Set clicks data
		if($affiliateId){		
			$data = new AffiliateStatisticData;
			$data->aff_id = $affiliateId;
			$data->camp_id = $campaignId;
			$data->url = Yii::$app->request->url;
			$data->ip = Yii::$app->request->userIP;
			$data->type = AffiliateStatisticDataTypes::CLICK;
			$data->created_at = strtotime('now');
			$data->save();
			
			// Click Callback
			if(is_callable($this->affiliateLinkClickedCallBack)) {
				call_user_func($this->affiliateLinkClickedCallBack, $data);
			}
		}
    }
	
    public function init()
    {

    }
	
	public function get()
	{
		$reqCookies = Yii::$app->request->cookies;
		$affiliateId = $reqCookies->getValue($this->affiliateIdUrlParam, null);
		
		if(!$this->affiliate || $this->affiliate->id != $affiliateId){
			$this->affiliate = $this->affiliateClass::findOne([$this->affiliateIdAttribute => $affiliateId]);
		}
		
		return $this->affiliate; //Yii::$app->affiliates->get()
	}
	
	public function getCamp()
	{
		$reqCookies = Yii::$app->request->cookies;
		$campId = $reqCookies->getValue($this->campaignIdUrlParam, null);
		
		return $campId; //Yii::$app->affiliates->get()
	}
	
	public function clicksCount($params = [])
	{
		//$affId, $campId, $fromTime, $toTime
		$query = AffiliateStatisticData::find()->where(['aff_id' => $params['aff_id'], 'camp_id' => $params['camp_id'], 'type' => AffiliateStatisticDataTypes::CLICK]);
		
		if($params['fromTime']){
			$query->andWhere(['<', 'created_at', $params['fromTime']]);
		}
		if($params['toTime']){
			$query->andWhere(['>', 'created_at', $params['toTime']]);
		}
		
		return $query->count();
	}
	
	public function notifyNewPurchase($params = [])
	{
		$reqCookies = Yii::$app->request->cookies;
		$affiliateId = $reqCookies->getValue($this->affiliateIdUrlParam, null);
		$campaignId = $reqCookies->getValue($this->campaignIdUrlParam, null);

		$data = new AffiliateStatisticData;
		$data->aff_id = $affiliateId;
		$data->camp_id = $campaignId;
		$data->type = AffiliateStatisticDataTypes::SELL;
		$data->created_at = strtotime('now');
		$data->save();
	}	
	
	public function sellsCount($params = [])
	{
		//$affId, $campId, $fromTime, $toTime
		$query = AffiliateStatisticData::find()->where(['aff_id' => $params['aff_id'], 'camp_id' => $params['camp_id'], 'type' => AffiliateStatisticDataTypes::SELL]);
		
		if($params['fromTime']){
			$query->andWhere(['<', 'created_at', $params['fromTime']]);
		}
		if($params['toTime']){
			$query->andWhere(['>', 'created_at', $params['toTime']]);
		}

		return $query->count();
	}
	
}
