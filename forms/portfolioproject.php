<?php 
global $wpdb;

 echo '<style type="text/css" media=screen>';
         include SherkPortfolio::getBaseDir().'/scripts/sherkportfolio.css';
 echo '</style>';

$action=$_GET['action'];
$edit_id=$_GET['id'];



if(($edit_id>0) && ($action=='edit')){ //edit mode
   $txtData=HelperFunctionsPortfolio::getTableData(SHERKPORTFOLIOPROJECTS,$edit_id);
   if($_POST['name'] && $_POST['description']){ //check if complete
	   HelperFunctionsPortfolio::submitPortfolioProject($_POST);
	   unset($txtData);
    }

}else if(($edit_id>0) && ($action=='delete')){
       $wpdb->query("DELETE FROM ". SHERKPORTFOLIOPROJECTS . " WHERE id =" . $edit_id);
       HelperFunctionsPortfolio::sherk_redirect('?page=portfolio_add_project');

} else { //Submit or add
    if($_POST['name'] && $_POST['description']){ //check if complete
	   HelperFunctionsPortfolio::submitPortfolioProject($_POST);   
	}else{ //missing data 
	   $txtData=$_POST;
	}
				
}

?>



<div id="form-addclient">
<?php if($edit_id>0){ ?>
<h2>Edit Project Details</h2>
<?php } else { ?>
<h2>Add New Project</h2>
<?php } ?>
<form name="addproject" id="addproject" method="POST" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?php echo $txtData['id']; ?>" />
   <table>
      <tr>
	    <td class="labels">Project Name:</td><td class="fields"><input type="text" name="name" id="name" size="50" value="<?php echo $txtData['name']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">URL link:</td><td class="fields"><input type="text" name="url" id="url" size="50" value="<?php echo $txtData['url']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Screenshot:</td><td class="fields"><?php if($txtData['screenshot']){?><img src="<?php echo WP_PLUGIN_URL."/sherkportfolio/files/" . $txtData['screenshot']; ?>" width="200px" /><?php } ?><br/><input type="file"  name="screenshot" id="screenshot" /><input type="hidden" name="uploadphoto" value="<?php echo $txtData['screenshot']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Description:</td><td class="fields"><textarea name="description" rows="5" cols="40"><?php echo $txtData['description']; ?></textarea></td>
	  </tr>
	  <tr>
	    <td class="labels">From Date:</td><td class="fields"><input type="text" name="fromdate" id="fromdate" size="35" value="<?php echo $txtData['fromdate']; ?>"/><a href="javascript:NewCal('fromdate','ddmmmyyyy')"><icon class="dashicons-calendar-alt dashicons"></icon></a></td>
	  </tr>
	  <tr>
	    <td class="labels">To Date:</td><td class="fields"><input type="text" name="todate" id="todate" size="35" value="<?php echo $txtData['todate']; ?>"/><a href="javascript:NewCal('todate','ddmmmyyyy')"><icon class="dashicons-calendar-alt dashicons"></icon></a></td>
	  </tr>
	  <tr><td colspan=2 style="text-align:center"><input type="submit" name="submit" value="Submit"/></td></tr>
   </table>
</form>

</div>


<div id="form-displayclients">
   <table >
     <tr>
	   <th>Id</th>
	   <th>Project Name</th>
	   <th>URL link</th>
	   <th>Screenshot</th>
	   <th>Description</th>
	   <th>Date</th>
	   <th>Action</th>
	 </tr>
  <?php 
    $records=HelperFunctionsPortfolio::getAllTableData(SHERKPORTFOLIOPROJECTS);
	if(count($records)>0){
    foreach($records as $data) {
  ?>
	 <tr>
	   <td><?php echo $data['id'] ?></td>
	   <td><?php echo $data['name'] ?></td>
	   <td><?php echo $data['url'] ?></td>
	   <td><img src="<?php echo WP_PLUGIN_URL."/sherkportfolio/files/" . $data['screenshot']; ?>" width="200px" /></td>
	   <td><?php echo $data['description'] ?></td>
	   <td><?php echo $data['fromdate'] . "-" . $data['todate']; ?></td>
	   <td><a href="?page=portfolio_add_project&action=edit&id=<?php echo $data['id'] ?>">Edit</a><a href="?page=portfolio_add_project&action=delete&id=<?php echo $data['id']?>">Delete</a></td>
	 </tr>
	<?php } }?>
   </table>
   
</div>


