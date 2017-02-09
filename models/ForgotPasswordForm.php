<?php 
    namespace app\models;
    
    use Yii;
    use yii\base\Model;
    use yii\filters\AccessControl;
	use yii\web\Controller;
	use yii\helpers\Url;
	use yii\helpers\ArrayHelper;
	use yii\base\ErrorException;
	use app\models\TblAcaUsers;
    
    class ForgotPasswordForm extends Model{
        public $email;
       
       
        public function rules(){
            return [
                [['email'],'required'],
                ['email','email'],
                ['email','findEmail'],
            ];
        }
		
        public function findEmail($attribute, $params){
			 $user = TblAcaUsers::find()->where([
                'useremail'=>$this->email
            ])->one();
			
			
			if (empty($user)) {
				$this->addError($attribute,'Email id does not exists');
			} 
			
            
        }
        
        public function attributeLabels(){
            return [
                'email'=>'Email Id',
              ];
        }
    }
	?>