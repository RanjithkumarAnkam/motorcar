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
    
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
		
       
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass','message'=>"Passwords mismatch"],
            ];
        }
		
        public function findPasswords($attribute, $params){
			 $session = Yii::$app->session;
			 
			 if($session['is_admin'] == 'admin')
			 {
				 $logged_id = $session['admin_user_id'];
			 }
			 else
			 {
				 $logged_id = $session['client_user_id'];
				 
			 }
        	
            $user = TblAcaUsers::find()->where([
                'user_id'=>$logged_id
            ])->one();
			
			$hash= $user->password;
			$password = $this->oldpass;
			
			if (!Yii::$app->getSecurity()->validatePassword($password, $hash)) {
				$this->addError($attribute,'Current password is incorrect');
			} 
			
            
        }
        
        public function attributeLabels(){
            return [
                'oldpass'=>'Current Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Confirm Password',
            ];
        }
    }
	?>