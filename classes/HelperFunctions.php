<?php


class HelperFunctionsPortfolio{

    

    function getAllTableData($table){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT * FROM " . $table,ARRAY_A);
	   return $data;
	}
	
	function getTableData($table , $id){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE id=" . $id,ARRAY_A);
	   return $data[0];
	}
	
	
	function isIdExisting($table, $id){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT id FROM " . $table . " WHERE id=" . $id,ARRAY_A);
	   if($data[0]['id']){
	      return true;
	   }else{
	      return false;
	   }
	}
	
	function getPostId($post_name){
	  global $wpdb;
	  $postID = $wpdb->get_results("SELECT ID FROM " . SHERKPORTFOLIOPOSTS . " WHERE post_name='$post_name'");
	  return $postID[0]->ID;
	}
	
	function submitPersonalPortfolio($post){
	   global $wpdb;
	   if(HelperFunctionsPortfolio::isIdExisting(SHERKPORTFOLIOPERSONAL,1)){
	      $wpdb->update( SHERKPORTFOLIOPERSONAL, array( 'name' => $post['name'],'photo' => $post['_screenshot'], 'skype' => $post['skype'],'ym' => $post['ym'], 'gmail' => $post['gmail'], 'email' => $post['email'], 'url_fb' => $post['url_fb'], 'url_twitter' => $post['url_twitter'], 'url_linkedin' => $post['url_linkedin'], 'skills' => $post['skills'], 'objective' => $post['objective']),array('id'=>$post['id']));

	   }else{
	      $wpdb->insert( SHERKPORTFOLIOPERSONAL,  array( 'name' => $post['name'],'photo' => $post['_screenshot'], 'skype' => $post['skype'],'ym' => $post['ym'], 'gmail' => $post['gmail'], 'email' => $post['email'], 'url_fb' => $post['url_fb'], 'url_twitter' => $post['url_twitter'], 'url_linkedin' => $post['url_linkedin'], 'skills' => $post['skills'], 'objective' => $post['objective']) );
	   }
	   
	   //HelperFunctionsPortfolio::submitPortfolioPage($post);
	}

	function submitPortfolioProject($post){
	   global $wpdb;
	   
	   if(HelperFunctionsPortfolio::isIdExisting(SHERKPORTFOLIOPROJECTS,$post['id'])){
	     
		 $wpdb->update( SHERKPORTFOLIOPROJECTS, array( 'name' => $post['name'],'url' => $post['url'], 'screenshot' => $post['_screenshot'],'description' => $post['description'], 'fromdate' => $post['fromdate'], 'todate' => $post['todate']),array('id'=>$post['id']));
		 
	   }else{
		 
		 $wpdb->insert( SHERKPORTFOLIOPROJECTS, array( 'name' => $post['name'],'url' => $post['url'], 'screenshot' => $post['_screenshot'],'description' => $post['description'], 'fromdate' => $post['fromdate'], 'todate' => $post['todate']) );
	   }
	   
	   //HelperFunctionsPortfolio::submitPortfolioPage($post);
	}
	
	function submitPortfolioPage($post){
	  $ID=HelperFunctionsPortfolio::getPostId('portfolio');
	  //$object_post=HelperFunctionsPortfolio::preparePortfolioPage($post);
	  
	  if($ID){
		//$object_post['ID']=$ID;
		//wp_update_post($object_post);
	  }else{
	    //wp_insert_post($object_post);
	  }
	}
	
	
	function preparePortfolioPage(){
	  $personalData=HelperFunctionsPortfolio::getTableData(SHERKPORTFOLIOPERSONAL,1);
	  $projectsData=HelperFunctionsPortfolio::getAllTableData(SHERKPORTFOLIOPROJECTS);
	  
      $content='<div id="portfolioproject" class="container">
		<div class="row">';
	 
	  $content.='<div class="col-md-4"><img align="left" valign="10" width="250" src="'.$personalData['photo'].'"/>';
	  
	  if($personalData['skills']){
	      $content.='<br/><div id="skills" class="personaldata"><span class="labels">Skills</span><br/>' . $personalData['skills'] . '</div>';
	  }
	  $content.='</div>';//col-md-4
	
	  if($personalData['name']){
	      $content.='<div class="personaldata col-md-8"><span id="name">' . ucwords($personalData['name']).'</span>';
	  }		   
	 
	  if($personalData['objective']){
	      $content.='<div id="objective" class="personaldata"><span class="labels">Objective</span><br/>' . $personalData['objective'] . '</div>';
	  }
	  
	  $content.='
			   <h2 class="titlelabel">Contacts:</h2>
			   <div id="email" class="personaldata"><span class="labels">Email Account: </span>' . $personalData['email'] . '</div>';
	  
	  if($personalData['skype']){
	      $content.='<div id="skype" class="personaldata"><span class="labels">Skype Account: </span>' . $personalData['skype'] . '</div>';
	  }
	  
	  if($personalData['ym']){
	      $content.='<div id="ym" class="personaldata"><span class="labels">Yahoo Messenger Account: </span>' . $personalData['ym'] . '</div>';
	  }
	  
	  if($personalData['gmail']){
	      $content.='<div id="gmail" class="personaldata"><span class="labels">GMail Account: </span>' . $personalData['gmail'] . '</div>';
	  }
	  
	  if($personalData['url_fb']){
	      $content.='<div id="url_fb" class="personaldata"><span class="labels">Facebook Account: </span>' . $personalData['url_fb'] . '</div>';
	  }
	  
	  if($personalData['url_twitter']){
	      $content.='<div id="url_twitter" class="personaldata"><span class="labels">Twitter Account: </span>' . $personalData['url_twitter'] . '</div>';
	  }
	  
	  if($personalData['url_linkedin']){
	      $content.='<div id="url_linkedin" class="personaldata"><span class="labels">LinkedIn Account: </span>' . $personalData['url_linkedin'] . '</div>';
	  }
	   $content.='</div></div>'; //row
	  $content.='<h2 class="titlelabel">Work Samples:</h2>
		<div id="sherky_portfolio" class="jprt-container container text-center">';
	      $projectrow=1;
		  $cntrow=0;
		  $sp_links='';
	  foreach($projectsData as $project){
	     $idrow='sp_link'.$projectrow. '_row';  
		 if($project['fromdate'] && $project['todate']){
		   $fromto=' -- <italic>'.$project['fromdate']. ' - ' . $project['todate'] . '</italic>';
		 }
	     $content.='
				<div class="jprt-item" data-tags="project" data-content-show="new_section">
					<div id="'.$idrow.'_item" class="jprt-caption">
						<img  width="280" src="'. $project['screenshot'] . '" class="proj_img">
						<p class="jprt-item-tags">'. $project['name'] . $fromto.'</p>
					</div>
					<div class="jprt-content">
						<div class="text-center">
							<div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
								<h2 class="custom-content-title">'. $project['name'] . '</h2>
								<p>' . $project['description'] .'</p>
							</div>
							<div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
								<img width="450" src="'. $project['screenshot'] . '" class="proj_img_in_cnt">
							</div>
						</div>
					</div>
					<div class="jprt-hover">
						<h1 class="jprt-item-title">'. $project['name'] . '</h1>
					</div>
				</div>';
	  }		
	  return $content . '</div>';
	}
	
	function sherk_redirect($location){
	  echo "<meta http-equiv='refresh' content='0;url=$location' />";
	}
	
	
	function uploadPhoto(){
	        
			if (!is_uploaded_file($_FILES['screenshot']['tmp_name']))
			{
			$error = "You did not upload a file!";
			// assign error message, remove uploaded file, redisplay form.
			}
			else
			{
			//A file was uploaded
			$maxfilesize=300000;
				if ($_FILES['screenshot']['size'] > $maxfilesize)
				{
					echo "File is too large.";
					// assign error message, remove uploaded file, redisplay form.
				} else if (!($_FILES['screenshot']['type'] =="image/jpeg" OR $_FILES['screenshot']['type'] =="image/gif")){
				     echo "Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";	
				}else{
				   $filename=SherkPortfolio::getBaseDir() . "/files/" . $_FILES['screenshot']['name'];
					 //File has passed all validation, copy it to the final destination and remove the temporary file:
			       if(move_uploaded_file ($_FILES['screenshot']['tmp_name'], $filename)){
				    return $_FILES['screenshot']['name'];   
				   }else{
				     echo "Photo is not uploaded successfully. Please contact the admin or upload again. Thanks!";
				   }
				}
			}
	}
	
	
} //end of the class
?>