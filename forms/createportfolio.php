<?php 
global $wpdb;

 echo '<style type="text/css" media=screen>';
         include SherkPortfolio::getBaseDir().'/scripts/sherkportfolio.css';
 echo '</style>';

if ($_POST['submit']){
  if($_POST['name'] && $_POST['email']){ //check if complete
	HelperFunctionsPortfolio::submitPersonalPortfolio($_POST);  
	$msg="<div style='color:green'>Portfolio is successfully updated/created.</div>";
  }else{ //missing data 
	$msg="<div style='color:red'>Some fields are missed to input values.</div>";
  }
  $txtData=$_POST;
}else{
  $txtData=HelperFunctionsPortfolio::getTableData(SHERKPORTFOLIOPERSONAL,1);
 
  /* if(!isset($txtData['photo'])){
    mysql_query('ALTER TABLE '. SHERKPORTFOLIOPERSONAL .' ADD photo String NOT NULL");
  }  */
}

?>

<div id="form-addclient">
<?php echo $msg; ?>
<h2>Personal Portfolio Details</h2>

<form name="personalportfolio" id="personalportfolio" method="POST" >
   <input type="hidden" name="id" value="<?php echo $txtData['id']; ?>" />
   <table>
      <tr>
	    <td class="labels">Photo:</td>
		<td class="fields"><input type="text" id="_screenshot" name="_screenshot" value="<?php echo $txtData['photo']; ?>" /><input type="button"  name="screenshot" id="screenshot"  value="Upload Photo" /></td>
	  </tr>
	  <tr>
	    <td class="labels">Name:</td><td class="fields"><input class="large-text" type="text" name="name" id="name" size="50" value="<?php echo $txtData['name']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Email:</td><td class="fields"><input class="large-text" type="text" name="email" id="email" size="50" value="<?php echo $txtData['email']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Skype Account:</td><td class="fields"><input class="large-text" type="text" name="skype" id="skype" size="50" value="<?php echo $txtData['skype']; ?>"/></td>
	  </tr>
	  
	  <tr>
	    <td class="labels">Yahoo Messenger Account:</td><td class="fields"><input class="large-text" type="text" name="ym" id="ym" size="50" value="<?php echo $txtData['ym']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">GoogleTalk Account:</td><td class="fields"><input class="large-text" type="text" name="gmail" id="gmail" size="50" value="<?php echo $txtData['gmail']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Facebook Personal Url Account:</td><td class="fields"><input class="large-text" type="text" name="url_fb" id="url_fb" size="50" value="<?php echo $txtData['url_fb']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">LinkedIn Url Account:</td><td class="fields"><input class="large-text" type="text" name="url_linkedin" id="url_linkedin" size="50" value="<?php echo $txtData['url_linkedin']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Twitter Url Account:</td><td class="fields"><input class="large-text" type="text" name="url_twitter" id="url_twitter" size="50" value="<?php echo $txtData['url_twitter']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Skills:</td><td class="fields"><textarea name="skills" rows="5" class="large-text"><?php echo $txtData['skills']; ?></textarea></td>
	  </tr>
	  <tr>
	    <td class="labels">Objective:</td><td class="fields">
		  <textarea name="objective" rows="5" class="large-text"><?php echo $txtData['objective']; ?></textarea>
		</td>
	  </tr>
	  <tr><td colspan=2 style="text-align:center"><input class="button button-primary button-large" type="submit" name="submit" value="Submit"/></td></tr>
   </table>
</form>
</div>





