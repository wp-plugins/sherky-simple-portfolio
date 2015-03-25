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
	      $wpdb->update( SHERKPORTFOLIOPERSONAL, array( 'name' => $post['name'], 'skype' => $post['skype'],'ym' => $post['ym'], 'gmail' => $post['gmail'], 'email' => $post['email'], 'url_fb' => $post['url_fb'], 'url_twitter' => $post['url_twitter'], 'url_linkedin' => $post['url_linkedin'], 'skills' => $post['skills'], 'objective' => $post['objective']),array('id'=>$post['id']));

	   }else{
	      $wpdb->insert( SHERKPORTFOLIOPERSONAL,  array( 'name' => $post['name'], 'skype' => $post['skype'],'ym' => $post['ym'], 'gmail' => $post['gmail'], 'email' => $post['email'], 'url_fb' => $post['url_fb'], 'url_twitter' => $post['url_twitter'], 'url_linkedin' => $post['url_linkedin'], 'skills' => $post['skills'], 'objective' => $post['objective']) );
	   }
	   
	   HelperFunctionsPortfolio::submitPortfolioPage($post);
	}

	function submitPortfolioProject($post){
	   global $wpdb;
	   
	   $uploaded=HelperFunctionsPortfolio::uploadPhoto();
	   $post['screenshot']=($uploaded)? $uploaded:$post['uploadphoto'];
	   
	   if(HelperFunctionsPortfolio::isIdExisting(SHERKPORTFOLIOPROJECTS,$post['id'])){
	     
		 $wpdb->update( SHERKPORTFOLIOPROJECTS, array( 'name' => $post['name'],'url' => $post['url'], 'screenshot' => $post['screenshot'],'description' => $post['description'], 'fromdate' => $post['fromdate'], 'todate' => $post['todate']),array('id'=>$post['id']));
		 
	   }else{
		 
		 $wpdb->insert( SHERKPORTFOLIOPROJECTS, array( 'name' => $post['name'],'url' => $post['url'], 'screenshot' => $post['screenshot'],'description' => $post['description'], 'fromdate' => $post['fromdate'], 'todate' => $post['todate']) );
	   }
	   
	   HelperFunctionsPortfolio::submitPortfolioPage($post);
	}
	
	function submitPortfolioPage($post){
	  $ID=HelperFunctionsPortfolio::getPostId('portfolio');
	  $object_post=HelperFunctionsPortfolio::preparePortfolioPage($post);
	  
	  if($ID){
		$object_post['ID']=$ID;
		wp_update_post($object_post);
	  }else{
	    wp_insert_post($object_post);
	  }
	}
	
	
	function preparePortfolioPage($post){
	  $personalData=HelperFunctionsPortfolio::getTableData(SHERKPORTFOLIOPERSONAL,1);
	  $projectsData=HelperFunctionsPortfolio::getAllTableData(SHERKPORTFOLIOPROJECTS);
	  
      $content='<link rel="stylesheet"   href="' .  WP_PLUGIN_URL . '/sherkportfolio/scripts/sherkportfolio.css" type="text/css" media="all" /><div id="portfolioproject">';
	  $content.='	
		<script>
			if (typeof jQuery == "undefined") {
				var script = document.createElement("script");
				script.type = "text/javascript";
				script.src = "'. bloginfo('stylesheet_directory').'/jquery.tabs/jquery-1.9.1.js";
				document.getElementsByTagName("head")[0].appendChild(script);
			}
		</script>';
	  
	  if($personalData['name']){
	      $content.='<div id="name" class="personaldata"><span class="labels">Name: </span>' . ucwords($personalData['name']) . '</div>';
	  }		   
	  if($personalData['skills']){
	      $content.='<div id="skills" class="personaldata"><span class="labels">Skills: </span>' . $personalData['skills'] . '</div>';
	  }
	  if($personalData['objective']){
	      $content.='<div id="objective" class="personaldata"><span class="labels">Objective: </span>' . $personalData['objective'] . '</div>';
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
	  
	  $content.='<h2 class="titlelabel">Work Samples:</h2><div id="projects"><table><tr>
	      <th>Screenshots</th><th>Projects</th></tr>';
	      $projectrow=1;
		  $cntrow=0;
		  $sp_links='';
	  foreach($projectsData as $project){
	     $idrow='sp_link'.$projectrow. '_row';  
	     if($cntrow<2){
			$cntrow+=1;
		 }else{
		    $sp_links.='<a id="sp_link'.$projectrow.'" class="sp_links">'.$projectrow.'</a>';
		    $projectrow+=1;
			$cntrow=0;
		 }
	  
	     $content.='<tr class="sp_rows '.$idrow.'"><td><a target="_blank"  href="'. $project['url'] . '">
		     <img width="150px"  src="'. WP_PLUGIN_URL.'/sherkportfolio/files/' . $project['screenshot'] . '"/></a></td><td><div class="projname"><span class="bold">Project Name: </span>'. $project['name'] . '</div><div class="projdesc"><span class="bold">Description:</span> ' . $project['description'] . '</div>';
		 if($project['fromdate'] && $project['todate']){
		   $content.='<br/><italic>'.$project['fromdate']. '****' . $project['todate'] . '</italic>';
		 }
		 $content.='</td></tr>';
	  }
	  
	  if($cntrow>0){
	    $sp_links.='<a id="sp_link'.$projectrow.'" class="sp_links">'.$projectrow.'</a>';
	  }
	       
	  $content.='</table></div><div id="div_sp_links">'.$sp_links.'</div><div style="clear:both"></div></div>';
	  
	  $content.='
		<script>
		    $(".sp_rows").hide();
			$(".sp_link1_row").show();
			$(".sp_link1").addClass("currentrow");
			$(".sp_links").click(function () {
				classrow="."+$(this).attr("id")+"_row";
				$(".sp_links").removeClass("currentrow");
				$(".sp_rows").hide();
				$(this).addClass("currentrow");
			    $(classrow).show(2000);
			});
		</script>';
	 
			
	  $object_post = array(
     'post_title' =>  ucwords($personalData['name']) . '\'s Portfolio',
	 'post_name' => 'portfolio',
     'post_content' => $content,
     'post_status' => 'publish',
	 'post_type' => 'page',
	 'comment_status' => 'closed',
     'post_author' => 1
     );
	  return $object_post;
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