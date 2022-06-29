<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MX_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->library('general');
        $this->load->model('content/content_model');
		$this->load->model('login/login_model');
        header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
    }

	public function login()
	{

		$error = false;

		$login    = $this->input->post('vEmail');
		$password = $this->input->post('vPassword');

		if(empty($login))
		{
			$error = true;
			$data['message'] = array('Output' => 1, 'Message' => 'Email is required');
		}
		if(empty($password))
		{
			$error = true;
			$data['message'] = array('Output' => 1, 'Message' => 'Password is required');
		}

		if($error == false)
		{
			$result     = $this->login_model->login($login, md5($password));

			if(count($result) > 0)
			{	
				if($result->eStatus == 'Active')
				{
					$data['estatus']     = "0";
					$data['message'] 	= 'Login Successfully';
					$data['data']	    = $result;
				}
				else 
				{
					$data['estatus']     = "1";
					$data['message'] 	= 'Status Not Active';
				}
			} 	 
			else 
			{	
				$data['estatus']     = "1";
				$data['message']    = 'Email and Password Incorect!';
			}
		}
	
		echo json_encode($data);
		exit;

	}

	public function csv()
	{
		$result     		= $this->content_model->get_by_all_country1();
		$pros               = $this->content_model->get_by_all_prospectingdata1();
		$dup_housefile      = $this->content_model->get_by_all_duplicatedata_housefile1();
		$prospecting        = $this->content_model->get_by_all_duplicatedata1();
		$without_duplicate  = $this->content_model->get_by_dublicatedata_hosefile1();
		$total 				= $pros - $without_duplicate;
	

		if(!empty($result) || !empty($pros))
		{
			$session_data['vUsername'] 	    = "Jayesh";
		    $this->session->set_userdata($session_data);
			$allcount 					= array();
			$allcount['count'] 			= $result;
			$allcount['pcount']     	= $pros;
			$allcount['house']      	= $dup_housefile;
			$allcount['prospecting'] 	= $prospecting;
			$allcount['duplicate']   	= $total;

			$data['Status']     = '1';
			$data['message']  	= 'Data Successfully';
			$data['data']  	    = $allcount;
			
			
		}
		else
		{
			$data['Status']     = '0';
			$data['message']  	= 'Data Not Found';
			$data['data']     	= array();
		}
 		echo json_encode($data);
	}

	public function csv_all()
	{
		
		ini_set('memory_limit', '-1');
		$result     		= $this->content_model->get_by_all_country();
		$arr 	= array();
		$k  	= 0;
		$c 		= count($result);
        while($result)
        {
        	if(!empty($result[$k]->vFirstName) && !empty($result[$k]->vLastname))
        	{
            	array_push($arr,[
					$result[$k]->id,
					$result[$k]->vFirstName,
					$result[$k]->vLastname,
					$result[$k]->vStreet,
					$result[$k]->vState
				]);

            	if($c-1==$k)
	            {
	                break;
	            }
            }
			$k++;
		}

 		echo json_encode($arr);
		exit;
	}

	public function duplicate_remove()
	{
		$TableName = $_POST['TableName'];
		if($TableName=='1')
		{
			$result_dublicate   = $this->content_model->get_by_all_dublicate();
			if($result_dublicate)
			{
				$data['Status']     = '0';
				$data['count']      =  $this->content_model->get_by_all_dublicate_count();
				$data['message']  	= 'Duplicate data Remove Successfully';
				echo json_encode($data);
				exit;
			}
		}
		else
		{
			$result_dublicate   = $this->content_model->get_by_all_dublicate_housefile();
			if($result_dublicate > 0)
			{
				$data['Status']     = '0';
				$data['count']      = $this->content_model->get_by_all_dublicate_house();
				$data['message']  	= 'Duplicate data Remove Successfully';
				echo json_encode($data);
				exit;
			}
		}	
	}

	public function duplicate_remove1()
	{
		
		$TableName = $_POST['TableName'];
	
		if($TableName=='1')
		{
			$result_dublicate   = $this->content_model->get_by_all_dublicate();
			if($result_dublicate)
			{
				$data['Status']     = '0';
				$data['count']      =  $this->content_model->get_by_all_dublicate_count();
				$data['message']  	= 'Duplicate data Remove Successfully';
				echo json_encode($data);
				exit;
			}
		}
		else
		{
			$result_dublicate   = $this->content_model->get_by_all_dublicate_housefile();
			if($result_dublicate > 0)
			{
				$data['Status']     = '0';
				$data['count']      = $this->content_model->get_by_all_dublicate_house();
				$data['message']  	= 'Duplicate data Remove Successfully';
				echo json_encode($data);
				exit;
			}
		}	
	}

	
    public function duplicate_remove_count()
	{
		$result_dublicate   	= $this->content_model->get_by_all_dublicate_count();
		$data['Status']     	= '0';
		$data['count']      	= $result_dublicate;
		$data['count_house'] 	= $this->content_model->get_by_all_dublicate_house();
		$data['replace']     	= $this->login_model->get_by_update_data();
		$data['replace_hose']   = $this->login_model->get_by_update_data_hosefile();
		$data['message']  		= 'Duplicate data Count Successfully';
		echo json_encode($data);
		exit;
	}
	
	public function csv_prospective()
	{
		ini_set('memory_limit', '-1');
		$result     		= $this->content_model->get_by_all_prospectingdata();
	
		$arr = array();

		$k  = 0;
		$c 	= count($result);
        while($result)
        {
        	array_push($arr,[$result[$k]->id,
			$result[$k]->contributor_first_name,
			$result[$k]->contributor_last_name,
			$result[$k]->contributor_street_1,
			$result[$k]->contributor_city,
			$result[$k]->contributor_state,
			$result[$k]->contributor_zip,
			]);

			if($c-1==$k)
            {
                break;
            }
            $k++; 

        }
 		echo json_encode($arr);
		exit;
	}

	public function duplicate_data_liisting()
	{
		ini_set('memory_limit', '-1');
		$result     		= $this->content_model->get_by_all_duplicatedata();
		
		$arr = array();

		$k  = 0;
		$c 	= count($result);
        while($result)
        {
            array_push($arr,[$result[$k]->id,
			$result[$k]->contributor_first_name,
			$result[$k]->contributor_last_name,
			$result[$k]->contributor_street_1,
			$result[$k]->contributor_city,
			$result[$k]->contributor_state,
			$result[$k]->contributor_zip,
			]);
			if($c-1==$k)
			{
				break;
			}
			$k++; 

        }
 		echo json_encode($arr);
		exit;
	}

	public function duplicate_data_listing_housefile()
	{
		$result     		= $this->content_model->get_by_all_duplicatedata_housefile();
		$arr = array();
		foreach ($result as $key => $value) 
		{
            array_push($arr,[$value->id,
			$value->vFirstName,
			$value->vLastname,
			$value->vStreet,
			$value->vCity,
			$value->vState,
			$value->vZip,
			]);
		}
 		echo json_encode($arr);
		exit;
	}

	public function csv_download()
	{
		$result     		= $this->content_model->get_by_dublicatedata_hosefile();

        $data['data']     	= $result;
        $data['count']     	= count($result);
 		echo json_encode($data);
		exit;
	}

	public function without_duplicate_data_get()
	{
		ini_set('memory_limit', '-1');
		$result     		= $this->content_model->get_by_duplicate_data_not_get();
		$without_duplicate  = $this->content_model->get_by_dublicatedata_hosefile();

	    foreach($result as $key =>  $value)
		{
			$criatarea['vFirstName'] 	= $value->contributor_first_name;
			$criatarea['vLastname'] 	= $value->contributor_last_name;
			$criatarea['vStreet'] 		= $value->contributor_street_1;
			$criatarea['vCity']      	= $value->contributor_city;
			$criatarea['vState']		= $value->contributor_state;
			$criatarea['id']			= $value->id;
			
			$this->content_model->two_table_data_metch($criatarea);
		}

		if(count($result)=='0')
		{
			$data['Status']     = '0';
			
		}
		else
		{
			$data['Status']     = '1';
			$data['count']      = count($without_duplicate);
		}
 		echo json_encode($data);
		exit;
	}

	public function without_duplicate_data_get1()
	{
		ini_set('memory_limit', '-1');
		$result     		= $this->content_model->get_by_duplicate_data_not_get();
		$without_duplicate  = $this->content_model->get_by_dublicatedata_hosefile();

	    foreach($result as $key =>  $value)
		{
			$criatarea['vFirstName'] 	= $value->contributor_first_name;
			$criatarea['vLastname'] 	= $value->contributor_last_name;
			$criatarea['vStreet'] 		= $value->contributor_street_1;
			$criatarea['vCity']      	= $value->contributor_city;
			$criatarea['vState']		= $value->contributor_state;
			$criatarea['id']			= $value->id;
			
			$this->content_model->two_table_data_metch($criatarea);
		}

		if(count($result)=='0')
		{
			$data['Status']     = '0';
		}
		else
		{
			$data['Status']     = '1';
			$data['count']      = count($without_duplicate);
		}
 		echo json_encode($data);
		exit;
	}


	public function csv_upload()
	{	
		session_start();
		$link 		= mysqli_connect("localhost", "root", "", "csv_upload");
		// $link = new mysqli("localhost", "justcod1_root1", "d+SHY~8ALP{S", "justcod1_csv_upload");
		$query = "SELECT * FROM prospecting ORDER BY Id DESC LIMIT 1";
		$result = mysqli_query($link, $query);
		$row 	= mysqli_fetch_array($result);
		
		$iCsvFileId="";
		if(count($row)>0)
		{	
			$id="";
			$iCsvFileId="";
			$id = 1;
			$iCsvFileId = $row['iCsvId']+$id;
		}	
		else
		{
			$iCsvFileId="";
			$iCsvFileId = '1';
		}
		$_SESSION["iCsvId"] =   $iCsvFileId;
		// House File Last CSV get
		$qry 	= "SELECT * FROM house_file ORDER BY Id DESC LIMIT 1";
		$res = mysqli_query($link, $qry);
		$row_house 	= mysqli_fetch_array($res);
	
		$iCsvId="";
		if(count($row_house)>0)
		{	
			$id="";
			$iCsvId="";
			$id = 1;
			$iCsvId = $row_house['iCsvId']+$id;
		}	
		else
		{
			$iCsvId ="";
			$iCsvId = '1';
		}
		$_SESSION["iCsvId_house"] =   $iCsvId;

	    $tmp_name  	= $_FILES['image']['tmp_name'];
	    $name  		= $_FILES['image']['name'];
		$_SESSION["csv_name"] = $name;

	    $size  		= $_FILES['image']['size'];
		
		$action    	= $_POST['action'];
		$handle1    	= fopen($_FILES['image']['tmp_name'], 'r');
		$csvAsArray = array_map('str_getcsv', file($tmp_name));
		array_shift($csvAsArray);
	
		if($action=='action')
		{
				function file_get_contents_chunked($link, $file, $chunk_size, $queryValuePrefix, $callback)
				{
					try 
					{
						$handle = fopen($file, "r");
						$i = 0;
						while (! feof($handle)) {
							call_user_func_array($callback, array(
								fread($handle, $chunk_size),
								&$handle,
								$i,
								&$queryValuePrefix,
								$link
							));
							$i ++;
						}
						fclose($handle);
					} catch (Exception $e) {
						trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
						return false;
					}
					return true;
				}

				$link 		= mysqli_connect("localhost", "root", "", "csv_upload");
				$success 	= file_get_contents_chunked($link, $tmp_name, 2048,'', function ($chunk, &$handle, $iteration, &$queryValuePrefix, $link) {
				$TABLENAME 	= 'house_file';
				$chunk 		= $queryValuePrefix.$chunk;
			
				$lineArray = preg_split("/\r\n|\n|\r/", $chunk);
				$query = 'INSERT INTO ' . $TABLENAME.'(vFirstName, vLastname, vStreet,vCity,vState,vZip,iCsvId,vCsvName,vStartDate) VALUES ';
				$numberOfRecords = count($lineArray);
				$c = $numberOfRecords - 2;
				$iCsvId 	= $_SESSION["iCsvId_house"];
				$csv_name 	= $_SESSION["csv_name"];
				for ($i = 1; $i < $c; $i ++) 
				{	
					$colArray = explode(',',$lineArray[$i]);
					$query = $query.'("'.$colArray[0].'","'.$colArray[1].'","'.$colArray[2].'","'.$colArray[3].'","'.$colArray[4].'","'.$colArray[5].'","'.$iCsvId.'","'.$csv_name.'","'.date("Y-m-d").'"),';
				}

				$colArray = explode(',',$lineArray[$i]);

				$query = $query.'("'.$colArray[0].'","' .$colArray[1].'","'.$colArray[2].'","'.$colArray[3].'","'.$colArray[4].'","'.$colArray[5].'","'.$iCsvId.'","'.$csv_name.'","'.date("Y-m-d").'")';
				$i = $i + 1;

				$queryValuePrefix = $lineArray[$i];
				mysqli_query($link, $query) or die(mysqli_error($link));
				
				});

		}
		else
		{
			function file_get_contents_chunked($link, $file, $chunk_size, $queryValuePrefix, $callback)
			{
				try 
				{
					$handle = fopen($file, "r");
					$i = 0;
					while (! feof($handle)) {
						call_user_func_array($callback, array(
							fread($handle, $chunk_size),
							&$handle,
							$i,
							&$queryValuePrefix,
							$link
						));
						$i ++;
					}
					fclose($handle);
				} catch (Exception $e) {
					trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
					return false;
				}
				return true;
			}
				$link 		= mysqli_connect("localhost", "root", "", "csv_upload");
				
				$success 	= file_get_contents_chunked($link, $tmp_name, 2048,'', function ($chunk, &$handle, $iteration, &$queryValuePrefix, $link) {
				$TABLENAME 	= 'prospecting';
				$chunk 		= $queryValuePrefix.$chunk;
			
				$lineArray = preg_split("/\r\n|\n|\r/", $chunk);
				
				$query = 'INSERT INTO ' . $TABLENAME.'(contributor_first_name, contributor_last_name, contributor_street_1,contributor_city,contributor_state,contributor_zip,iCsvId,vCsvName,vStartDate) VALUES ';
				$numberOfRecords = count($lineArray);
				$c = $numberOfRecords-2;

				$iCsvFileId = $_SESSION["iCsvId"];
				$csv_name 	= $_SESSION["csv_name"];
				for ($i = 1; $i < $c; $i ++) 
				{	
					$colArray = explode(',',$lineArray[$i]);
					$query = $query.'("'.$colArray[0].'","'.$colArray[1].'","'.$colArray[2].'","'.$colArray[3].'","'.$colArray[4].'","'.$colArray[5].'","'.$iCsvFileId.'","'.$csv_name.'","'.date("Y-m-d").'"),';
					
				}

				$colArray = explode(',', $lineArray[$i]);
				$query = $query.'("'.$colArray[0].'","' .$colArray[1].'","'.$colArray[2].'","'.$colArray[3].'","'.$colArray[4].'","'.$colArray[5].'","'.$iCsvFileId.'","'.$csv_name.'","'.date("Y-m-d").'")';

				$i = $i + 1;
				$queryValuePrefix = $lineArray[$i];
				
				mysqli_query($link, $query) or die(mysqli_error($link));
				
				});
		}

		$data = array();
		$data['Status'] 		= '1';
		$data['message']  		= 'CSV Upload Successfully';
		echo json_encode($data);
		exit;
	}

	public function suffix_add()
	{
	
		$action              	= $_POST['Action'];
		if($action=='Action')
		{	
			$iSuffixAbbId 	= $_POST['iSuffixAbbId'];
			$vSuffixName    = $_POST['vSuffixName'];
			$vSuffixName    = explode(",",$vSuffixName);

			if($iSuffixAbbId=='')
			{
				for($i=0;$i<count($vSuffixName);$i++)
				{
					if(trim($vSuffixName[$i])!="")
					{
						$data['vSuffixName']              	= strtoupper(trim($vSuffixName[$i]));
						$data['vSuffixNameSort']            = strtoupper(trim($_POST['vSuffixNameSort']));
						$data['iSuffixId']              	= $_POST['iSuffixId'];
						$data['dtAddedDate']           		= date("Y-m-d h:i:s");
						$result   = $this->content_model->add_suffix($data);
					}
				}
				
				if($result)
				{
					$data = array();
					$data['Status'] 		= '0';
					$data['message']  		= 'Suffix Or Abbreviation Added Successfully';
				}
				else
				{
					$data = array();
					$data['Status'] 		= '1';
					$data['message']  		= 'Suffix Or Abbreviation Not Added Please Try!';
				}
			}
			else
			{

				$data['vSuffixName']          = strtoupper(trim($_POST['vSuffixName']));
				$data['vSuffixNameSort']      = strtoupper(trim($_POST['vSuffixNameSort']));
				$data['iSuffixId']            = $_POST['iSuffixId'];
			    
				$where = array('iSuffixAbbId'=>$iSuffixAbbId);

				$result   = $this->content_model->update_suffix($where,$data);
				if($result)
				{
					$data = array();
					$data['Status'] 		= '0';
					$data['message']  		= 'Suffix Abbreviation Updated Successfully';
				}
				else
				{
					$data = array();
					$data['Status'] 		= '0';
					$data['message']  		= 'Suffix Abbreviation Not Updated!';	
				}
			}
		}
		else
		{
			$data['vName']              	= $_POST['vName'];
			$data['dtAddedDate']            = date("Y-m-d h:i:s");
		
			$result   = $this->content_model->add($data);
			if($result)
			{
				$data = array();
				$data['Status'] 		= '0';
				$data['message']  		= 'Suffix Added Successfully';
			}
			else
			{
				$data = array();
				$data['Status'] 		= '1';
				$data['message']  		= 'Suffix Not Added Please Try!';
			}
		}
		echo json_encode($data);
		exit;
	}

	public function get_all_suffix()
	{
		$iSuffixAbbId   = $_GET['iSuffixAbbId'];
		$iSuffixId   	= $_POST['iSuffixId'];

		if($_SERVER['REQUEST_METHOD']=='GET' && $iSuffixAbbId!="")
		{
			$result     		= $this->content_model->get_by_single_suffix($iSuffixAbbId);
			if(count($result) > 0)
			{
				$data['Status']     = '1';
				$data['message']  	= 'Suffix Data Get Successfully';
				$data['data']       = $result;
			}
			else
			{
				$data['Status']     = '0';
				$data['message']  	= 'Data Not Found';
				$data['data']     	= array();
			}
		}
		else
		{
			if($iSuffixId!="")
			{
				$result_abb    		= $this->content_model->get_by_all_suffix_abb($iSuffixId);
				$SortName 			= array();
				foreach($result_abb as $value)
				{
					array_push($SortName , $value->vSuffixNameSort);
				}
				$SortName = array_unique($SortName);
				if(count($result_abb) > 0)
				{
					$data['Status']     = '0';
					$data['message']  	= 'Suffix Data Get Successfully';
					$data['data']       = $result_abb;
					$data['SortName']   = $SortName;
				}
				else
				{
					$data['Status']     = '1';
					$data['message']  	= 'Data Not Found';
					$data['data']     	= array();
				}
			}
			else
			{
				$result     		= $this->content_model->get_by_all_suffix();
				if(count($result) > 0)
				{
					$data['Status']     = '1';
					$data['message']  	= 'Suffix Data Get Successfully';
					$data['data']       = $result;
				}
				else
				{
					$data['Status']     = '0';
					$data['message']  	= 'Data Not Found';
					$data['data']     	= array();
				}
			}
		}
		echo json_encode($data);
		exit;
	}

	public function all_suffix_get()
	{
		$result     		= $this->content_model->get_by_all_suffixdata();

		if(count($result) > 0)
		{
			$data['Status']     = '1';
			$data['message']  	= 'Suffix Data Get Successfully';
			$data['data']       = $result;
			
		}
		else
		{
			$data['Status']     = '0';
			$data['message']  	= 'Data Not Found';
			$data['data']     	= array();
		}

		echo json_encode($data);
		exit;
	}

	public function delete_suffix()
	{
		$iSuffixAbbId  = $this->input->post('iSuffixAbbId');
	
		$id = $this->content_model->delete_by_id($iSuffixAbbId);
		
		$data['Status']     = '0';
		$data['message']  	= 'Suffix Abbreviation Deleted Successfully';
			
		echo json_encode($data);
	}

	public function replace_text_data()
	{
		
		$TotalReplace2  			= $this->login_model->get_by_update_data_hosefile();
		$TableName   				=  $_POST['TableName'];
		$SelecttextNumber           = $_POST['SelecttextNumber'];
		$last_id     				= $this->login_model->get_by_last_id();
		$suffix_match = array();
		if($TableName==1)
		{
			$criatarea 						= array();
			$criatarea['id'] 				= $last_id->iCsvId;
			$criatarea['table'] 			= $TableName;
			$criatarea['SelecttextNumber'] 	= $SelecttextNumber;
			$result   	= $this->login_model->get_by_all_data($criatarea);

			foreach($result as $value)
			{
				$street = "";
				$id		= "";
				$street = "";
				$street = preg_replace('!\s+!', ' ', $value->contributor_street_1);

				$id     = $value->id;
				$explode_data = explode(" ", $street);

				if(!empty($explode_data[$SelecttextNumber]))
				{
					$suffix2 = $this->login_model->get_by_all_text2($explode_data[$SelecttextNumber]);


					$name2 		= "";
					$sortname2 	= "";
					$code2 		= "";
					$name2 		= $suffix2->vSuffixName;
					$sortname2 	= $suffix2->vSuffixNameSort;
					if($name2!=$sortname2)
					{
						$replace2	= "";	
						$replace2 	= str_replace($name2,$sortname2,$street);
						$data2 		= array();
						$where2 	= array();	
						$where2 	= array('id' => $id);
						$data2['contributor_street_1'] = $replace2;
						$updateid = $this->login_model->update2($where2,$data2);
						$replace2="";
					}
				}
				$where6 				= array('id'=>$id);
				$data6['iReplaceId']  	= $SelecttextNumber;

				$result   = $this->login_model->update6($where6,$data6);
			}
			// ****************** json ***********
			$count_pros 		= $this->login_model->get_by_update_data();
			$last_prospectingid = $count_pros->iReplaceId;
			if ($last_prospectingid == $SelecttextNumber)
			{
				$data6['iReplaceId']  	= 'null';
				$this->login_model->update_data_null($data6);

				$data['Status']     	= '1';
			}
			else
			{
				$data['Status']     	= '0';
			}
			$data['message']  		= 'All Data Replace Successfully';
		}
		else if($TableName==2)
		{
			$criatarea 						= array();
			$criatarea['id'] 				= $last_id->iCsvId;
			$criatarea['table'] 			= $TableName;
			$criatarea['SelecttextNumber'] 	= $SelecttextNumber;
			$result   						= $this->login_model->get_by_all_data($criatarea);

		
			foreach($result as $value)
			{
				$street = "";
				$id		= "";
				$street = "";
				$street = preg_replace('!\s+!', ' ', $value->vStreet);

				

				$id     = $value->id;
				$explode_data = explode(" ",$street);

				if(!empty($explode_data[$SelecttextNumber]))
				{
					$suffix2 = $this->login_model->get_by_all_text2($explode_data[$SelecttextNumber]);
					$name2 		= "";
					$sortname2 	= "";
					$code2 		= "";
					$name2 		= $suffix2->vSuffixName;
					$sortname2 	= $suffix2->vSuffixNameSort;
				    
					if($name2!=$sortname2)
					{
						$replace2	= "";	
						$replace2 	= str_replace($name2,$sortname2,$street);
						$data2 		= array();
						$where2 	= array();	
						$where2 	= array('id' => $id);
						$data2['vStreet'] = $replace2;
						$updateid = $this->login_model->update_house_file($where2,$data2);
						$replace2="";
					}
					
				}
				$where6 				= array('id'=>$id);
				$data6['iReplaceId']  	= $SelecttextNumber;
				$result   = $this->login_model->update_house_file($where6,$data6);
			}
			$count_pros 		= $this->login_model->get_by_lastid_housefile();
			$last_prospectingid = $count_pros->iReplaceId;
			if ($last_prospectingid == $SelecttextNumber)
			{
				$data6['iReplaceId']  	= 'null';
				$this->login_model->update_data_null_housefile($data6);
				$data['Status']     	= '1';
			}
			else
			{
				$data['Status']     	= '0';
			}
			$data['message']  		= 'All Data nReplace Successfully';
		}
		echo json_encode($data);
		exit;
	}
	
	
	public function replace_text_data1()
	{

		$TotalReplace2  			= $this->login_model->get_by_update_data_hosefile();
		$TableName   				=  $_POST['TableName'];
		$SelecttextNumber           = $_POST['SelecttextNumber'];
		$last_id     				= $this->login_model->get_by_last_id();
		$suffix_match = array();
		if($TableName==1)
		{
			$criatarea = array();
			$criatarea['id'] 	= $last_id->iCsvId;
			$criatarea['table'] = $TableName;
			$criatarea['SelecttextNumber'] = $SelecttextNumber;
			$result   	= $this->login_model->get_by_all_data($criatarea);
	
			$p = array();

			foreach($result as $value)
			{
				$street = "";
				$id		= "";
				$street = "";
				$street = preg_replace('!\s+!', ' ', $value->contributor_street_1);

				$id     = $value->id;
				$explode_data = explode(" ", $street);
				if(!empty($explode_data[$SelecttextNumber]))
				{
					$suffix2 = $this->login_model->get_by_all_text2($explode_data[$SelecttextNumber]);

					$name2 		= "";
					$sortname2 	= "";
					$code2 		= "";
					$name2 		= $suffix2->vSuffixName;
					$sortname2 	= $suffix2->vSuffixNameSort;
				    
					if($name2!=$sortname2)
					{
						$replace2="";	
						$replace2 = str_replace($name2,$sortname2,$street);
						
						$data2 = array();
						$where2 = array();	
						$where2 = array('id' => $id);
						$data2['contributor_street_1'] = $replace2;

						$updateid = $this->login_model->update2($where2,$data2);
						$replace2="";
					}
				}
				$where6 				= array('id'=>$id);
				$data6['iReplaceId']  	= $SelecttextNumber;
				$result   = $this->login_model->update6($where6,$data6);
			}

			// ****************** json ***********
			$count_pros = $this->login_model->get_by_update_data();
			$last_prospectingid = $count_pros->iReplaceId;
		
			if ($last_prospectingid == $SelecttextNumber)
			{
				$data['Status']     	= '1';
			}
			else
			{
				$data['Status']     	= '0';
			}
			$data['message']  		= 'All Data Replace Successfully';

		}
		else if($TableName==2)
		{
			$criatarea 						= array();
			$criatarea['id'] 				= $last_id->iCsvId;
			$criatarea['table'] 			= $TableName;
			$criatarea['SelecttextNumber'] 	= $SelecttextNumber;
			$result   						= $this->login_model->get_by_all_data($criatarea);
			foreach($result as $value)
			{
				$street = "";
				$id		= "";
				$street = "";
				$street = preg_replace('!\s+!', ' ', $value->vStreet);
				
				$id     = $value->id;
				$explode_data = explode(" ",$street);

				if(!empty($explode_data[$SelecttextNumber]))
				{
					$suffix2 = $this->login_model->get_by_all_text2($explode_data[$SelecttextNumber]);
					$name2 		= "";
					$sortname2 	= "";
					$code2 		= "";
					$name2 		= $suffix2->vSuffixName;
					$sortname2 	= $suffix2->vSuffixNameSort;
				    
					if($name2!=$sortname2)
					{
						$replace2	= "";	
						$replace2 	= str_replace($name2,$sortname2,$street);
						$data2 		= array();
						$where2 	= array();	
						$where2 	= array('id' => $id);
						$data2['vStreet'] = $replace2;

						$updateid = $this->login_model->update_house_file($where2,$data2);
						$replace2="";
					}
				}
				$where6 				= array('id'=>$id);
				$data6['iReplaceId']  	= $SelecttextNumber;
				$result   = $this->login_model->update_house_file($where6,$data6);
			}
		
			$count_pros 		= $this->login_model->get_by_lastid_housefile();
			$last_prospectingid = $count_pros->iReplaceId;
		
			if ($last_prospectingid == $SelecttextNumber)
			{
				$data['Status']     	= '1';
			}
			else
			{
				$data['Status']     	= '0';
			}
			$data['message']  		= 'All Data Replace Successfully';
		}
		echo json_encode($data);
		exit;
	}

	function date_wise_csv_search()
	{
		$StartDate 		= $_POST['StartDate'];
		$EndDate 		= $_POST['EndDate'];
		$Table 			= $_POST['Table'];

		if($StartDate!="" || $EndDate!="")
		{
			$criteria = array();
			$criteria['StartDate']  = $StartDate;
			$criteria['Table']  	= $Table;
			if($EndDate!='undefined')
			{
				$criteria['EndDate'] = $EndDate;
			}
			
			$result  = $this->content_model->get_by_csv_data_date_wise($criteria);
			if(count($result) > 0)
			{
				$data['Status']     = '0';
				$data['message']  	= 'Data Search Successfully';
				$data['data']       = $result;
				echo json_encode($data);
				exit;
				
			}
		}
	}

	public function delete_csv_file()
	{
		$iCsvId  = $this->input->post('iCsvId');
		$iTable  = $this->input->post('iTable');
		if($iTable=='1')
		{
			$id = $this->content_model->delete_by_csv_file($iCsvId);
		}
		else
		{
			$id = $this->content_model->delete_by_house_file($iCsvId);
		}
		$data['Status']     = '0';
		$data['message']  	= 'Csv File Data Deleted Successfully';
		echo json_encode($data);
	}

	public function replace_text_data_copy_re_used()
	{	
		$suffixname1  				=  " ".$_POST['iSuffixId'];
		$suffixname2  				=  " ".$_POST['vSuffixName'];
		$vSuffixSort   				=  $_POST['vSuffixSort'];
		$TableName   				=  $_POST['TableName'];
		$ColName       			    =  $_POST['ColName'];
		if($TableName=='1')
		{
			$data['iSuffix_name']   = $_POST['iSuffixId'];
			$data['iSuffix_abb']   	= $_POST['vSuffixName'];
			$data['ColName']   		= $_POST['ColName'];

			$result     		= $this->login_model->get_by_replace_data($data);

			foreach($result as $value)
			{
				if($ColName=='contributor_first_name')
				{
					$contributor_first_name = $value->contributor_first_name;
					$replace_text  = str_replace($suffixname1,$vSuffixSort,$contributor_first_name);
				    $replace_text2  = str_replace($suffixname2,$vSuffixSort,$replace_text);
					$datas['contributor_first_name'] = $replace_text2;
					$datas['vUpdate'] = '1';

				}
				else if($ColName=='contributor_last_name')
				{
					$contributor_last_name = $value->contributor_last_name;
					$replace_text  = str_replace($suffixname1,$vSuffixSort,$contributor_last_name);
				    $replace_text2  = str_replace($suffixname2,$vSuffixSort,$replace_text);
					$datas['contributor_last_name'] = $replace_text2;
					$datas['vUpdate'] = '2';
				}
				else if($ColName=='contributor_street_1')
				{
					$contributor_street_1 = $value->contributor_street_1;
					$replace_text  = str_replace($suffixname1,$vSuffixSort,$contributor_street_1);
				    $replace_text2  = str_replace($suffixname2,$vSuffixSort,$replace_text);
					$datas['contributor_street_1'] = $replace_text2;
					$datas['vUpdate'] = '3';
				}
				else if($ColName=='contributor_city')
				{
					$contributor_city  = $value->contributor_city;
					$replace_text  = str_replace($suffixname1,$vSuffixSort,$contributor_city);
				    $replace_text2  = str_replace($suffixname2,$vSuffixSort,$replace_text);
					$datas['contributor_city'] = $replace_text2;
					$datas['vUpdate'] = '4';
				}
				else if($ColName=='contributor_state')
				{
					$contributor_state = $value->contributor_state;
					$replace_text  = str_replace($suffixname1,$vSuffixSort,$contributor_state);
				    $replace_text2  = str_replace($suffixname2,$vSuffixSort,$replace_text);
					$datas['contributor_state'] = $replace_text2;
					$datas['vUpdate'] = '5';
				}
				$id  = $value->id;
				$where = array('id'=>$id);
				$result   = $this->login_model->update($where,$datas);
			}
		}
		
		$data_json['Status']     	= '0';
		$data_json['message']  		= $data['ColName'].' data Replace Successfully';
		$data_json['data']     		= $this->login_model->get_by_replace_data($data);

		echo json_encode($data_json);
		exit;

	}

	public function csv_dublicate_data()
	{
		ini_set('memory_limit', '-1');
		$arr = array();
		$result     		= $this->content_model->get_by_get_dublicate_data();
		
		$k  = 0;
		$c 	= count($result);
        while($result)
        {
        	array_push($arr,[$result[$k]->id,
			$result[$k]->contributor_first_name,
			$result[$k]->contributor_last_name,
			$result[$k]->contributor_street_1,
			$result[$k]->contributor_city,
			$result[$k]->contributor_state,
			$result[$k]->contributor_zip,
			]);

			if($c-1==$k)
            {
                break;
            }
            $k++; 
        }
 		echo json_encode($arr);
		exit;
	}


	public function json_upload()
	{	
		session_start();
		$link 		= mysqli_connect("localhost", "root", "", "ios_databse");
	
	    $tmp_name  	= $_FILES['image']['tmp_name'];
	    $name  		= $_FILES['image']['name'];
	
	    $size  		= $_FILES['image']['size'];
		
		$action    	= $_POST['action'];
		$handle1    	= fopen($_FILES['image']['tmp_name'], 'r');
		$csvAsArray = array_map('str_getcsv', file($tmp_name));
		array_shift($csvAsArray);

		$data = array();
		$data['Status'] 		= '1';
		$data['message']  		= 'CSV Upload Successfully';
		echo json_encode($data);
		exit;
	}


	
	// public function csv_upload()
	// {	
	//     $tmp_name  	= $_FILES['image']['tmp_name'];
	// 	$action    	= $_POST['action'];
	// 	$handle    	= fopen($_FILES['image']['tmp_name'], 'r');
	// 	$csvAsArray = array_map('str_getcsv', file($tmp_name));
	// 	array_shift($csvAsArray);


	// 	if($action=='action')
	// 	{
	// 		$i = 0;
	// 		while($csvAsArray) 
	// 		{
	// 			if(!empty($csvAsArray[$i][2]) && !empty($csvAsArray[$i][3]) && !empty($csvAsArray[$i][4]))
	// 			{
	// 				$criteria['vStreet']      	 		= $csvAsArray[$i][2];
	// 				$criteria['vCity']    	 			= $csvAsArray[$i][3];
	// 				$criteria['vState']    	 			= $csvAsArray[$i][4];

	// 				$result   = $this->content_model->get_by_id($criteria);
		
	// 				if($result > 0)
	// 				{
	// 					$csc_data1 = array();
	// 					$csc_data1['vFirstName']         	= $csvAsArray[$i][0];
	// 					$csc_data1['vLastname']          	= $csvAsArray[$i][1];
	// 					$csc_data1['vStreet']      	 		= $csvAsArray[$i][2];
	// 					$csc_data1['vCity']    	 			= $csvAsArray[$i][3];
	// 					$csc_data1['vState']    	 		= $csvAsArray[$i][4];
	// 					$csc_data1['vZip']    			 	= $csvAsArray[$i][5];
							
	// 					$id1 = $this->login_model->house_data_dublicate($csc_data1);
	// 				}
	// 				else if($result==0)
	// 				{
	// 					$csc_data = array();
	// 					$csc_data['vFirstName']         	= $csvAsArray[$i][0];
	// 					$csc_data['vLastname']          	= $csvAsArray[$i][1];
	// 					$csc_data['vStreet']      	 		= $csvAsArray[$i][2];
	// 					$csc_data['vCity']    	 			= $csvAsArray[$i][3];
	// 					$csc_data['vState']    	 			= $csvAsArray[$i][4];
	// 					$csc_data['vZip']    			 	= $csvAsArray[$i][5];
						
	// 					$id = $this->login_model->house_data_add($csc_data);
		
	// 				}
	// 			}
	// 			$i++;
	// 		}

	// 		$data['Status']       = '1';
	// 		$data['message']  	= 'CSV Upload Successfully';
	// 		echo json_encode($data);
	// 		exit;
	// 	}
	// 	else
	// 	{
	// 		$j = 0;
	// 		while($csvAsArray)
	// 		{
	// 			if(!empty($csvAsArray[$j][2]) && !empty($csvAsArray[$j][3]) && !empty($csvAsArray[$j][4]))
	// 			{
	// 				$criteria['vStreet']      	 		= $csvAsArray[$j][2];
	// 				$criteria['vCity']    	 			= $csvAsArray[$j][3];
	// 				$criteria['vState']    	 			= $csvAsArray[$j][4];

	// 				$result   = $this->content_model->get_by_id_dub($criteria);
					
	// 				if($result > 0)
	// 				{
	// 					$csc_data = array();
	// 					$csc_data['contributor_first_name']      	= $csvAsArray[$j][0];
	// 					$csc_data['contributor_last_name']         	= $csvAsArray[$j][1];
	// 					$csc_data['contributor_street_1']      		= $csvAsArray[$j][2];
	// 					$csc_data['contributor_city']    	 		= $csvAsArray[$j][3];
	// 					$csc_data['contributor_state']    	 		= $csvAsArray[$j][4];
	// 					$csc_data['contributor_zip']    	 		= $csvAsArray[$j][5];

	// 					$id = $this->login_model->prospecting_data_add_dub($csc_data);
	// 				}
	// 				else if($result==0)
	// 				{
	// 					$csc_data1 = array();
	// 					$csc_data1['contributor_first_name']      	= $csvAsArray[$j][0];
	// 					$csc_data1['contributor_last_name']         = $csvAsArray[$j][1];
	// 					$csc_data1['contributor_street_1']      	= $csvAsArray[$j][2];
	// 					$csc_data1['contributor_city']    	 		= $csvAsArray[$j][3];
	// 					$csc_data1['contributor_state']    	 		= $csvAsArray[$j][4];
	// 					$csc_data1['contributor_zip']    	 		= $csvAsArray[$j][5];

	// 					$id2 = $this->login_model->prospecting_data_add($csc_data1);
	// 				}
	// 			}
	// 			$j++;
	// 		}
	// 		$data['Status']       = '1';
	// 		$data['message']  	= 'CSV Upload Successfully';
	// 		echo json_encode($data);
	// 		exit;
			
	// 	}	
	// }

	// public function replace_text_data1()
	// {
	
	// 	$TotalReplace2  	= $this->login_model->get_by_update_data_hosefile();

	// 	$TableName   				=  $_POST['TableName'];

	// 	$last_id     				= $this->login_model->get_by_last_id();
	// 	$suffix_match = array();
	// 	if($TableName==1)
	// 	{
	// 		$criatarea = array();
	// 		$criatarea['id'] 	= $last_id->iCsvId;
	// 		$criatarea['table'] = $TableName;
	// 		$result   	= $this->login_model->get_by_all_data($criatarea);
	
	// 		$p = array();

	// 		foreach($result as $value)
	// 		{
	// 			$street = "";
	// 			$id		= "";
	// 			$street = "";
	// 			$street = $value->contributor_street_1;
	// 			$id     = $value->id;
	// 			$explode_data = explode(" ", $street);

	// 			if(!empty($explode_data[0]))
	// 			{
	// 				$suffix0 = $this->login_model->get_by_all_text0($explode_data[0]);

	// 				$name 		= "";
	// 				$sortname 	= "";
	// 				$code 		= "";
	// 				$name 		= $suffix0['data']->vSuffixName;
	// 				$sortname 	= $suffix0['data']->vSuffixNameSort;
	// 				$code 		= $suffix0['status'];
					
	// 				if($code==01)
	// 				{
	// 					if($name!=$sortname)
	// 					{
	// 						$replace="";
	// 						$replace = str_replace($name,$sortname,$street);
							
	// 						$data0 		= array();
	// 						$where0 	= array('id'=>$id);
	// 						$data0['contributor_street_1'] 	= $replace;
	// 						$this->login_model->update0($where0,$data0);
	// 					}
	// 				}
	// 			}

	// 			if(!empty($explode_data[1]))
	// 			{
	// 				$suffix1 = $this->login_model->get_by_all_text1($explode_data[1]);
	// 				$name1 		= "";
	// 				$sortname1 	= "";
	// 				$code1 		= "";
	// 				$name1 		= $suffix1['data']->vSuffixName;
	// 				$sortname1 	= $suffix1['data']->vSuffixNameSort;
	// 				$code1 		= $suffix1['status'];

	// 				if($code1=='11')
	// 				{
	// 					if($name1!=$sortname1)
	// 					{
	// 						$replace1 = str_replace($name1,$sortname1,$street);
	// 						$data1 = array();
	// 						$where1 = array('id'=>$id);
	// 						$data1['contributor_street_1'] = $replace1;
	// 						$this->login_model->update1($where1,$data1);
	// 						$replace1="";
	// 					}
	// 				}
	// 			}

	// 			if(!empty($explode_data[2]))
	// 			{
	// 				$suffix2 = $this->login_model->get_by_all_text2($explode_data[2]);

	// 				$name2 		= "";
	// 				$sortname2 	= "";
	// 				$code2 		= "";
	// 				$name2 		= $suffix2['data']->vSuffixName;
	// 				$sortname2 	= $suffix2['data']->vSuffixNameSort;
	// 			    $code2 		= $suffix2['status'];
				
	// 				if($code2==21)
	// 				{	
	// 					if($name2!=$sortname2)
	// 					{
	// 						$replace2="";	
	// 						$replace2 = str_replace($name2,$sortname2,$street);
							
	// 						$data2 = array();
	// 						$where2 = array();	
	// 						$where2 = array('id' => $id);
	// 						$data2['contributor_street_1'] = $replace2;
	// 						$updateid = $this->login_model->update2($where2,$data2);
	// 						$replace2="";
	// 					}
	// 				}
	// 			}

	// 			if(!empty($explode_data[3]))
	// 			{
	// 				$suffix3 = $this->login_model->get_by_all_text3($explode_data[3]);

	// 				$name3 		= "";
	// 				$sortname3 	= "";
	// 				$code3 		= "";
	// 				$name3 		= $suffix3['data']->vSuffixName;
	// 				$sortname3 	= $suffix3['data']->vSuffixNameSort;
	// 				$code3 		= $suffix3['status'];

	// 				if($code3=='31')
	// 				{	
	// 					if($name3!=$sortname3)
	// 					{
	// 						$replace3 = str_replace($name3,$sortname3,$street);
	// 						$data3 = array();	
	// 						$where3 = array('id'=>$id);
	// 						$data3['contributor_street_1'] = $replace3;
	// 						$this->login_model->update3($where3,$data3);
	// 						$replace3="";
	// 					}
	// 				}
					
	// 			}

	// 			if(!empty($explode_data[4]))
	// 			{
	// 				$suffix4 = $this->login_model->get_by_all_text4($explode_data[4]);
	// 				$name4 		= "";
	// 				$sortname4 	= "";
	// 				$code4 		= "";
	// 				$name4 		= $suffix4['data']->vSuffixName;
	// 				$sortname4 	= $suffix4['data']->vSuffixNameSort;
	// 				$code4 		= $suffix4['status'];

	// 				if($code4=='41')
	// 				{
	// 					if($name4!=$sortname4)
	// 					{
	// 						$replace4 = str_replace($name4,$sortname4,$street);
	// 						$data4 = array();	
	// 						$where4 = array('id'=>$id);
	// 						$data4['contributor_street_1'] = $replace4;
	// 						$this->login_model->update4($where4,$data4);
	// 						$replace="";
	// 					}
	// 				}
	// 			}
				
	// 			if(!empty($explode_data[5]))
	// 			{
	// 				$suffix5 = $this->login_model->get_by_all_text5($explode_data[5]);

	// 				$name5 		= "";
	// 				$sortname5 	= "";
	// 				$code5 		= "";
	// 				$name5 		= $suffix5['data']->vSuffixName;
	// 				$sortname5 	= $suffix5['data']->vSuffixNameSort;
	// 				$code5 		= $suffix5['status'];

	// 				if($code5=='51')
	// 				{
	// 					if($name5!=$sortname5)
	// 					{
	// 						$replace5 	= str_replace($name5,$sortname5,$street);
	// 						$data5 		= array();	
	// 						$where5 		= array('id'=>$id);
	// 						$data5['contributor_street_1'] 	= $replace5;
	// 						$this->login_model->update5($where5,$data5);
	// 						$replace="";
	// 					}
	// 				}
	// 			}

	// 			$where6 				= array('id'=>$id);
	// 			$data6['iReplaceId']  	= '0';
	// 			$result   = $this->login_model->update6($where6,$data6);
				
	// 		}
	// 		// ****************** json ***********
	// 		$count_pros = $this->login_model->get_by_update_data();
	// 		$last_prospectingid = $count_pros->iReplaceId;
		
	// 		if ($last_prospectingid=='1')
	// 		{
	// 			$data['Status']     	= '1';
	// 		}
	// 		else
	// 		{
	// 			$data['Status']     	= '0';
	// 		}
	// 		// $data['count_pros']  	= $count_pros;
	// 		$data['message']  		= 'All Data Replace Successfully';

	// 	}
	// 	else if($TableName==2)
	// 	{
	// 		$criatarea 			= array();
	// 		$criatarea['id'] 	= $last_id->iCsvId;
	// 		$criatarea['table'] = $TableName;
	// 		$result   			= $this->login_model->get_by_all_data($criatarea);
			
	// 		$p = array();
	// 		foreach($result as $value)
	// 		{
	// 			$street = "";
	// 			$id		= "";
	// 			$street = "";
	// 			$street = $value->vStreet;
	// 			$id     = $value->id;
	// 			$explode_data = explode(" ",$street);
	// 			$suffix = $this->login_model->get_by_all_suffix_housefile($explode_data);


				
	// 			$name 		= "";
	// 			$sortname 	= "";
	// 			$code 		= "";
	// 			$name 		= $suffix['data']->vSuffixName;
	// 			$sortname 	= $suffix['data']->vSuffixNameSort;
	//             $code 		= $suffix['status'];
	// 			if($code=='01')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace = str_replace($name,$sortname,$street);
	// 					$datas 	= array();
	// 					$where 	= array('id'=>$id);
	// 					$datas['vStreet'] 	= $replace;
	// 					$datas['vUpdate']   = $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='11')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace = str_replace($name,$sortname,$street);
	// 					$datas = array();
	// 					$where = array('id'=>$id);
	// 					$datas['vStreet']  = $replace;
	// 					$datas['vUpdate']  = $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='21')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace = str_replace($name,$sortname,$street);
	// 					$datas = array();	
	// 					$where = array('id'=>$id);
	// 					$datas['vStreet']  = $replace;
	// 					$datas['vUpdate']  = $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='31')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace = str_replace($name,$sortname,$street);
	// 					$datas = array();	
	// 					$where = array('id'=>$id);
	// 					$datas['vStreet']  = $replace;
	// 					$datas['vUpdate']  = $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='41')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace = str_replace($name,$sortname,$street);
	// 					$datas = array();	
	// 					$where = array('id'=>$id);
	// 					$datas['vStreet']  = $replace;
	// 					$datas['vUpdate']  = $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='51')
	// 			{
	// 				if($name!=$sortname)
	// 				{
	// 					$replace 	= str_replace($name,$sortname,$street);
	// 					$datas 		= array();	
	// 					$where 		= array('id'=>$id);
	// 					$datas['vStreet'] 	= $replace;
	// 					$datas['vUpdate']  	= $street;
	// 					$result   = $this->login_model->update_house_file($where,$datas);
	// 				}
	// 			}
	// 			else if($code=='00')
	// 			{
	// 				$where 	= array('id'=>$id);
	// 				$data_update['iReplaceId']  = '1';
	// 				$result   = $this->login_model->update_house_file($where,$data_update);
	// 			}
				
	// 		}

	// 		$count_pros = $this->login_model->get_by_update_data_hosefile();

	// 		if ($count_pros <= $TotalReplace2)
	// 		{
	// 			$data['Status']     	= '1';
	// 		}
	// 		else
	// 		{
	// 			$data['Status']     	= '0';
	// 		}

	// 		$data['replace_hose']   = $this->login_model->get_by_update_data_hosefile();
			
	// 		$data['message']  		= 'All Data Replace Successfully';

	// 	}

		

	// 	echo json_encode($data);
	// 	exit;

	// }

}