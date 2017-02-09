<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaSharefileEmployees;
use app\models\TblAcaCompanies;

class SharefileComponent extends Component {
	
	/**
	 * Authenticate via username/password.
	 * Returns json token object.
	 *
	 * @param string $hostname
	 *        	- hostname like "myaccount.sharefile.com"
	 * @param string $client_id
	 *        	- OAuth2 client_id key
	 * @param string $client_secret
	 *        	- OAuth2 client_secret key
	 * @param string $username
	 *        	- my@user.name
	 * @param string $password
	 *        	- my password
	 * @return json token
	 */
	function authenticate($hostname, $client_api_id, $client_secret, $username, $password) {
		$uri = "https://" . $hostname . "/oauth/token";
		// echo "POST ".$uri."\n";
		
		$body_data = array (
				"grant_type" => "password",
				"client_id" => $client_api_id,
				"client_secret" => $client_secret,
				"username" => $username,
				"password" => $password 
		);
		$data = http_build_query ( $body_data );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_POST, TRUE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-Type:application/x-www-form-urlencoded' 
		) );
		
		$curl_response = curl_exec ( $ch );
		
		$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$curl_error_number = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		// echo $curl_response."\n"; // output entire response
		// echo $http_code."\n"; // output http status code
		
		curl_close ( $ch );
		$token = NULL;
		if ($http_code == 200) {
			$token = json_decode ( $curl_response );
			// print_r($token); // print entire token object
		}
		return $token;
	}
	function get_authorization_header($token) {
		return array (
				"Authorization: Bearer " . $token->access_token 
		);
	}
	function get_hostname($token) {
		return $token->subdomain . ".sf-api.com";
	}
	
	/**
	 * Get the root level Item for the provided user.
	 * To retrieve Children the $expand=Children
	 * parameter can be added.
	 *
	 * @param string $token
	 *        	- json token acquired from authenticate function
	 * @param boolean $get_children
	 *        	- retrieve Children Items if True, default is FALSE
	 */
	function get_root($token, $get_children = FALSE) {
		$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items";
		if ($get_children == TRUE) {
			$uri .= "?\$expand=Children";
		}
		// echo "GET ".$uri."\n";
		
		$headers = $this->get_authorization_header ( $token );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		
		$curl_response = curl_exec ( $ch );
		
		$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$curl_error_number = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		// echo $curl_response."\n"; // output entire response
		// echo $http_code."\n"; // output http status code
		
		curl_close ( $ch );
		
		$root = json_decode ( $curl_response );
		// print_r($root); // print entire json response
		// echo $root->Id." ".$root->CreationDate." ".$root->Name."\n";
		if (property_exists ( $root, "Children" )) {
			foreach ( $root->Children as $child ) {
				// echo $child->Id." ".$child->CreationDate." ".$child->Name."\n";
			}
		}
	}
	
	/**
	 * ***************** function to create a new employee in SHAREFILE **************
	 */
	
	/*
	 * public function create_employee($hostname, $client_api_id, $client_secret, $username, $password, $client_id, $client_logged_id, $email, $firstname, $lastname) { $clientpassword = $this->generateRandomString(); $clientpassword = \Yii::$app->EncryptDecrypt->encrytedUser($clientpassword); //'Password1!'; $token = $this->authenticate($hostname, $client_api_id, $client_secret, $username, $password); if ($token) { $this->get_root($token, TRUE); } $uri = "https://".$this->get_hostname($token)."/sf/v3/Users/AccountUser"; //echo "POST ".$uri."\n"; $client = array("Email"=>$email, "FirstName"=>$firstname, "LastName"=>$lastname, "Password"=>$clientpassword,"IsEmployee"=>TRUE,"IsAdministrator"=>TRUE,"CanCreateFolders"=>TRUE,"CanUseFileBox"=>TRUE, "CanManageUsers"=>TRUE, "Preferences"=>array("CanResetPassword"=>FALSE, "CanViewMySettings"=>FALSE)); $data = json_encode($client); $headers = $this->get_authorization_header($token); $headers[] = "Content-Type: application/json"; $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $uri); curl_setopt($ch, CURLOPT_TIMEOUT, 300); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); curl_setopt($ch, CURLOPT_VERBOSE, FALSE); curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); curl_setopt($ch, CURLOPT_POSTFIELDS, $data); curl_setopt($ch, CURLOPT_POST, TRUE); curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); $curl_response = curl_exec ($ch); $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); $curl_error_number = curl_errno($ch); $curl_error = curl_error($ch); //echo $curl_response."\n"; // output entire response //echo "http_code = ".$http_code."\n"; // output http status code curl_close ($ch); if ($http_code == 200) { $client = json_decode($curl_response); //print_r($client); // print entire new item object $model_sharefile = new TblAcaSharefileEmployees(); $model_sharefile->user_id = $client_logged_id; $model_sharefile->client_id = $client_id; $model_sharefile->username = $client->Username; $model_sharefile->password = $clientpassword; $model_sharefile->sharefile_employee_id = $client->Id; $model_sharefile->created_date = date ( 'Y-m-d H:i:s' ); $model_sharefile->isNewRecord = true; $model_sharefile->sharefile_user_id = NULL; if($model_sharefile->save()) { $result = $this->create_sharefile_folder($hostname, $client_api_id, $client_secret, $client_logged_id, $client_id, $client->Username, $clientpassword); if($result == 'success'){ return 'success'; } else{ return 'error occured'; } } else{ return 'error occured'; } } else{ return 'error occured'; } }
	 */
	
	/**
	 * ***************** function to create a new folder for every company in SHAREFILE **************
	 */
	public function create_sharefile_folder($hostname, $client_api_id, $client_secret, $client_logged_id, $client_id, $new_username, $new_password) {
		try {
			
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			if ($token) {
				$this->get_root ( $token, TRUE );
			}
			
			$parent_id = $this->get_home_folder ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			// / get the company names of the client //
			
			$company_details = TblAcaCompanies::find ()->where ( [ 
					'client_id' => $client_id 
			] )->orderBy ( 'company_id' )->all ();
			$company_count = count ( $company_details );
			$count = 0;
			if (! empty ( $company_details )) {
				foreach ( $company_details as $company ) {
					$name = $company->company_client_number;
					$company_id = $company->company_id;
					$result = $this->create_company_folder ( $token, $parent_id, $name, $client_logged_id, $client_id, $company_id );
					$response = json_decode ( $result );
					if ($response->result == 'success') {
						$count ++;
					}
					else{
						return $response;
					}
				}
			}
			if ($company_count == $count) {
				return 'success';
			} else {
				return 'error occured';
			}
		} catch ( \Exception $e ) {
			//return 'error occured';
			return $e;
		}
	}
	
	/*
	*This function is used to zip the files and folder in a folder
	*/
	public function foldertofolderzip($dir,$zip_file)
	{
		//$dir = 'dir';
		//$zip_file = 'file.zip';

		// Get real path for our folder
		$rootPath = realpath($dir);

		// Initialize archive object
		$zip = new \ZipArchive ();
		$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath),
			\RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		return 'success';
	}
	
	
	/**
	 * ***************** function to Get HomeFolder for Current User **************
	 */
	public function get_home_folder($hostname, $client_api_id, $client_secret, $new_username, $new_password) {
		$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
		
		if ($token) {
			$this->get_root ( $token, TRUE );
		}
		
		$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items";
		
		$headers = $this->get_authorization_header ( $token );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		
		$curl_response = curl_exec ( $ch );
		
		$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$curl_error_number = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		// echo $curl_response."\n"; // output entire response
		// echo $http_code."\n"; // output http status code
		
		curl_close ( $ch );
		
		$root = json_decode ( $curl_response );
		// print_r($root); // print entire json response
		return $root->Id;
	}
	
	/**
	 * ***************** function to create a new folder for every company in SHAREFILE **************
	 */
	public function create_company_folder($token, $parent_id, $name, $client_logged_id, $client_id, $company_id) {
		try {
			$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items(" . $parent_id . ")/Folder";
			// echo "POST ".$uri."\n";
			
			$folder = array (
					"Name" => $name 
			);
			$data = json_encode ( $folder );
			
			$headers = $this->get_authorization_header ( $token );
			$headers [] = "Content-Type: application/json";
			// print_r($headers);
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $uri );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt ( $ch, CURLOPT_POST, TRUE );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			
			$curl_response = curl_exec ( $ch );
			
			$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$curl_error_number = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			
			// echo $curl_response."\n"; // output entire response
			// echo $http_code."\n"; // output http status code
			
			curl_close ( $ch );
			
			if ($http_code == 200) {
				$item = json_decode ( $curl_response );
				// print_r($item); // print entire new item object
				// echo "Created Folder: ".$item->Id."\n";
				
				$model_sharefile = new TblAcaSharefileFolders ();
				
				$model_sharefile->user_id = $client_logged_id;
				$model_sharefile->client_id = $client_id;
				$model_sharefile->company_id = $company_id;
				$model_sharefile->company_client_number = $name;
				$model_sharefile->folder_name = $item->Name;
				$model_sharefile->sharefile_folder_id = $item->Id;
				$model_sharefile->created_date = date ( 'Y-m-d H:i:s' );
				$model_sharefile->modified_date = date ( 'Y-m-d H:i:s' );
				$model_sharefile->created_by = $client_logged_id;
				$model_sharefile->isNewRecord = true;
				$model_sharefile->folder_id = NULL;
				
				if ($model_sharefile->save ()) {
					$success_result = array (
							"result" => "success",
							"id" => $item->Id 
					);
					return json_encode ( $success_result );
					// return 'success';
				} else {
					// return 'error occured';
					$success_result = array (
							//"result" => "error occured" 
							"result" => $curl_response 
					);
					return json_encode ( $success_result );
				}
			} else {
				// return 'error occured';
				$success_result = array (
						//"result" => "error occured" 
						"result" => $curl_response 
				);
				return json_encode ( $success_result );
			}
		} catch ( \Exception $e ) {
			// return 'error occured';
			$success_result = array (
					//"result" => "error occured" 
					"result" => $e 
			);
			return json_encode ( $success_result );
		}
	}
	
	/**
	 * ****** function to create extra folder for existing employee ********
	 */
	public function create_extra_sharefile_folder($hostname, $client_api_id, $client_secret, $client_logged_id, $client_id, $new_username, $new_password, $name, $company_id) {
		try {
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			if ($token) {
				$this->get_root ( $token, TRUE );
			}
			
			$parent_id = $this->get_home_folder ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			$result = $this->create_company_folder ( $token, $parent_id, $name, $client_logged_id, $client_id, $company_id );
			$response = json_decode ( $result );
			if ($response->result = 'success') {
				$success_result = array (
						"result" => "success",
						"id" => $response->id 
				);
				return json_encode ( $success_result );
				// return 'success';
			} else {
				// return 'error occured';
				$success_result = array (
						"result" => "error occured" 
				);
				return json_encode ( $success_result );
			}
		} catch ( \Exception $e ) {
			// return 'error occured';
			$success_result = array (
					"result" => "error occured" 
			);
			return json_encode ( $success_result );
		}
	}
	
	/**
	 * ****** function to upload a file into a SHAREFILE folder ********
	 */
	function upload_file($hostname, $client_api_id, $client_secret, $new_username, $new_password, $new_folder_id, $local_path) {
		// print_r( $local_path);die();
		try {
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items(" . $new_folder_id . ")/Upload";
			// echo "GET ".$uri."\n";
			
			$headers = $this->get_authorization_header ( $token );
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $uri );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			
			$curl_response = curl_exec ( $ch );
			
			$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$curl_error_number = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			
			$upload_config = json_decode ( $curl_response );
			//print_r($upload_config->code);die();
			if ($http_code == 200) {
				$post ["File1"] = new \CurlFile ( $local_path );
				curl_setopt ( $ch, CURLOPT_URL, $upload_config->ChunkUri );
				curl_setopt ( $ch, CURLOPT_POST, true );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt ( $ch, CURLOPT_HEADER, true );
				
				$upload_response = curl_exec ( $ch );
				
				return $upload_response . "\n";
			}
			else{
				throw new \Exception ($upload_config->code);
			}
			curl_close ( $ch );
		} catch ( \Exception $e ) {
			
			return $e->getMessage();
		}
	}
	
	/**
	 * ****** function to get the available items from a SHAREFILE folder ********
	 */
	public function get_children($hostname, $client_api_id, $client_secret, $new_username, $new_password, $folder_id) {
		$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
		
		if ($token) {
			$this->get_root ( $token, TRUE );
		}
		
		$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items(" . $folder_id . ")/Children?includeDeleted=false";
		
		$headers = $this->get_authorization_header ( $token );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		
		$curl_response = curl_exec ( $ch );
		
		$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$curl_error_number = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		// echo $curl_response."\n"; // output entire response
		// echo $http_code."\n"; // output http status code
		
		curl_close ( $ch );
		
		$root = json_decode ( $curl_response );
		return $root;
		// print_r($root); // print entire json response
		// return $root->Id;
	}
	
	/**
	 * ****** function to download a file into our local from SHAREFILE folder ********
	 */
	public function download_item($hostname, $client_api_id, $client_secret, $new_username, $new_password, $item_id, $file_name, $folder_name) {
		try {
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			if ($token) {
				$this->get_root ( $token, TRUE );
			}
			// $item_id = 'fo3a40c2-407d-4c31-9c2c-a1ec53ce80ae';
			$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items(" . $item_id . ")/Download";
			// echo "GET ".$uri."\n";
			
			// exec('rm -R '.getcwd ().'/Images/sharefile_docs/'.$folder_name);
			// exec('rm '.getcwd ().'/Images/sharefile_docs/'.$folder_name.'.zip');
			
			if (! is_dir ( getcwd () . '/Images/sharefile_docs/' . $folder_name )) {
				mkdir ( getcwd () . '/Images/sharefile_docs/' . $folder_name, 0777, true );
				$old = umask ( 0 );
				chmod ( getcwd () . '/Images/sharefile_docs/' . $folder_name, 0777 );
				umask ( $old );
			}
			
			$local_path = getcwd () . '/Images/sharefile_docs/' . $folder_name . '/' . $file_name;
			$fp = fopen ( $local_path, 'w' );
			$old = umask ( 0 );
			chmod ( $local_path, 0777 );
			umask ( $old );
			
			$headers = $this->get_authorization_header ( $token );
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $uri );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt ( $ch, CURLOPT_FILE, $fp );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			
			$curl_response = curl_exec ( $ch );
			
			$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$curl_error_number = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			
			// echo $http_code."\n";
			
			curl_close ( $ch );
			fclose ( $fp );
			
			return $http_code;
		} catch ( \Exception $e ) {
			return $e;
		}
	}
	
	/**
	 * ****** function to create a ZIP from all downloaded files ********
	 */
	public function zipaDirectory($sourcePath, $outZipPath) {
		$pathInfo = pathInfo ( $sourcePath );
		$parentPath = $pathInfo ['dirname'];
		$dirName = $pathInfo ['basename'];
		
		$z = new \ZipArchive ();
		$z->open ( $outZipPath, \ZIPARCHIVE::CREATE );
		$z->addEmptyDir ( $dirName );
		$this->folderToZip ( $sourcePath, $z, strlen ( "$parentPath/" ) );
		$z->close ();
		
		return 'success';
	}
	
	/**
	 * ** function to convert a folder to zip***
	 */
	private static function folderToZip($folder, $zipFile, $exclusiveLength) {
		$handle = opendir ( $folder );
		while ( false !== $f = readdir ( $handle ) ) {
			if ($f != '.' && $f != '..') {
				$filePath = "$folder/$f";
				// Remove prefix from file path before add to zip.
				$localPath = substr ( $filePath, $exclusiveLength );
				if (is_file ( $filePath )) {
					$zipFile->addFile ( $filePath, $localPath );
				} elseif (is_dir ( $filePath )) {
					// Add sub-directory.
					$zipFile->addEmptyDir ( $localPath );
					$this->folderToZip ( $filePath, $zipFile, $exclusiveLength );
				}
			}
		}
		closedir ( $handle );
	}
	
	/**
	 * ********** function to create a share folder **********
	 */
	public function create_share($hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $sharefile_user_id) {
		$user_id = '584f98ca-be03-49bd-8cf9-047d359cc7c2';
		$username = 'banalavinodkumar1@gmail.com';
		
		/*
		 * $client = array("ShareType"=>"Send", "Title"=>"Sample Send Share", "ExpirationDate"=>"9999-12-31","RequireLogin"=>FALSE,"RequireUserInfo"=>FALSE,"MaxDownloads"=>"-1","UsesStreamIDs"=>FALSE, "Items"=>array("Id"=>$sharefile_folder_id),"Recipients"=>array("User"=>array("Id"=>$user_id),"User"=>array("Email"=>$username))); $data = json_encode($client); return $data;
		 */
		$data = '{ 
				  "ShareType":"Send", 
				  "Title":"Sample Send Share", 
				  "Items": [ { "Id":"' . $sharefile_folder_id . '" } ], 
				  "Recipients":[ { "User": { "Id":"' . $user_id . '" } }, { "User": { "Email": "' . $username . '" } } ], 
				  "ExpirationDate": "9999-12-31", 
				  "RequireLogin": false, 
				  "RequireUserInfo": false, 
				  "MaxDownloads": -1, 
				  "UsesStreamIDs": false
				} ';
		// return $data;
		$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
		
		if ($token) {
			$this->get_root ( $token, TRUE );
		}
		
		$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Shares?notify=false";
		
		$headers = $this->get_authorization_header ( $token );
		$headers [] = "Content-Type: application/json";
		// print_r($headers);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_POST, TRUE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		
		$curl_response = curl_exec ( $ch );
		
		$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$curl_error_number = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		// echo $curl_response."\n"; // output entire response
		// return $http_code."\n"; // output http status code
		
		curl_close ( $ch );
		
		if ($http_code == 200) {
			$item = json_decode ( $curl_response );
			return ($item); // print entire new item object
				                // echo "Created Folder: ".$item->Id."\n";
		}
	}
	
	/**
	 * ********* function to create a client for the sharefile user **********
	 */
	public function create_client($hostname, $client_api_id, $client_secret, $username, $password, $email, $firstname, $lastname, $client_id, $client_logged_id) {
		try {
			$clientpassword = $this->generateRandomString ();
			$enc_clientpassword = \Yii::$app->EncryptDecrypt->encrytedUser ( $clientpassword );
			// 'Password1!';
			
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $username, $password );
			
			if ($token) {
				$this->get_root ( $token, TRUE );
			}
			
			$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Users";
			// echo "POST ".$uri."\n";
			/*
			 * $email = 'banelasainath@gmail.com'; $firstname = 'Sainath'; $lastname = 'Banela';
			 */
			
			$client = array (
					"Email" => $email,
					"FirstName" => $firstname,
					"LastName" => $lastname,
					"Password" => $clientpassword,
					"addPersonal" => TRUE,
					"notify" => FALSE,
					"Preferences" => array (
							"CanResetPassword" => FALSE,
							"CanViewMySettings" => FALSE 
					) 
			);
			$data = json_encode ( $client );
			
			$headers = $this->get_authorization_header ( $token );
			
			$headers [] = "Content-Type: application/json";
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $uri );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt ( $ch, CURLOPT_POST, TRUE );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			
			$curl_response = curl_exec ( $ch );
			
			$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$curl_error_number = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			
			// return $curl_response."\n"; // output entire response
			// return "http_code = ".$http_code."\n"; // output http status code
			
			curl_close ( $ch );
			
			if ($http_code == 200) {
				$client = json_decode ( $curl_response );
				// return $client;
				$sharefile_client_id = $client->Id;
				
				$model_sharefile = new TblAcaSharefileEmployees ();
				
				$model_sharefile->user_id = $client_logged_id;
				$model_sharefile->client_id = $client_id;
				$model_sharefile->username = $client->Username;
				$model_sharefile->password = $enc_clientpassword;
				$model_sharefile->sharefile_employee_id = $client->Id;
				$model_sharefile->created_date = date ( 'Y-m-d H:i:s' );
				$model_sharefile->modified_date = date ( 'Y-m-d H:i:s' );
				$model_sharefile->created_by = $client_logged_id;
				$model_sharefile->isNewRecord = true;
				$model_sharefile->sharefile_user_id = NULL;
				
				if ($model_sharefile->save ()) {
					// $result = $this->access_control($hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id, $sharefile_client_id);
					// return $result;
					$success_result = array (
							"result" => "success",
							"id" => $sharefile_client_id 
					);
					return json_encode ( $success_result );
				} else {
					$success_result = array (
							"result" => "error occured" 
					);
					return json_encode ( $success_result );
					// return 'error occured';
				}
			} else {
				$success_result = array (
						"result" => "error occured",
						"id" => $curl_response
				);
				return json_encode ( $success_result );
			}
		} catch ( \Exception $e ) {
			$success_result = array (
					"result" => "error occured",
					"id" => $e->getMessage()					
			);
			return json_encode ( $success_result );
		}
	}
	
	/**
	 * ****** function to give access control ********
	 */
	public function access_control($hostname, $client_api_id, $client_secret, $new_username, $new_password, $folder_id, $sharefile_client_id) {
		try {
			$token = $this->authenticate ( $hostname, $client_api_id, $client_secret, $new_username, $new_password );
			
			if ($token) {
				$this->get_root ( $token, TRUE );
			}
			
			$data = array ();
			$data ['Principal'] ['url'] = "https://" . $this->get_hostname ( $token ) . "/v3/Users(" . $sharefile_client_id . ")";
			$data ['CanUpload'] = TRUE;
			$data ['CanDownload'] = TRUE;
			$data ['CanView'] = TRUE;
			$data ['CanDelete'] = FALSE;
			$data ['CanManagePermissions'] = FALSE;
			$data ['sendDefaultNotification'] = TRUE;
			$data ['Message'] = "";
			
			$data = json_encode ( $data );
			
			// return $data;
			$uri = "https://" . $this->get_hostname ( $token ) . "/sf/v3/Items(" . $folder_id . ")/AccessControls?recursive=FALSE";
			
			$headers = $this->get_authorization_header ( $token );
			$headers [] = "Content-Type: application/json";
			// print_r($headers);
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $uri );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_VERBOSE, FALSE );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt ( $ch, CURLOPT_POST, TRUE );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			
			$curl_response = curl_exec ( $ch );
			
			$http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$curl_error_number = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			
			// echo $curl_response."\n"; // output entire response
			// return $curl_response."\n"; // output http status code
			
			curl_close ( $ch );
			
			if ($http_code == 200) {
				$item = json_decode ( $curl_response );
				return ($item->Id); // print entire new item object
					                    // echo "Created Folder: ".$item->Id."\n";
			}
			else{
				return '';
			}
		} catch ( \Exception $e ) {
			return '';
		}
	}
	
	/**
	 * ** function to generate random string (for SHAREFILE password) *****
	 */
	/*private function generateRandomString() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen ( $characters );
		$randomString = '';
		for($i = 0; $i < $length; $i ++) {
			$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
		}
		$randomString .= 'Au';
		return $randomString;
	}*/
	
	private function generateRandomString(){
		
		$length = 10;
		$add_dashes = false;
		$available_sets = 'luds';
		
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];
		$password = str_shuffle($password);
		if(!$add_dashes)
			return $password;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	
	}
}