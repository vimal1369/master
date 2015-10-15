<?php
/*
Plugin Name: Resender Form 
Plugin URI:  
Description: Resender Form
Author: Sharp Web Technologies
Author URI:  
*/
  mysql_connect('localhost','unimafc105_del','Delivery123');
  mysql_select_db('unimafc105_delivery'); 
add_action('admin_menu', 'rs_add_pages');
add_action('admin_menu', 'rs_add_sub_pages');
define('dataload', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
 function admin_resender_head() {
    $siteurl = get_option('siteurl');
    $styleurl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/adminstyles.css';    
    echo "<link rel='stylesheet' type='text/css' href='$styleurl' />\n";
	$scripturl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery.js';
    echo "<script src='$scripturl' type='text/javascript'> </script>";
}
global $wpdb;
add_action('admin_menu', 'admin_resender_head'); 
add_action('wp_print_styles', 'admin_resender_head'); 
function rs_add_pages() {    
	global $wpdb;
    add_menu_page(__('Resender Form','resender-form'), __('Resender Form','resender-form'), 'manage_options', 'rs-top-level-handle', 'rs_toplevel_page' );
	$qry="create table IF NOT EXISTS resender_feature(featureid int(11) auto_increment primary key, countryid varchar(255), basicsystem varchar (100), separatestand varchar (100), addinstall varchar (100), optionnewspaper varchar (100), isolatedhousing varchar (100), colorhousing varchar (100), enlargementmailbox varchar (100), vatcharges varchar (100), oneoffcontribute varchar(100) , preorderfees varchar (100), monthlysub varchar (100) ) ;";
	$wpdb->query($qry);	
	$qrycreate="create table IF NOT EXISTS user_info(userinfoid int(11) auto_increment primary key, countryid varchar(255), basicsystem varchar (100), separatestand varchar (100), addinstall varchar (100), optionnewspaper varchar (100), isolatedhousing varchar (100), colorhousing varchar (100), enlargementmailbox varchar (100), totaloption varchar (100), vatcharges varchar (100), oneoffcontribute varchar(100) ,  totalsystem varchar (100) ,preorderfees varchar (100), monthlysub varchar (100) , newsletter varchar (100) , firstname varchar(200), lastname varchar(200) , phone varchar(50), email varchar(200), address varchar(255), zipcode varchar(100) ) ;";
	$wpdb->query($qrycreate);	
}
function rs_add_sub_pages(){
   add_submenu_page('rs-top-level-handle', __('View Features','resender-form'), __('View Features','resender-form'),'manage_options', 'rs-top-viewfeatures-handle', 'view_feature' );
   add_submenu_page('rs-top-level-handle', __('Add Features','resender-form'), __('Add Features','resender-form'), 'manage_options', 'rs-top-addfeatures-handle', 'add_features' );
  add_submenu_page('null', __('','resender-form'), __('','resender-form'), 'manage_options', 'rs-top-editfeatures-handle', 'edit_feature');
  add_submenu_page('null', __('','resender-form'), __('','resender-form'), 'manage_options', 'rs-top-formfeatures-handle', 'info_form');    
add_submenu_page('null', __('','resender-form'), __('','resender-form'), 'manage_options', 'rs-top-formfeatures-handle', 'resender_view_form');    
}
function rs_toplevel_page() {			
}
function add_features() {
?>
<!-- ADD Features Country Wise start-->
<div class="addfeatures">
  <h2> Add Features </h2>
  <form method="post" action="">
  
    <div class="form-group">
      <label> Choose Service Page </label>
      <select name="servicepage" required>
  <option value="">Select service page</option>
  <option value="consumer">Consumer</option>
  <option value="webshop">Webshop</option>
  <option value="courier">Courier</option>
  <option value="company">Company or Institution</option>
		
      </select>
    </div>
    <div class="form-group">
      <label> Choose Country </label>
      <select name="addcountry">
        <?php	
            global $wpdb;
				$myrow = $wpdb->get_results('SELECT * FROM countries');  			 			    
			 foreach($myrow as $row) { echo "<option value=$row->countryid> $row->countryname </option> ";}	
				?>
      </select>
    </div>
    <div class="form-group">
      <label>Resender Basic System (DIY) Do it Yourself	</label> 
      <input type="text" name="basicsystem" required/>
    </div>
	  <div class="form-group">
      <label>App Dashboard</label> 
      <input type="text" name="appdashboard" required/>
    </div>
    <div class="form-group">
      <label>Separate Outsite Stand</label>
      <input type="text" name="separatestand" required/>
    </div>
    <div class="form-group">
      <label>Installation Basic system by us	</label>
      <input type="text" name="addinstall" required/>
    </div>
    <div class="form-group">
      <label>Newspaper option</label>
      <input type="text" name="optionnewspaper" required/>
    </div>
    <div class="form-group">
      <label>Isolated Housing</label>
      <input type="text" name="isolatedhousing" required/>
    </div>
    <div class="form-group">
      <label>Colour of your personal choice</label>
      <input type="text" name="colorhousing" required/>
    </div>
	 <div class="form-group">	
<label>Housing print option</label>
      <input type="text" name="housingprint" required/>
    </div>
    <div class="form-group">
      <label>Enlargement Piece Mailbox</label>
      <input type="text" name="enlargementmailbox" required/>
    </div>
    <div class="form-group">
      <label>Vat Charges</label>
      <input type="text" name="vatcharges" required/>
    </div>
    <div class="form-group">
      <label>One Off Contriburion</label>
      <input type="text" name="oneoffcontribute" required/>
    </div>
    <div class="form-group">
      <label>Pre Order Fees</label>
      <input type="text" name="preorderfees" required/>
    </div>
    <div class="form-group">
      <label>Monthly Subscriptions</label>
      <input type="text" name="monthlysub" required/>
    </div>
    <div class="form-group">
      <label> </label>
      <input type="submit" name="addfeatures" value="Add"/>
    </div>
  </form>
</div>
<?php 
   if(isset ($_POST["addfeatures"]))
   {
   $addservicepage=$_POST["servicepage"];
   $addcountry=$_POST["addcountry"];
   $basicsystem=$_POST["basicsystem"];
   $separatestand=$_POST["separatestand"];
   $addinstall=$_POST["addinstall"];
   $optionnewspaper=$_POST["optionnewspaper"];
   $isolatedhousing=$_POST["isolatedhousing"];
   $colorhousing=$_POST["colorhousing"];
   $enlargementmailbox=$_POST["enlargementmailbox"];
   $vatcharges=$_POST["vatcharges"];
   $oneoffcontribute=$_POST["oneoffcontribute"];
   $preorderfees=$_POST["preorderfees"];
   $monthlysub=$_POST["monthlysub"];
   $appdashboard=$_POST["appdashboard"];
   $housingprint=$_POST["housingprint"];
   global $wpdb;
   $myrow1=$wpdb->query("select countryid, servicepage from resender_feature where countryid='$addcountry' AND servicepage='$addservicepage'");
     if($myrow1>0) {     echo"<div class='errormsg'><p> Country Name already exists </p></div>"; 	
      }
   else { $myrow = $wpdb->query("insert into resender_feature(servicepage, countryid , basicsystem, separatestand, addinstall, optionnewspaper, isolatedhousing ,colorhousing, enlargementmailbox , vatcharges , oneoffcontribute, preorderfees , monthlysub, appdashboard, housingprint ) values ('$addservicepage', '$addcountry' , '$basicsystem','$separatestand' ,'$addinstall' ,'$optionnewspaper' ,'$isolatedhousing' ,'$colorhousing','$enlargementmailbox' , $vatcharges ,$oneoffcontribute, $preorderfees , $monthlysub, $appdashboard, $housingprint)");  
   if($myrow>0)
		{ echo"<div class='updatedmsg'><p> Data saved successfully </p></div>"; }
   else   { echo"<div class='errormsg'><p> Data is not saved </p></div>"; } }
   }    
}
function view_feature(){
 ?>
<!-- View  Features Country Wise End-->
<div class="viewfeatures">
  <h2> View Features </h2>
  <form method="post" action="">
    <?php 
    global $wpdb;
      $myrows= $wpdb->get_results("select resender_feature.* , countries.countryname , countries.symbol   from resender_feature 
			 inner join  countries  on resender_feature.countryid=countries.countryid WHERE servicepage='consumer'");
            
			 
			if($myrows>0)
			{	 echo "<table><tr class='resender_pageheading'><h1>Consumer Page</h1></tr> <tr> 		
			<td> Sr No.   </td>
			<td> Country  </td>
			<td> Resender Basic System (DIY) Do it Yourself </td>
			<td>App Dashboard</td>
			<td> Separate Stand  </td>
			<td>  Installation Fees  </td>
			<td> Newspaper option   </td>
			<td> Isolated Housing  </td>
			<td> Colour of your personal choice</td>
			<td> Housing Print Option</td>
			<td> Enlargement Mailbox</td>
			<td>Vat Charges</td>
			<td>One Off Contribute</td>
			<td>Pre Order Fees</td>
			<td>Monthly Subscriptions</td>
			<td>Edit</td>
			<td>Delete</td>
			</tr>";	
		
                $i=1;
        foreach($myrows as $row) 
        {
              $editid= $row->featureid ;
			   echo "<tr>
				<td> $i  </td>
			   <td> $row->countryname  </td>
			   <td>  $row->basicsystem </td>
			   <td> $row->appdashboard </td>
			   <td>   $row->separatestand</td>
			   <td> $row->addinstall</td>
			   <td> $row->optionnewspaper</td>
			   <td> $row->isolatedhousing</td>
			   <td> $row->colorhousing</td>
			   <td> $row->housingprint</td>
			   <td> $row->enlargementmailbox</td>
			   <td> $row->vatcharges</td>
			   <td> $row->oneoffcontribute</td>
			   <td> $row->preorderfees</td>
			   <td> $row->monthlysub</td>	   
				<td> 
				<a href='?page=rs-top-editfeatures-handle&edit_id=$row->featureid'>Edit</a></td>
			   <td><a href='?page=rs-top-viewfeatures-handle&delete_id=$row->featureid'>Delete</a></td>	 
			   </tr>";
            $i++;
        }
          echo"</table>";
    }         
		else { echo "No data is added" ;}

// For Webshop page

 $webshop= $wpdb->get_results("select resender_feature.* , countries.countryname , countries.symbol   from resender_feature 
			 inner join  countries  on resender_feature.countryid=countries.countryid WHERE servicepage='webshop'");
            
			 
			if($webshop>0)
			{	 echo "<table><tr class='resender_pageheading'><h1>Webshop Page</h1></tr> <tr> 		
			<td> Sr No.   </td>
			<td> Country  </td>
			<td> Resender Basic System (DIY) Do it Yourself	</td>
			<td>App Dashboard</td>
			<td> Separate Stand  </td>
			<td>  Installation Fees  </td>
			<td> Newspaper option  </td>
			<td> Isolated Housing  </td>
			<td> Colour of your personal choice</td>
			<td> Housing Print Option </td>
			<td> Enlargement Mailbox</td>
			<td>Vat Charges</td>
			<td>One Off Contribute</td>
			<td>Pre Order Fees</td>
			<td>Monthly Subscriptions</td>
			<td>Edit</td>
			<td>Delete</td>
			</tr>";	
		
                $i=1;
        foreach($webshop as $row) 
        {
              $editid= $row->featureid ;
			   echo "<tr>
				<td> $i  </td>
			   <td> $row->countryname  </td>
			   <td>  $row->basicsystem </td>
			   <td> $row->appdashboard </td>
			   <td>   $row->separatestand</td>
			   <td> $row->addinstall</td>
			   <td> $row->optionnewspaper</td>
			   <td> $row->isolatedhousing</td>
			   <td> $row->colorhousing</td>
			   <td> $row->housingprint</td>
			   <td> $row->enlargementmailbox</td>
			   <td> $row->vatcharges</td>
			   <td> $row->oneoffcontribute</td>
			   <td> $row->preorderfees</td>
			   <td> $row->monthlysub</td>		   
				<td> 
				<a href='?page=rs-top-editfeatures-handle&edit_id=$row->featureid'>Edit</a></td>
			   <td><a href='?page=rs-top-viewfeatures-handle&delete_id=$row->featureid'>Delete</a></td>	 
			   </tr>";
            $i++;
        }
          echo"</table>";
    }         
		else { echo "No data is added" ;}

// For Courier page

 $courier= $wpdb->get_results("select resender_feature.* , countries.countryname , countries.symbol   from resender_feature 
			 inner join  countries  on resender_feature.countryid=countries.countryid WHERE servicepage='courier'");
            
			 
			if($webshop>0)
			{	 echo "<table><tr class='resender_pageheading'><h1>Courier Page</h1></tr> <tr> 		
			<td> Sr No.   </td>
			<td> Country  </td>
			<td> Resender Basic System (DIY) Do it Yourself	</td>
			<td> App Dashboard</td>
			<td> Separate Stand  </td>
			<td>  Installation Fees  </td>
			<td> Newspaper option   </td>
			<td> Isolated Housing  </td>
			<td> Colour of your personal choice</td>
			<td>Housing Print Option</td>
			<td> Enlargement Mailbox</td>
			<td>Vat Charges</td>
			<td>One Off Contribute</td>
			<td>Pre Order Fees</td>
			<td>Monthly Subscriptions</td>
			<td>Edit</td>
			<td>Delete</td>
			</tr>";	
		
                $i=1;
        foreach($courier as $row) 
        {
              $editid= $row->featureid ;
			   echo "<tr>
				<td> $i  </td>
			   <td> $row->countryname  </td>
			   <td> $row->basicsystem </td>
			   <td> $row->appdashboard</td>
			   <td> $row->separatestand</td>
			   <td> $row->addinstall</td>
			   <td> $row->optionnewspaper</td>
			   <td> $row->isolatedhousing</td>
			   <td> $row->colorhousing</td>
			   <td> $row->housingprint</td>
			   <td> $row->enlargementmailbox</td>
			   <td> $row->vatcharges</td>
			   <td> $row->oneoffcontribute</td>
			   <td> $row->preorderfees</td>
			   <td> $row->monthlysub</td>		   
				<td> 
				<a href='?page=rs-top-editfeatures-handle&edit_id=$row->featureid'>Edit</a></td>
			   <td><a href='?page=rs-top-viewfeatures-handle&delete_id=$row->featureid'>Delete</a></td>	 
			   </tr>";
            $i++;
        }
          echo"</table>";
    }         
		else { echo "No data is added" ;}

// For Company page

 $company= $wpdb->get_results("select resender_feature.* , countries.countryname , countries.symbol   from resender_feature 
			 inner join  countries  on resender_feature.countryid=countries.countryid WHERE servicepage='company'");
            
			 
			if($company>0)
			{	 echo "<table><tr class='resender_pageheading'><h1>Company Page</h1></tr> <tr> 		
			<td> Sr No.   </td>
			<td> Country  </td>
			<td> Resender Basic System (DIY) Do it Yourself	</td>
			<td> App Dashboard </td>
			<td> Separate Stand  </td>
			<td>  Installation Fees  </td>
			<td> Newspaper option   </td>
			<td> Isolated Housing  </td>
			<td> Colour of your personal choice</td>
			<td>Housing Print Option</td>
			<td> Enlargement Mailbox</td>
			<td>Vat Charges</td>
			<td>One Off Contribute</td>
			<td>Pre Order Fees</td>
			<td>Monthly Subscriptions</td>
			<td>Edit</td>
			<td>Delete</td>
			</tr>";	
		
                $i=1;
        foreach($company as $row) 
        {
              $editid= $row->featureid ;
			   echo "<tr>
				<td> $i  </td>
			   <td> $row->countryname  </td>
			   <td>  $row->basicsystem </td>
			   <td> $row->appdashboard </td>
			   <td>   $row->separatestand</td>
			   <td> $row->addinstall</td>
			   <td> $row->optionnewspaper</td>
			   <td> $row->isolatedhousing</td>
			   <td> $row->colorhousing</td>
			   <td> $row->housingprint</td>
			   <td> $row->enlargementmailbox</td>
			   <td> $row->vatcharges</td>
			   <td> $row->oneoffcontribute</td>
			   <td> $row->preorderfees</td>
			   <td> $row->monthlysub</td>		   
				<td> 
				<a href='?page=rs-top-editfeatures-handle&edit_id=$row->featureid'>Edit</a></td>
			   <td><a href='?page=rs-top-viewfeatures-handle&delete_id=$row->featureid'>Delete</a></td>	 
			   </tr>";
            $i++;
        }
          echo"</table>";
    }         
		else { echo "No data is added" ;}		
		
		if(isset($_REQUEST['delete_id']))
		{
			delete_feature();
		}
?>
  </form>
</div>
<!-- View  Features Country Wise End-->
<?php
}
function delete_feature ()
{
 global $wpdb;
 $id=$_REQUEST['delete_id'];
 $myrows=$wpdb->query("delete from resender_feature where featureid=$id");
 if($myrows>0) {echo"<div class='updatedmsg'><p> Data is deleted successfully </p></div>"; }
 else {echo"<div class='errormsg'><p> Data is not deleted successfully </p></div>";} 
}
function edit_feature ()
{   	
	 $edit_id=$_REQUEST['edit_id'];
	$qry2="select resender_feature.* , countries.countryname , countries.symbol   from resender_feature 
	 inner join  countries  on resender_feature.countryid=countries.countryid where featureid=$edit_id";
   global $wpdb;	
	  $myrow = $wpdb->get_results($qry2);    
		foreach($myrow as $row) 
		{ 	 
			$countryname=$row->countryname;
            $countryid=$row->countryid;
			$symbol=$row->symbol;
			$basicsystem=$row->basicsystem; 
			$separatestand=$row->separatestand;
			$addinstall=$row->addinstall; 
			$optionnewspaper=$row->optionnewspaper;
			$isolatedhousing=$row->isolatedhousing ;
			$colorhousing=$row->colorhousing ;
			$enlargementmailbox=$row->enlargementmailbox ;
			$vatcharges=$row->vatcharges ;
			$oneoffcontribute=$row->oneoffcontribute ;
			$preorderfees=$row->preorderfees ;
			$monthlysub=$row->monthlysub;
			$appdashboard=$row->appdashboard;
			$housingprint=$row->housingprint;
            			
		}		
		?>
<div class="addfeatures">
  <h2> Update Features </h2>
  <form method="post" action="">
    <div class="form-group">
      <label> Choose Country </label>
      <select name="addcountry">
          <option value="<?php echo $countryid ;?>"><?php echo $countryname ;?> </option>>
        <?php  global $wpdb;            					
					$myrow = $wpdb->get_results('SELECT * FROM countries');  			 			    
					foreach($myrow as $row) { echo "<option value=$row->countryid> $row->countryname </option> ";}				
				?>
		</select>
    </div>
    <div class="form-group">
      <label>Basic System</label>
      <input type="text" name="basicsystem" value="<?php echo $basicsystem ;?>" required/>
    </div>
	<div class="form-group">
      <label>App Dashboard</label>
      <input type="text" name="appdashboard" value="<?php echo $appdashboard ;?>" required/>
    </div>
    <div class="form-group">
      <label>Separate Outsite Stand</label>
      <input type="text" name="separatestand" value="<?php echo $separatestand ;?>" required/>
    </div>
    <div class="form-group">
      <label>Installation Basic system by us</label>
      <input type="text" name="addinstall" value="<?php echo $addinstall ;?>" required/>
    </div>
    <div class="form-group">
      <label>Newspaper option</label>
      <input type="text" name="optionnewspaper" value="<?php echo $optionnewspaper ;?>"required/>
    </div>
    <div class="form-group">
      <label>Isolated Housing</label>
      <input type="text" name="isolatedhousing" value="<?php echo $isolatedhousing ;?>"required/>
    </div>
    <div class="form-group">
      <label>Colour of your personal choice</label>
      <input type="text" name="colorhousing" value="<?php echo $colorhousing ;?>"required/>
    </div>
	<div class="form-group">
      <label>Housing Print Option</label>
      <input type="text" name="housingprint" value="<?php echo $housingprint ;?>"required/>
    </div>
    <div class="form-group">
      <label>Enlargement Piece Mailbox</label>
      <input type="text" name="enlargementmailbox" value="<?php echo $enlargementmailbox ;?>"required/>
    </div>
    <div class="form-group">
      <label>Vat Charges</label>
      <input type="text" name="vatcharges" value="<?php echo $vatcharges ;?>"required/>
    </div>
    <div class="form-group">
      <label>One Off Contriburion</label>
      <input type="text" name="oneoffcontribute" value="<?php echo $oneoffcontribute ;?>"required/>
    </div>
    <div class="form-group">
      <label>Pre Order Fees</label>
      <input type="text" name="preorderfees" value="<?php echo $preorderfees ;?>"required/>
    </div>
    <div class="form-group">
      <label>Monthly Subscriptions</label>
      <input type="text" name="monthlysub" value="<?php echo $monthlysub ;?>"required/>
    </div>
    <div class="form-group">
      <label> </label>
      <input type="submit" name="updatefeatures" value="Update"/>
    </div>
  </form>
</div>

<?php	 
   if(isset ($_POST["updatefeatures"]))
   {
    $edit_id=$_REQUEST['edit_id'];
   $addcountry=$_POST["addcountry"];
   $basicsystem=$_POST["basicsystem"];
   $separatestand=$_POST["separatestand"];
   $addinstall=$_POST["addinstall"];
   $optionnewspaper=$_POST["optionnewspaper"];
   $isolatedhousing=$_POST["isolatedhousing"];
   $colorhousing=$_POST["colorhousing"];
   $enlargementmailbox=$_POST["enlargementmailbox"];
   $vatcharges=$_POST["vatcharges"];
   $oneoffcontribute=$_POST["oneoffcontribute"];
   $preorderfees=$_POST["preorderfees"];
   $monthlysub=$_POST["monthlysub"];
   $appdashboard=$_POST["appdashboard"];
   $housingprint=$_POST["housingprint"];
      
    global $wpdb;            					
	$myrow = $wpdb->query("update  resender_feature set countryid=$addcountry , basicsystem=$basicsystem, separatestand=$separatestand , addinstall=$addinstall, optionnewspaper=$optionnewspaper, isolatedhousing=$isolatedhousing ,colorhousing=$colorhousing , enlargementmailbox=$enlargementmailbox , vatcharges=$vatcharges , oneoffcontribute=$oneoffcontribute, preorderfees=$preorderfees , monthlysub=$monthlysub, appdashboard=$appdashboard, housingprint=$housingprint where featureid=$edit_id");    
   if($myrow>0)
		{ echo"<div class='updatedmsg'><p> Data is updated successfully </p></div>"; }
   else   { echo"<div class='errormsg'><p> Data is not updated </p></div>"; }
   }		
}
function resender_consumer_form()
{
?> 
<script type="text/javascript">
	$(document).ready(function(){
		$('#info_form').hide();
				
			
		$('#country').change(function(event){
			var country=$('#country').val();
            var servicedata= $(this).find(':selected').attr('servicedata')	
            		
          	$("#appdashboard, #separatestand, #addinstall , #optionnewspaper , #isolatedhousing, #colorhousing, #housingprint, #enlargementmailbox").removeAttr("checked");	
			$.ajax({
						url:'<?php echo dataload ; ?>/ajaxsearch.php?countryv='+country+'&servicedata='+servicedata,
						type:'GET',
						success:function(data)
						{
					
						var arr=data;
						 var ss= arr.split(",");
						 var basicsystem= ss[0];
						 var separatestand= ss[1];
						 var addinstall= ss[2];
						 var optionnewspaper= ss[3];
						 var isolatedhousing= ss[4];
						 var colorhousing= ss[5];
						 var enlargementmailbox= ss[6];
						 var vatcharges= ss[7];
						 var oneoffcontribute= ss[8];
						 var preorderfees= ss[9];
						 var monthlysub= ss[10];
						 var appdashboard= ss[11];
						 var housingprint= ss[12];
					     var symbol= country;
						 var currency_code= '';
						// var totaloption= basicsystem;					
						 var totalsystem=  parseInt(basicsystem) + parseInt(oneoffcontribute) ;
						 var vat=21/100*totalsystem;
						 var vatpreorder=21/100*parseInt(preorderfees);
						 var totalrensenderprice=parseInt(preorderfees)+vatpreorder;
						 var totalsystemprice=vat+totalsystem;
						$('.symbol').html(ss[13]);
                        $('#symbols').val(symbol);
                        $('#currency_code').val(currency_code);
						$('#basicsystemprice').html(basicsystem);						 
						//$('#totalbasicsystem').val(basicsystem);						 
						 $('#separatestandprice').html(separatestand);							  				
						 $('#addinstallprice').html(addinstall);						
						 $('#optionnewspaperprice').html(optionnewspaper);						 
						 $('#isolatedhousingprice').html(isolatedhousing);						
						 $('#colorhousingprice').html(colorhousing);							 					
						 $('#enlargementmailboxprice').html(enlargementmailbox);
						 $('#vatcharges').val(Math.round(vat),2);
						 $('#vatchargesprice').html(Math.round(vat),2);
						 $('#oneoffcontributeprice').html(oneoffcontribute);
						 $('#oneoffcontribute').val(oneoffcontribute);
						 $('#preorderfees').val(preorderfees);						
						 $('#preorderfeesprice').html(preorderfees);
						 $('#monthlysub').val(monthlysub);
						 $('#monthlysubprice').html(monthlysub);
						  $('#appdashboard').val(appdashboard);
						 $('#appdashboardprice').html(appdashboard);
						 $('#housingprint').val(housingprint);
						 $('#housingprintprice').html(housingprint);
						 $('#totalbasicsystem').html(ss[0]);
						 
						
						 $('#totaloptionprice').html('0.00');
						 $('#vatpreorder').html(vatpreorder);
                         $("#excludevat").html(totalsystem);						 
                         $("#totalsystemprice").html(Math.round(totalsystemprice),2);	
                        $("#totalsystempricepreorder").html(totalrensenderprice);						 
						 //$('#totaloption').val(totaloption);						
						},
						error:function(err){alert(err);}								 
					}); 			
		});			
		$('#separatestand').click(function(){
		   var sep=$('#separatestand').is(':checked');		   		    
		   if(sep==true)
		   {
		      $('.separatestandprice').show();
				var separatestandprice=$('#separatestandprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)+ parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val(separatestandprice);
		   }
		   else {
		   $('.separatestandprice').hide();
		   var separatestandprice=$('#separatestandprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)- parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val('');
				}			 
		});
		
			$('#appdashboard').click(function(){
		   var adddash=$('#appdashboard').is(':checked');		   		    
		   if(adddash==true)
		   {
				var appdashboardprice=$('#appdashboardprice').text();$('.appdashboardprice').show();					 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)+ parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val(appdashboardprice);
		   }
		   else {
           $('.appdashboardprice').hide();		   
		   var appdashboardprice=$('#appdashboardprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)- parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val('');
				}			 
		});
		
		$('#housingprint').click(function(){
		   var housepr=$('#housingprint').is(':checked');		   		    
		   if(housepr==true)
		   {
		      $('.housingprintprice').show();	
				var housingprintprice=$('#housingprintprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)+ parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val(housingprintprice);
		   }
		   else { var housingprintprice=$('#housingprintprice').text();	$('.housingprintprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)- parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val('');
				}			 
		});
		
		$('#addinstall').click(function(){
		   var addinst=$('#addinstall').is(':checked');
		   if(addinst==true)
		   {
				var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)+ parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val(addinstallprice);
		   }
		   else { var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)- parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val('0');
				}
		});		
		$('#optionnewspaper').click(function(){
		   var optionnewspaper=$('#optionnewspaper').is(':checked');
		   if(optionnewspaper==true)
		   {
				var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)+ parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val(optionnewspaperprice);
		   }
		   else { var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)- parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val('0');
				}
		});
		$('#isolatedhousing').click(function(){
		   var optionnewspaper=$('#isolatedhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val(isolatedhousingprice);
		   }
		   else { var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val('');
				}
		});
		$('#colorhousing').click(function(){
		   var optionnewspaper=$('#colorhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var colorhousingprice=$('#colorhousingprice').text();	$('.colorhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val(colorhousingprice);
		   }
		   else { var colorhousingprice=$('#colorhousingprice').text();$('.colorhousingprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val('noneed');
				}
		});
		$('#enlargementmailbox').click(function(){
		   var enlargementmailbox=$('#enlargementmailbox').is(':checked');
		   if(enlargementmailbox==true)
		   {
				var enlargementmailboxprice=$('#enlargementmailboxprice').text();$('.enlargementmailboxprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)+ parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val(enlargementmailboxprice);
		   }
		   else { var enlargementmailboxprice=$('#enlargementmailboxprice').text();	$('.enlargementmailboxprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)- parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val('');
				}
		});
		$('#featureform').click(function(){
			var acceptoption=$('#accept').is(':checked');
			var country=$('#country').val();
		    if (country==0)
			{	alert('Please select country'); return false; }
			else if(acceptoption==true)
			{	$('#info_form').show('slow');  return true; }
			
			else { alert('Accept our terms & conditions'); return false;}
		});
		$('#accept').click(function(){
			var acceptoption=$('#accept').is(':checked');			 
		    if (acceptoption==true)
			{ }			
			else {$('#info_form').hide('slow');}
		});		
	});
	</script>
	<div style="float:left;width:63%">
	<form action="" method="post">
<div class="viewfeatures" id="viewfeatures">
<h2> View Features </h2>

<h3>Consumer Pricing Form</h3>
  <div class="form-group">
    <label style="font-weight: bold; color: #333; float: left; font-size: 16px ! important;"> Tick option boxes of your choice ! </label>
        <div class="price">
		<select name="addcountry" id="country">
                        <option value=""><?php if($_REQUEST['lang']=='en'){ ?>--select-- <?php }else if($_REQUEST['lang']=='de'){ ?>--auswÃƒÂ¤hlen-- <?php }else{ ?>--select--<?php } ?></option>
			 <?php  global $wpdb;            						
				 $myrow = $wpdb->get_results("select  countries.countryname , countries.code from   countries order by countries.countryname ASC"); 			 			    
					foreach($myrow as $row) { echo "<option servicedata='consumer' value=$row->code> $row->countryname </option> ";}				
				?>
		</select>
      
    </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="basicsystem" name="basicsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else if($_REQUEST['lang']=='de'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else{ ?>Resender Basic System (DIY) Do it Yourself<?php } ?></label>
    <div class="basicsystem price" style="text-align:right"> <span class="symbol"></span><span id="basicsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="appdashboard" name="appdashboard" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>App Dashboard <?php }else if($_REQUEST['lang']=='de'){ ?>App Dashboard <?php }else{ ?>App Dashboard<?php } ?></label>
    <div class="appdashboardprice price" style="display:none;text-align:right"> <span class="symbol"> </span><span id="appdashboardprice" > </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="addinstall" name="addinstall" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Installation Basic system by us<?php }else if($_REQUEST['lang']=='de'){ ?>In Installationskosten <?php }else{ ?>Voeg installatiekosten<?php } ?></label>
    <div class="price addinstallprice" style="display:none;"><a href="#" target="_blank">example picture</a> <span class="symbol"> </span><span  id="addinstallprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="separatestand" name="separatestand" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Separate Outsite Stand <?php }else if($_REQUEST['lang']=='de'){ ?>Separate Outsite StÃƒÂ¤nder <?php }else{ ?>Aparte Outsite Stand<?php } ?></label>
    <div class="price separatestandprice" style="display:none;"><a href="#" target="_blank">example picture</a> <span class="symbol"> </span><span id="separatestandprice" > </span> </div>
  </div>
  
  <div class="form-group">
    <input type="checkbox"  id="optionnewspaper" value="" name="optionnewspaper"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Newspaper option<?php }else if($_REQUEST['lang']=='de'){ ?>Option Zeitung <?php }else{ ?>optie krant<?php } ?></label>
    <div class="price optionnewspaperprice" style="display:none;"><a href="#" target="_blank">example picture</a> <span class="symbol"> </span><span id="optionnewspaperprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="isolatedhousing" value="" name="isolatedhousing"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Isolated Housing <?php }else if($_REQUEST['lang']=='de'){ ?>getrennt GehÃƒÂ¤use <?php }else{ ?>geÃƒÂ¯soleerde Housing<?php } ?></label>
    <div class="price isolatedhousingprice" style="display:none;"> <a href="#" target="_blank">example picture</a><span class="symbol"> </span><span  id="isolatedhousingprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="colorhousing"  name="colorhousing1" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Colour of your personal choice <?php }else if($_REQUEST['lang']=='de'){ ?>Farbe GehÃƒÂ¤use <?php }else{ ?>Kleur Behuizing<?php } ?></label>
    <div class="price colorhousingprice" style="display:none;"> <input type="text" name="colour" id="colour"><span class="symbol"> </span><span id="colorhousingprice"> </span> </div>
  </div>
   <div class="form-group">
    <input type="checkbox" id="housingprint"  name="housingprint" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Housing Print Option <?php }else if($_REQUEST['lang']=='de'){ ?>Housing Print Option <?php }else{ ?>Housing Print Option<?php } ?></label>
    <div class="price housingprintprice" style="display:none;">image <span class="symbol"> </span><span id="housingprintprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="enlargementmailbox"  name="enlargementmailbox" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Enlargement Piece Mailbox <?php }else if($_REQUEST['lang']=='de'){ ?>
Erweiterung Piece Mailbox <?php }else{ ?>Uitbreiding Piece Mailbox<?php } ?></label>
    <div class="price enlargementmailboxprice" style="display:none;"><a href="#" target="_blank">example picture</a> <span class="symbol"> </span><span id="enlargementmailboxprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="totaloption" name="totaloption" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>Subtotal options<?php }else if($_REQUEST['lang']=='de'){ ?>insgesamt Optionen<?php }else{ ?>Totaal Opties<?php } ?></label>
    <div class="price upborder"> <span class="symbol"> </span><span id="totaloptionprice"> </span> </div>
  </div>
  <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="symbols" name="symbols" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="currency_code" name="currency_codes" style="opacity:0;" checked/>
  <div class="form-group">
    <input type="checkbox" value=""  id="oneoffcontribute" name="oneoffcontribute" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>Basic System <?php }else if($_REQUEST['lang']=='de'){ ?>Basic System <?php }else{ ?>Basic System<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="totalbasicsystem"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="oneoffcontribute" name="oneoffcontribute" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>One of Contribution <?php }else if($_REQUEST['lang']=='de'){ ?>ONE OFF Beitrag <?php }else{ ?>Eenmalige bijdrage<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="oneoffcontributeprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>SubTotal (excluding vat) <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="excludevat"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>VAT <?php }else if($_REQUEST['lang']=='de'){ ?>
Vat GebÃ¯Â¿Â½hren  <?php }else{ ?>BTW-heffing <?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="vatchargesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>Total Resender System <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="totalsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="" name="preorderfees" id="preorderfees" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>Pay now Pre Order Fee   <?php }else if($_REQUEST['lang']=='de'){ ?>Pre Order GebÃƒÂ¼hren (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Pre order kosten (inclusief BTW)<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="preorderfeesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>VAT <?php }else if($_REQUEST['lang']=='de'){ ?>
Vat GebÃ¯Â¿Â½hren  <?php }else{ ?>BTW-heffing <?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="vatpreorder"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label style="text-align:right"><?php if($_REQUEST['lang']=='en'){ ?>Total Resender System <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="totalsystempricepreorder"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="monthlysub" name="monthlysub" style="opacity:0;" checked/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Exclusively Monthly Subscriptions <?php }else if($_REQUEST['lang']=='de'){ ?>AusschlieÃƒÅ¸lich Monatliche Abos <?php }else{ ?>Exclusief maandelijkse abonnementen<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="monthlysubprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="yes"  id="newsletterbox" name="newsletterbox"/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Newsletter Subscription <?php }else if($_REQUEST['lang']=='de'){ ?>Newsletter abonnieren <?php }else{ ?>Nieuwsbrief abonnement<?php } ?></label>
    <div class="price"> </div>
  </div>
  <div class="form-group accept">
    <input type="checkbox" value="accept" id="accept"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Accept our terms and conditions <?php }else if($_REQUEST['lang']=='de'){ ?>Akzeptieren Sie unsere Allgemeinen GeschÃƒÂ¤ftsbedingungen <?php }else{ ?>Accepteer onze algemene voorwaarden<?php } ?></label>
  </div>
  <div class="form-group">
    <button type="button" value="Input Your Data"  id="featureform"><?php if($_REQUEST['lang']=='en'){ ?>Input Your Data <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre Daten <?php }else{ ?>Voer uw gegevens<?php } ?></button>
  </div>
  </div>
  <div class="infoform" id="info_form">
  <h2> <?php if($_REQUEST['lang']=='en'){ ?>Enter Your Personal Details <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre persÃƒÂ¶nlichen Daten <?php }else{ ?>Geef uw persoonlijke gegevens<?php } ?></h2>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>First Name <?php }else if($_REQUEST['lang']=='de'){ ?>Vorname <?php }else{ ?>Voornaam<?php } ?></label>
    <input type="text" name="firstname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Last Name <?php }else if($_REQUEST['lang']=='de'){ ?>Nachname <?php }else{ ?>Achternaam<?php } ?></label>
    <input type="text" name="lastname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Contact Number <?php }else if($_REQUEST['lang']=='de'){ ?>Kontakt Nummer <?php }else{ ?>Contact nummer<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="phone" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Email <?php }else if($_REQUEST['lang']=='de'){ ?>Basic System <?php }else{ ?>e-mail<?php } ?></label>
    <input type="email" name="email"  required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Address <?php }else if($_REQUEST['lang']=='de'){ ?>Anschrift <?php }else{ ?>
adres<?php } ?></label>
    <textarea name="address" required></textarea>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Zip Code <?php }else if($_REQUEST['lang']=='de'){ ?>PLZ <?php }else{ ?>Postcode<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="zipcode" required/>
  </div>
  <div class="form-group"><?php  echo do_shortcode( '[bws_google_captcha]' );?> </div>
  <div class="form-group">


    <input type="submit" value="<?php if($_REQUEST['lang']=='en'){ ?>Pay Now <?php }else if($_REQUEST['lang']=='de'){ ?>Jetzt bezahlen <?php }else{ ?>Nu betalen<?php } ?>" name="featureform" id="infosubmit"/>
  </div>


</div></form>
</div>
<div style="float:right;width:37%"><img src="<?php echo dataload; ?>/images/special.png"></div>
<?php
				if(isset($_REQUEST['featureform']))					
				{					
				 	if(isset($_REQUEST['addcountry'])) {$countryid=$_REQUEST["addcountry"]; }
					if(isset($_REQUEST['basicsystem'])) {$basicsystem=$_REQUEST["basicsystem"]; }
					if(isset($_REQUEST['appdashboard'])) {$appdashboard=$_REQUEST["appdashboard"]; }
					if(isset($_REQUEST['separatestand'])) { $separatestand=$_REQUEST['separatestand']; }
					if(isset($_REQUEST['addinstall'])) { $addinstall=$_REQUEST['addinstall'];}				  			   
					if(isset($_REQUEST['optionnewspaper'])) { $optionnewspaper=$_REQUEST['optionnewspaper'];}
					if(isset($_REQUEST['isolatedhousing'])) {  $isolatedhousing=$_REQUEST['isolatedhousing'];}
					if(isset($_REQUEST['colorhousing1'])) { $colorhousing1=$_REQUEST['colorhousing1'];}
					if(isset($_REQUEST['housingprint'])) { $housingprint=$_REQUEST['housingprint'];}
				    if(isset($_REQUEST['enlargementmailbox'])) {$enlargementmailbox=$_REQUEST['enlargementmailbox'];}
					if(isset($_REQUEST['colorhousing1'])) {  $totaloption=$_REQUEST["totaloption"]; }
					if(isset($_REQUEST['totaloption'])) {   $vatcharges=$_REQUEST["vatcharges"]; }
					if(isset($_REQUEST['totalsystem'])) {  $totalsystem=$_REQUEST["totalsystem"]; }
					if(isset($_REQUEST['oneoffcontribute'])) {   $oneoffcontribute=$_REQUEST["oneoffcontribute"];}
					if(isset($_REQUEST['preorderfees'])) {   $preorderfees=$_REQUEST["preorderfees"];}
					if(isset($_REQUEST['monthlysub'])) {   $monthlysub=$_REQUEST["monthlysub"];}				 
					if(isset($_REQUEST['newsletterbox'])) {  $newsletterbox=$_REQUEST["newsletterbox"];}				 
					if(isset($_REQUEST['firstname'])) {$firstname=$_REQUEST['firstname'];}
					if(isset($_REQUEST['lastname'])) {$lastname=$_REQUEST['lastname'];}
					if(isset($_REQUEST['phone'])) {$phone=$_REQUEST['phone'];}
					if(isset($_REQUEST['email'])) {$email=$_REQUEST['email'];}
					if(isset($_REQUEST['address'])) {$address=$_REQUEST['address'];}
					if(isset($_REQUEST['zipcode'])) {$zipcode=$_REQUEST['zipcode'];} 
                    global $wpdb;
                    /*$myrow=$wpdb->query("insert into user_info values('','$countryid' , '$basicsystem','$separatestand' ,'$addinstall' ,'$optionnewspaper' ,'$isolatedhousing' ,'$colorhousing','$enlargementmailbox' ,'$totaloption', '$vatcharges' ,'$oneoffcontribute', '$totalsystem' ,'$preorderfees' , '$monthlysub' , '$newsletterbox','$firstname' ,'$lastname' ,'$phone','$email','$address','$zipcode',0)");					
					if($myrow>0)
					{	*/
						echo "<script> $('#viewfeatures').hide();</script>";				
						$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
						//$paypal_id='restroom256-facilitator@gmail.com'; 
                                                $paypal_id='anjo@resender.eu'; 
						$currency_input=$_REQUEST['totalsystem'];
						$symbols=$_REQUEST['symbols'];	
						$currency_from=$_REQUEST['currency_codes'];	
						$currency_to = "USD";
						$fromcurrency = $_REQUEST['addcountry'];
				$tocurrency = 'USD';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "http://download.finance.yahoo.com/d/quotes.csv?s=$fromcurrency$tocurrency=X&f=sl1&e=.csv");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			
				$content = curl_exec($curl);			
				curl_close($curl); 
				$value = substr(trim($content), 11, 6);
				$currency = $value*trim($currency_input);
				?>
						
<div class="viewpayment">
  <div class="image"> <img src="<?php echo dataload; ?>/images/logogif.gif"/> </div>
  <div class="viewprice"> <?php echo $symbols; echo  $currency_input; echo "changed Amount:USD".$currency ; echo "Deposit Amount:USD".ceil($currency);?> </div>
  <div class="btn">
    <form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
      <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="item_name" value="Resender Form">
      <input type="hidden" name="item_number" value="1">
    
      <input type="hidden" name="userid" value="1">
      <input type="hidden" name="amount" value="<?php echo ceil($currency); ?>">
      <input type="hidden" name="cpp_header_image" value="http://www.phpgang.com/wp-content/uploads/gang.jpg">
      <input type="hidden" name="no_shipping" value="1">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="handling" value="0">
      <input type="hidden" name="cancel_return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="hidden" name="return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
     <input type="hidden" name="notify_url" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>
<?php	
				/*}else { echo"<div class='errormsg'><p> Data is not saved </p></div>";}		*/			 
				}	
}
add_shortcode('resender-form-consumer','resender_consumer_form');
 
function resender_webshop_form()
{
?> 
<script type="text/javascript">
	$(document).ready(function(){
		$('#info_form').hide();
				
			
		$('#country').change(function(event){
			var country=$('#country').val();
            var servicedata= $(this).find(':selected').attr('servicedata')	
            		
          	$("#appdashboard, #separatestand, #addinstall , #optionnewspaper , #isolatedhousing, #colorhousing, #housingprint, #enlargementmailbox").removeAttr("checked");	
			$.ajax({
						url:'<?php echo dataload ; ?>/ajaxsearch.php?countryv='+country+'&servicedata='+servicedata,
						type:'GET',
						success:function(data)
						{
						var arr=data;
						 var ss= arr.split(",");
						 var basicsystem= ss[0];
						 var separatestand= ss[1];
						 var addinstall= ss[2];
						 var optionnewspaper= ss[3];
						 var isolatedhousing= ss[4];
						 var colorhousing= ss[5];
						 var enlargementmailbox= ss[6];
						 var vatcharges= ss[7];
						 var oneoffcontribute= ss[8];
						 var preorderfees= ss[9];
						 var monthlysub= ss[10];
						 var appdashboard= ss[11];
						 var housingprint= ss[12];
					     var symbol= country;
						 var currency_code= '';
						 var totaloption= basicsystem;					
						 var totalsystem=  parseInt(basicsystem) + parseInt(vatcharges) + parseInt(oneoffcontribute) ;
						$('.symbol').html(ss[13]);
                        $('#symbols').val(symbol);
                        $('#currency_code').val(currency_code);
						$('#basicsystemprice').html(basicsystem);						 
						$('#basicsystem').val(basicsystem);						 
						 $('#separatestandprice').html(separatestand);							  				
						 $('#addinstallprice').html(addinstall);						
						 $('#optionnewspaperprice').html(optionnewspaper);						 
						 $('#isolatedhousingprice').html(isolatedhousing);						
						 $('#colorhousingprice').html(colorhousing);							 					
						 $('#enlargementmailboxprice').html(enlargementmailbox);
						 $('#vatcharges').val(vatcharges);
						 $('#vatchargesprice').html(vatcharges);
						 $('#oneoffcontributeprice').html(oneoffcontribute);
						 $('#oneoffcontribute').val(oneoffcontribute);
						 $('#preorderfees').val(preorderfees);						
						 $('#preorderfeesprice').html(preorderfees);
						 $('#monthlysub').val(monthlysub);
						 $('#monthlysubprice').html(monthlysub);
						  $('#appdashboard').val(appdashboard);
						 $('#appdashboardprice').html(appdashboard);
						 $('#housingprint').val(housingprint);
						 $('#housingprintprice').html(housingprint);
						 $('#totalsystemprice').html(totalsystem);
						 $('#totalsystem').val(totalsystem);
						 $('#totaloptionprice').html(totaloption);						
						 $('#totaloption').val(totaloption);						
						},
						error:function(err){alert(err);}								 
					}); 			
		});			
		$('#separatestand').click(function(){
		   var sep=$('#separatestand').is(':checked');		   		    
		   if(sep==true)
		   {
		      $('.separatestandprice').show();
				var separatestandprice=$('#separatestandprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)+ parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val(separatestandprice);
		   }
		   else {
		   $('.separatestandprice').hide();
		   var separatestandprice=$('#separatestandprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)- parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val('');
				}			 
		});
		
			$('#appdashboard').click(function(){
		   var adddash=$('#appdashboard').is(':checked');		   		    
		   if(adddash==true)
		   {
				var appdashboardprice=$('#appdashboardprice').text();$('.appdashboardprice').show();					 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)+ parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val(appdashboardprice);
		   }
		   else {
           $('.appdashboardprice').hide();		   
		   var appdashboardprice=$('#appdashboardprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)- parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val('');
				}			 
		});
		
		$('#housingprint').click(function(){
		   var housepr=$('#housingprint').is(':checked');		   		    
		   if(housepr==true)
		   {
		      $('.housingprintprice').show();	
				var housingprintprice=$('#housingprintprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)+ parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val(housingprintprice);
		   }
		   else { var housingprintprice=$('#housingprintprice').text();	$('.housingprintprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)- parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val('');
				}			 
		});
		
		$('#addinstall').click(function(){
		   var addinst=$('#addinstall').is(':checked');
		   if(addinst==true)
		   {
				var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)+ parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val(addinstallprice);
		   }
		   else { var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)- parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val('0');
				}
		});		
		$('#optionnewspaper').click(function(){
		   var optionnewspaper=$('#optionnewspaper').is(':checked');
		   if(optionnewspaper==true)
		   {
				var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)+ parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val(optionnewspaperprice);
		   }
		   else { var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)- parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val('0');
				}
		});
		$('#isolatedhousing').click(function(){
		   var optionnewspaper=$('#isolatedhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val(isolatedhousingprice);
		   }
		   else { var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val('');
				}
		});
		$('#colorhousing').click(function(){
		   var optionnewspaper=$('#colorhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var colorhousingprice=$('#colorhousingprice').text();	$('.colorhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val(colorhousingprice);
		   }
		   else { var colorhousingprice=$('#colorhousingprice').text();$('.colorhousingprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val('noneed');
				}
		});
		$('#enlargementmailbox').click(function(){
		   var enlargementmailbox=$('#enlargementmailbox').is(':checked');
		   if(enlargementmailbox==true)
		   {
				var enlargementmailboxprice=$('#enlargementmailboxprice').text();$('.enlargementmailboxprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)+ parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val(enlargementmailboxprice);
		   }
		   else { var enlargementmailboxprice=$('#enlargementmailboxprice').text();	$('.enlargementmailboxprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)- parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val('');
				}
		});
		$('#featureform').click(function(){
			var acceptoption=$('#accept').is(':checked');
			var country=$('#country').val();
		    if (country==0)
			{	alert('Please select country'); return false; }
			else if(acceptoption==true)
			{	$('#info_form').show('slow');  return true; }
			
			else { alert('Accept our terms & conditions'); return false;}
		});
		$('#accept').click(function(){
			var acceptoption=$('#accept').is(':checked');			 
		    if (acceptoption==true)
			{ }			
			else {$('#info_form').hide('slow');}
		});		
	});
	</script>
<div style="float:left;width:63%">
<form action="" method="post">
<div class="viewfeatures" id="viewfeatures">
<h2> View Features </h2>

<h3>Webshop Pricing Form</h3>
  <div class="form-group">
   <label style="font-weight: bold; color:#333; float: left; font-size: 16px ! important;"> Tick option boxes of your choice ! </label>
        <div class="price">
		<select name="addcountry" id="country">
                        <option value=""><?php if($_REQUEST['lang']=='en'){ ?>--select-- <?php }else if($_REQUEST['lang']=='de'){ ?>--auswÃƒÂ¤hlen-- <?php }else{ ?>--select--<?php } ?></option>
			 <?php  global $wpdb;            						
				 $myrow = $wpdb->get_results("select  countries.countryname , countries.code from   countries order by countries.countryname ASC"); 			 			    
					foreach($myrow as $row) { echo "<option servicedata='webshop' value=$row->code> $row->countryname </option> ";}				
				?>
		</select>
      
    </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="basicsystem" name="basicsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else if($_REQUEST['lang']=='de'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else{ ?>Resender Basic System (DIY) Do it Yourself<?php } ?></label>
  
	<div class="basicsystem price"  style="text-align:right"> <span class="symbol"></span><span id="basicsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="appdashboard" name="appdashboard" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>App Dashboard <?php }else if($_REQUEST['lang']=='de'){ ?>App Dashboard <?php }else{ ?>App Dashboard<?php } ?></label>
    <div class="appdashboardprice price" style="display:none;text-align:right"> <span class="symbol"> </span><span id="appdashboardprice" > </span> </div>
  </div>
    <div class="form-group">
    <input type="checkbox" id="addinstall" name="addinstall" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Installation Basic system by us<?php }else if($_REQUEST['lang']=='de'){ ?>In Installationskosten <?php }else{ ?>Voeg installatiekosten<?php } ?></label>
     <div class="price addinstallprice" style="display:none;"> <span class="symbol"> </span><span  id="addinstallprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="separatestand" name="separatestand" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Separate Outsite Stand <?php }else if($_REQUEST['lang']=='de'){ ?>Separate Outsite StÃƒÂ¤nder <?php }else{ ?>Aparte Outsite Stand<?php } ?></label>
    <div class="price separatestandprice" style="display:none;"> <span class="symbol"> </span><span id="separatestandprice" > </span> </div>
  </div>

  <div class="form-group">
    <input type="checkbox"  id="optionnewspaper" value="" name="optionnewspaper"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Newspaper option<?php }else if($_REQUEST['lang']=='de'){ ?>Option Zeitung <?php }else{ ?>optie krant<?php } ?></label>
    <div class="price optionnewspaperprice" style="display:none;"> <span class="symbol"> </span><span id="optionnewspaperprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="isolatedhousing" value="" name="isolatedhousing"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Isolated Housing <?php }else if($_REQUEST['lang']=='de'){ ?>getrennt GehÃƒÂ¤use <?php }else{ ?>geÃƒÂ¯soleerde Housing<?php } ?></label>
    <div class="price isolatedhousingprice" style="display:none;"> <span class="symbol"> </span><span  id="isolatedhousingprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="colorhousing"  name="colorhousing1" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Colour of your personal choice <?php }else if($_REQUEST['lang']=='de'){ ?>Farbe GehÃƒÂ¤use <?php }else{ ?>Kleur Behuizing<?php } ?></label>
    <div class="price colorhousingprice" style="display:none;"> <span class="symbol"> </span><span id="colorhousingprice"> </span> </div>
  </div>
   <div class="form-group">
    <input type="checkbox" id="housingprint"  name="housingprint" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Housing Print Option <?php }else if($_REQUEST['lang']=='de'){ ?>Housing Print Option <?php }else{ ?>Housing Print Option<?php } ?></label>
     <div class="price housingprintprice" style="display:none;"> <span class="symbol"> </span><span id="housingprintprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="enlargementmailbox"  name="enlargementmailbox" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Enlargement Piece Mailbox <?php }else if($_REQUEST['lang']=='de'){ ?>
Erweiterung Piece Mailbox <?php }else{ ?>Uitbreiding Piece Mailbox<?php } ?></label>
    <div class="price enlargementmailboxprice" style="display:none;"> <span class="symbol"> </span><span id="enlargementmailboxprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="totaloption" name="totaloption" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total Options<?php }else if($_REQUEST['lang']=='de'){ ?>insgesamt Optionen<?php }else{ ?>Totaal Opties<?php } ?></label>
    <div class="price upborder"> <span class="symbol"> </span><span id="totaloptionprice"> </span> </div>
  </div>
  <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="symbols" name="symbols" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="currency_code" name="currency_codes" style="opacity:0;" checked/>
  <div class="form-group">
    <input type="checkbox" value=""  id="oneoffcontribute" name="oneoffcontribute" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>One of Contribution <?php }else if($_REQUEST['lang']=='de'){ ?>ONE OFF Beitrag <?php }else{ ?>Eenmalige bijdrage<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="oneoffcontributeprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>VAT Charges <?php }else if($_REQUEST['lang']=='de'){ ?>
Vat GebÃ¯Â¿Â½hren  <?php }else{ ?>BTW-heffing <?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="vatchargesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total System (including vat) <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="totalsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="" name="preorderfees" id="preorderfees" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Pre Order Fees   <?php }else if($_REQUEST['lang']=='de'){ ?>Pre Order GebÃƒÂ¼hren (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Pre order kosten (inclusief BTW)<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="preorderfeesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="monthlysub" name="monthlysub" style="opacity:0;" checked/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Exclusively Monthly Subscriptions <?php }else if($_REQUEST['lang']=='de'){ ?>AusschlieÃƒÅ¸lich Monatliche Abos <?php }else{ ?>Exclusief maandelijkse abonnementen<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="monthlysubprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="yes"  id="newsletterbox" name="newsletterbox"/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Newsletter Subscription <?php }else if($_REQUEST['lang']=='de'){ ?>Newsletter abonnieren <?php }else{ ?>Nieuwsbrief abonnement<?php } ?></label>
    <div class="price"> </div>
  </div>
  <div class="form-group accept">
    <input type="checkbox" value="accept" id="accept"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Accept our terms and conditions <?php }else if($_REQUEST['lang']=='de'){ ?>Akzeptieren Sie unsere Allgemeinen GeschÃƒÂ¤ftsbedingungen <?php }else{ ?>Accepteer onze algemene voorwaarden<?php } ?></label>
  </div>
  <div class="form-group">
    <button type="button" value="Input Your Data"  id="featureform"><?php if($_REQUEST['lang']=='en'){ ?>Input Your Data <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre Daten <?php }else{ ?>Voer uw gegevens<?php } ?></button>
  </div>
  </div>
  <div class="infoform" id="info_form">
  <h2> <?php if($_REQUEST['lang']=='en'){ ?>Enter Your Personal Details <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre persÃƒÂ¶nlichen Daten <?php }else{ ?>Geef uw persoonlijke gegevens<?php } ?></h2>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>First Name <?php }else if($_REQUEST['lang']=='de'){ ?>Vorname <?php }else{ ?>Voornaam<?php } ?></label>
    <input type="text" name="firstname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Last Name <?php }else if($_REQUEST['lang']=='de'){ ?>Nachname <?php }else{ ?>Achternaam<?php } ?></label>
    <input type="text" name="lastname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Contact Number <?php }else if($_REQUEST['lang']=='de'){ ?>Kontakt Nummer <?php }else{ ?>Contact nummer<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="phone" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Email <?php }else if($_REQUEST['lang']=='de'){ ?>Basic System <?php }else{ ?>e-mail<?php } ?></label>
    <input type="email" name="email"  required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Address <?php }else if($_REQUEST['lang']=='de'){ ?>Anschrift <?php }else{ ?>
adres<?php } ?></label>
    <textarea name="address" required></textarea>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Zip Code <?php }else if($_REQUEST['lang']=='de'){ ?>PLZ <?php }else{ ?>Postcode<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="zipcode" required/>
  </div>
  <div class="form-group"><?php  echo do_shortcode( '[bws_google_captcha]' );?> </div>
  <div class="form-group">


    <input type="submit" value="<?php if($_REQUEST['lang']=='en'){ ?>Pay Now <?php }else if($_REQUEST['lang']=='de'){ ?>Jetzt bezahlen <?php }else{ ?>Nu betalen<?php } ?>" name="featureform" id="infosubmit"/>
  </div>


</div>
</form></div><div style="float:right;width:37%"><img src="<?php echo dataload; ?>/images/special.png"></div>
<?php
				if(isset($_REQUEST['featureform']))					
				{					
				 	if(isset($_REQUEST['addcountry'])) {$countryid=$_REQUEST["addcountry"]; }
					if(isset($_REQUEST['basicsystem'])) {$basicsystem=$_REQUEST["basicsystem"]; }
					if(isset($_REQUEST['appdashboard'])) {$appdashboard=$_REQUEST["appdashboard"]; }
					if(isset($_REQUEST['separatestand'])) { $separatestand=$_REQUEST['separatestand']; }
					if(isset($_REQUEST['addinstall'])) { $addinstall=$_REQUEST['addinstall'];}				  			   
					if(isset($_REQUEST['optionnewspaper'])) { $optionnewspaper=$_REQUEST['optionnewspaper'];}
					if(isset($_REQUEST['isolatedhousing'])) {  $isolatedhousing=$_REQUEST['isolatedhousing'];}
					if(isset($_REQUEST['colorhousing1'])) { $colorhousing1=$_REQUEST['colorhousing1'];}
					if(isset($_REQUEST['housingprint'])) { $housingprint=$_REQUEST['housingprint'];}
				    if(isset($_REQUEST['enlargementmailbox'])) {$enlargementmailbox=$_REQUEST['enlargementmailbox'];}
					if(isset($_REQUEST['colorhousing1'])) {  $totaloption=$_REQUEST["totaloption"]; }
					if(isset($_REQUEST['totaloption'])) {   $vatcharges=$_REQUEST["vatcharges"]; }
					if(isset($_REQUEST['totalsystem'])) {  $totalsystem=$_REQUEST["totalsystem"]; }
					if(isset($_REQUEST['oneoffcontribute'])) {   $oneoffcontribute=$_REQUEST["oneoffcontribute"];}
					if(isset($_REQUEST['preorderfees'])) {   $preorderfees=$_REQUEST["preorderfees"];}
					if(isset($_REQUEST['monthlysub'])) {   $monthlysub=$_REQUEST["monthlysub"];}				 
					if(isset($_REQUEST['newsletterbox'])) {  $newsletterbox=$_REQUEST["newsletterbox"];}				 
					if(isset($_REQUEST['firstname'])) {$firstname=$_REQUEST['firstname'];}
					if(isset($_REQUEST['lastname'])) {$lastname=$_REQUEST['lastname'];}
					if(isset($_REQUEST['phone'])) {$phone=$_REQUEST['phone'];}
					if(isset($_REQUEST['email'])) {$email=$_REQUEST['email'];}
					if(isset($_REQUEST['address'])) {$address=$_REQUEST['address'];}
					if(isset($_REQUEST['zipcode'])) {$zipcode=$_REQUEST['zipcode'];} 
                    global $wpdb;
                    /*$myrow=$wpdb->query("insert into user_info values('','$countryid' , '$basicsystem','$separatestand' ,'$addinstall' ,'$optionnewspaper' ,'$isolatedhousing' ,'$colorhousing','$enlargementmailbox' ,'$totaloption', '$vatcharges' ,'$oneoffcontribute', '$totalsystem' ,'$preorderfees' , '$monthlysub' , '$newsletterbox','$firstname' ,'$lastname' ,'$phone','$email','$address','$zipcode',0)");					
					if($myrow>0)
					{	*/
						echo "<script> $('#viewfeatures').hide();</script>";				
						$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
						//$paypal_id='restroom256-facilitator@gmail.com'; 
                                                $paypal_id='anjo@resender.eu'; 
						$currency_input=$_REQUEST['totalsystem'];
						$symbols=$_REQUEST['symbols'];	
						$currency_from=$_REQUEST['currency_codes'];	
						$currency_to = "USD";
						$fromcurrency = $_REQUEST['addcountry'];
				$tocurrency = 'USD';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "http://download.finance.yahoo.com/d/quotes.csv?s=$fromcurrency$tocurrency=X&f=sl1&e=.csv");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			
				$content = curl_exec($curl);			
				curl_close($curl); 
				$value = substr(trim($content), 11, 6);
				$currency = $value*trim($currency_input);
				?>
						
<div class="viewpayment">
  <div class="image"> <img src="<?php echo dataload; ?>/images/logogif.gif"/> </div>
  <div class="viewprice"> <?php echo $symbols; echo  $currency_input; echo "changed Amount:USD".$currency ; echo "Deposit Amount:USD".ceil($currency);?> </div>
  <div class="btn">
    <form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
      <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="item_name" value="Resender Form">
      <input type="hidden" name="item_number" value="1">
    
      <input type="hidden" name="userid" value="1">
      <input type="hidden" name="amount" value="<?php echo ceil($currency); ?>">
      <input type="hidden" name="cpp_header_image" value="http://www.phpgang.com/wp-content/uploads/gang.jpg">
      <input type="hidden" name="no_shipping" value="1">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="handling" value="0">
      <input type="hidden" name="cancel_return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="hidden" name="return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
     <input type="hidden" name="notify_url" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>
<?php	
				/*}else { echo"<div class='errormsg'><p> Data is not saved </p></div>";}		*/			 
				}	
}
add_shortcode('resender-form-webshop','resender_webshop_form');
 
function resender_courier_form()
{
?> 
<script type="text/javascript">
	$(document).ready(function(){
		$('#info_form').hide();
				
			
		$('#country').change(function(event){
			var country=$('#country').val();
            var servicedata= $(this).find(':selected').attr('servicedata')	
            		
          	$("#appdashboard, #separatestand, #addinstall , #optionnewspaper , #isolatedhousing, #colorhousing, #housingprint, #enlargementmailbox").removeAttr("checked");	
			$.ajax({
						url:'<?php echo dataload ; ?>/ajaxsearch.php?countryv='+country+'&servicedata='+servicedata,
						type:'GET',
						success:function(data)
						{
						var arr=data;
						 var ss= arr.split(",");
						 var basicsystem= ss[0];
						 var separatestand= ss[1];
						 var addinstall= ss[2];
						 var optionnewspaper= ss[3];
						 var isolatedhousing= ss[4];
						 var colorhousing= ss[5];
						 var enlargementmailbox= ss[6];
						 var vatcharges= ss[7];
						 var oneoffcontribute= ss[8];
						 var preorderfees= ss[9];
						 var monthlysub= ss[10];
						 var appdashboard= ss[11];
						 var housingprint= ss[12];
					     var symbol= country;
						 var currency_code= '';
						 var totaloption= basicsystem;					
						 var totalsystem=  parseInt(basicsystem) + parseInt(vatcharges) + parseInt(oneoffcontribute) ;
						$('.symbol').html(ss[13]);
                        $('#symbols').val(symbol);
                        $('#currency_code').val(currency_code);
						$('#basicsystemprice').html(basicsystem);						 
						$('#basicsystem').val(basicsystem);						 
						 $('#separatestandprice').html(separatestand);							  				
						 $('#addinstallprice').html(addinstall);						
						 $('#optionnewspaperprice').html(optionnewspaper);						 
						 $('#isolatedhousingprice').html(isolatedhousing);						
						 $('#colorhousingprice').html(colorhousing);							 					
						 $('#enlargementmailboxprice').html(enlargementmailbox);
						 $('#vatcharges').val(vatcharges);
						 $('#vatchargesprice').html(vatcharges);
						 $('#oneoffcontributeprice').html(oneoffcontribute);
						 $('#oneoffcontribute').val(oneoffcontribute);
						 $('#preorderfees').val(preorderfees);						
						 $('#preorderfeesprice').html(preorderfees);
						 $('#monthlysub').val(monthlysub);
						 $('#monthlysubprice').html(monthlysub);
						  $('#appdashboard').val(appdashboard);
						 $('#appdashboardprice').html(appdashboard);
						 $('#housingprint').val(housingprint);
						 $('#housingprintprice').html(housingprint);
						 $('#totalsystemprice').html(totalsystem);
						 $('#totalsystem').val(totalsystem);
						 $('#totaloptionprice').html(totaloption);						
						 $('#totaloption').val(totaloption);						
						},
						error:function(err){alert(err);}								 
					}); 			
		});			
		$('#separatestand').click(function(){
		   var sep=$('#separatestand').is(':checked');		   		    
		   if(sep==true)
		   {
		      $('.separatestandprice').show();
				var separatestandprice=$('#separatestandprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)+ parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val(separatestandprice);
		   }
		   else {
		   $('.separatestandprice').hide();
		   var separatestandprice=$('#separatestandprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)- parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val('');
				}			 
		});
		
			$('#appdashboard').click(function(){
		   var adddash=$('#appdashboard').is(':checked');		   		    
		   if(adddash==true)
		   {
				var appdashboardprice=$('#appdashboardprice').text();$('.appdashboardprice').show();					 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)+ parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val(appdashboardprice);
		   }
		   else {
           $('.appdashboardprice').hide();		   
		   var appdashboardprice=$('#appdashboardprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)- parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val('');
				}			 
		});
		
		$('#housingprint').click(function(){
		   var housepr=$('#housingprint').is(':checked');		   		    
		   if(housepr==true)
		   {
		      $('.housingprintprice').show();	
				var housingprintprice=$('#housingprintprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)+ parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val(housingprintprice);
		   }
		   else { var housingprintprice=$('#housingprintprice').text();	$('.housingprintprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)- parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val('');
				}			 
		});
		
		$('#addinstall').click(function(){
		   var addinst=$('#addinstall').is(':checked');
		   if(addinst==true)
		   {
				var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)+ parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val(addinstallprice);
		   }
		   else { var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)- parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val('0');
				}
		});		
		$('#optionnewspaper').click(function(){
		   var optionnewspaper=$('#optionnewspaper').is(':checked');
		   if(optionnewspaper==true)
		   {
				var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)+ parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val(optionnewspaperprice);
		   }
		   else { var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)- parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val('0');
				}
		});
		$('#isolatedhousing').click(function(){
		   var optionnewspaper=$('#isolatedhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val(isolatedhousingprice);
		   }
		   else { var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val('');
				}
		});
		$('#colorhousing').click(function(){
		   var optionnewspaper=$('#colorhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var colorhousingprice=$('#colorhousingprice').text();	$('.colorhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val(colorhousingprice);
		   }
		   else { var colorhousingprice=$('#colorhousingprice').text();$('.colorhousingprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val('noneed');
				}
		});
		$('#enlargementmailbox').click(function(){
		   var enlargementmailbox=$('#enlargementmailbox').is(':checked');
		   if(enlargementmailbox==true)
		   {
				var enlargementmailboxprice=$('#enlargementmailboxprice').text();$('.enlargementmailboxprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)+ parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val(enlargementmailboxprice);
		   }
		   else { var enlargementmailboxprice=$('#enlargementmailboxprice').text();	$('.enlargementmailboxprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)- parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val('');
				}
		});
		$('#featureform').click(function(){
			var acceptoption=$('#accept').is(':checked');
			var country=$('#country').val();
		    if (country==0)
			{	alert('Please select country'); return false; }
			else if(acceptoption==true)
			{	$('#info_form').show('slow');  return true; }
			
			else { alert('Accept our terms & conditions'); return false;}
		});
		$('#accept').click(function(){
			var acceptoption=$('#accept').is(':checked');			 
		    if (acceptoption==true)
			{ }			
			else {$('#info_form').hide('slow');}
		});		
	});
	</script>
<div style="float:left;width:63%">
<form action="" method="post">
<div class="viewfeatures" id="viewfeatures">
<h2> View Features </h2>

<h3>Courier Pricing Form</h3>
  <div class="form-group">
    <label style="font-weight: bold; color: rgb(51, 51, 51); float: left; font-size: 16px ! important;"> Tick option boxes of your choice ! </label>
        <div class="price">
		<select name="addcountry" id="country">
                        <option value=""><?php if($_REQUEST['lang']=='en'){ ?>--select-- <?php }else if($_REQUEST['lang']=='de'){ ?>--auswÃƒÂ¤hlen-- <?php }else{ ?>--select--<?php } ?></option>
			 <?php  global $wpdb;            						
				 $myrow = $wpdb->get_results("select  countries.countryname , countries.code from   countries order by countries.countryname ASC"); 			 			    
					foreach($myrow as $row) { echo "<option servicedata='courier' value=$row->code> $row->countryname </option> ";}				
				?>
		</select>
      
    </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="basicsystem" name="basicsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else if($_REQUEST['lang']=='de'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else{ ?>Resender Basic System (DIY) Do it Yourself<?php } ?></label>
    <div class="basicsystem price"  style="text-align:right"> <span class="symbol"></span><span id="basicsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="appdashboard" name="appdashboard" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>App Dashboard <?php }else if($_REQUEST['lang']=='de'){ ?>App Dashboard <?php }else{ ?>App Dashboard<?php } ?></label>
    <div class="appdashboardprice price" style="display:none;text-align:right"> <span class="symbol"> </span><span id="appdashboardprice" > </span> </div>
  </div>
  
  <div class="form-group">
    <input type="checkbox" id="addinstall" name="addinstall" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Installation Basic system by us<?php }else if($_REQUEST['lang']=='de'){ ?>In Installationskosten <?php }else{ ?>Voeg installatiekosten<?php } ?></label>
    <div class="price addinstallprice" style="display:none;"> <span class="symbol"> </span><span  id="addinstallprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="separatestand" name="separatestand" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Separate Outsite Stand <?php }else if($_REQUEST['lang']=='de'){ ?>Separate Outsite StÃƒÂ¤nder <?php }else{ ?>Aparte Outsite Stand<?php } ?></label>
    <div class="price separatestandprice" style="display:none;"> <span class="symbol"> </span><span id="separatestandprice" > </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"  id="optionnewspaper" value="" name="optionnewspaper"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Newspaper option<?php }else if($_REQUEST['lang']=='de'){ ?>Option Zeitung <?php }else{ ?>optie krant<?php } ?></label>
    <div class="price optionnewspaperprice" style="display:none;"> <span class="symbol"> </span><span id="optionnewspaperprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="isolatedhousing" value="" name="isolatedhousing"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Isolated Housing <?php }else if($_REQUEST['lang']=='de'){ ?>getrennt GehÃƒÂ¤use <?php }else{ ?>geÃƒÂ¯soleerde Housing<?php } ?></label>
    <div class="price isolatedhousingprice" style="display:none;"> <span class="symbol"> </span><span  id="isolatedhousingprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="colorhousing"  name="colorhousing1" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Colour of your personal choice <?php }else if($_REQUEST['lang']=='de'){ ?>Farbe GehÃƒÂ¤use <?php }else{ ?>Kleur Behuizing<?php } ?></label>
    <div class="price colorhousingprice" style="display:none;"> <span class="symbol"> </span><span id="colorhousingprice"> </span> </div>
  </div>
   <div class="form-group">
    <input type="checkbox" id="housingprint"  name="housingprint" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Housing Print Option <?php }else if($_REQUEST['lang']=='de'){ ?>Housing Print Option <?php }else{ ?>Housing Print Option<?php } ?></label>
    <div class="price housingprintprice" style="display:none;"> <span class="symbol"> </span><span id="housingprintprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="enlargementmailbox"  name="enlargementmailbox" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Enlargement Piece Mailbox <?php }else if($_REQUEST['lang']=='de'){ ?>
Erweiterung Piece Mailbox <?php }else{ ?>Uitbreiding Piece Mailbox<?php } ?></label>
    <div class="price enlargementmailboxprice" style="display:none;"> <span class="symbol"> </span><span id="enlargementmailboxprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="totaloption" name="totaloption" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total Options<?php }else if($_REQUEST['lang']=='de'){ ?>insgesamt Optionen<?php }else{ ?>Totaal Opties<?php } ?></label>
    <div class="price upborder"> <span class="symbol"> </span><span id="totaloptionprice"> </span> </div>
  </div>
  <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="symbols" name="symbols" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="currency_code" name="currency_codes" style="opacity:0;" checked/>
  <div class="form-group">
    <input type="checkbox" value=""  id="oneoffcontribute" name="oneoffcontribute" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>One of Contribution <?php }else if($_REQUEST['lang']=='de'){ ?>ONE OFF Beitrag <?php }else{ ?>Eenmalige bijdrage<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="oneoffcontributeprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>VAT Charges <?php }else if($_REQUEST['lang']=='de'){ ?>
Vat GebÃ¯Â¿Â½hren  <?php }else{ ?>BTW-heffing <?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="vatchargesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total System (including vat) <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="totalsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="" name="preorderfees" id="preorderfees" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Pre Order Fees   <?php }else if($_REQUEST['lang']=='de'){ ?>Pre Order GebÃƒÂ¼hren (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Pre order kosten (inclusief BTW)<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="preorderfeesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="monthlysub" name="monthlysub" style="opacity:0;" checked/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Exclusively Monthly Subscriptions <?php }else if($_REQUEST['lang']=='de'){ ?>AusschlieÃƒÅ¸lich Monatliche Abos <?php }else{ ?>Exclusief maandelijkse abonnementen<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="monthlysubprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="yes"  id="newsletterbox" name="newsletterbox"/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Newsletter Subscription <?php }else if($_REQUEST['lang']=='de'){ ?>Newsletter abonnieren <?php }else{ ?>Nieuwsbrief abonnement<?php } ?></label>
    <div class="price"> </div>
  </div>
  <div class="form-group accept">
    <input type="checkbox" value="accept" id="accept"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Accept our terms and conditions <?php }else if($_REQUEST['lang']=='de'){ ?>Akzeptieren Sie unsere Allgemeinen GeschÃƒÂ¤ftsbedingungen <?php }else{ ?>Accepteer onze algemene voorwaarden<?php } ?></label>
  </div>
  <div class="form-group">
    <button type="button" value="Input Your Data"  id="featureform"><?php if($_REQUEST['lang']=='en'){ ?>Input Your Data <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre Daten <?php }else{ ?>Voer uw gegevens<?php } ?></button>
  </div>
  </div>
  <div class="infoform" id="info_form">
  <h2> <?php if($_REQUEST['lang']=='en'){ ?>Enter Your Personal Details <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre persÃƒÂ¶nlichen Daten <?php }else{ ?>Geef uw persoonlijke gegevens<?php } ?></h2>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>First Name <?php }else if($_REQUEST['lang']=='de'){ ?>Vorname <?php }else{ ?>Voornaam<?php } ?></label>
    <input type="text" name="firstname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Last Name <?php }else if($_REQUEST['lang']=='de'){ ?>Nachname <?php }else{ ?>Achternaam<?php } ?></label>
    <input type="text" name="lastname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Contact Number <?php }else if($_REQUEST['lang']=='de'){ ?>Kontakt Nummer <?php }else{ ?>Contact nummer<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="phone" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Email <?php }else if($_REQUEST['lang']=='de'){ ?>Basic System <?php }else{ ?>e-mail<?php } ?></label>
    <input type="email" name="email"  required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Address <?php }else if($_REQUEST['lang']=='de'){ ?>Anschrift <?php }else{ ?>
adres<?php } ?></label>
    <textarea name="address" required></textarea>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Zip Code <?php }else if($_REQUEST['lang']=='de'){ ?>PLZ <?php }else{ ?>Postcode<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="zipcode" required/>
  </div>
  <div class="form-group"><?php  echo do_shortcode( '[bws_google_captcha]' );?> </div>
  <div class="form-group">


    <input type="submit" value="<?php if($_REQUEST['lang']=='en'){ ?>Pay Now <?php }else if($_REQUEST['lang']=='de'){ ?>Jetzt bezahlen <?php }else{ ?>Nu betalen<?php } ?>" name="featureform" id="infosubmit"/>
  </div>


</div>
</form></div><div style="float:right;width:37%"><img src="<?php echo dataload; ?>/images/special.png"></div>
<?php
				if(isset($_REQUEST['featureform']))					
				{					
				 	if(isset($_REQUEST['addcountry'])) {$countryid=$_REQUEST["addcountry"]; }
					if(isset($_REQUEST['basicsystem'])) {$basicsystem=$_REQUEST["basicsystem"]; }
					if(isset($_REQUEST['appdashboard'])) {$appdashboard=$_REQUEST["appdashboard"]; }
					if(isset($_REQUEST['separatestand'])) { $separatestand=$_REQUEST['separatestand']; }
					if(isset($_REQUEST['addinstall'])) { $addinstall=$_REQUEST['addinstall'];}				  			   
					if(isset($_REQUEST['optionnewspaper'])) { $optionnewspaper=$_REQUEST['optionnewspaper'];}
					if(isset($_REQUEST['isolatedhousing'])) {  $isolatedhousing=$_REQUEST['isolatedhousing'];}
					if(isset($_REQUEST['colorhousing1'])) { $colorhousing1=$_REQUEST['colorhousing1'];}
					if(isset($_REQUEST['housingprint'])) { $housingprint=$_REQUEST['housingprint'];}
				    if(isset($_REQUEST['enlargementmailbox'])) {$enlargementmailbox=$_REQUEST['enlargementmailbox'];}
					if(isset($_REQUEST['colorhousing1'])) {  $totaloption=$_REQUEST["totaloption"]; }
					if(isset($_REQUEST['totaloption'])) {   $vatcharges=$_REQUEST["vatcharges"]; }
					if(isset($_REQUEST['totalsystem'])) {  $totalsystem=$_REQUEST["totalsystem"]; }
					if(isset($_REQUEST['oneoffcontribute'])) {   $oneoffcontribute=$_REQUEST["oneoffcontribute"];}
					if(isset($_REQUEST['preorderfees'])) {   $preorderfees=$_REQUEST["preorderfees"];}
					if(isset($_REQUEST['monthlysub'])) {   $monthlysub=$_REQUEST["monthlysub"];}				 
					if(isset($_REQUEST['newsletterbox'])) {  $newsletterbox=$_REQUEST["newsletterbox"];}				 
					if(isset($_REQUEST['firstname'])) {$firstname=$_REQUEST['firstname'];}
					if(isset($_REQUEST['lastname'])) {$lastname=$_REQUEST['lastname'];}
					if(isset($_REQUEST['phone'])) {$phone=$_REQUEST['phone'];}
					if(isset($_REQUEST['email'])) {$email=$_REQUEST['email'];}
					if(isset($_REQUEST['address'])) {$address=$_REQUEST['address'];}
					if(isset($_REQUEST['zipcode'])) {$zipcode=$_REQUEST['zipcode'];} 
                    global $wpdb;
                    /*$myrow=$wpdb->query("insert into user_info values('','$countryid' , '$basicsystem','$separatestand' ,'$addinstall' ,'$optionnewspaper' ,'$isolatedhousing' ,'$colorhousing','$enlargementmailbox' ,'$totaloption', '$vatcharges' ,'$oneoffcontribute', '$totalsystem' ,'$preorderfees' , '$monthlysub' , '$newsletterbox','$firstname' ,'$lastname' ,'$phone','$email','$address','$zipcode',0)");					
					if($myrow>0)
					{	*/
						echo "<script> $('#viewfeatures').hide();</script>";				
						$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
						//$paypal_id='restroom256-facilitator@gmail.com'; 
                                                $paypal_id='anjo@resender.eu'; 
						$currency_input=$_REQUEST['totalsystem'];
						$symbols=$_REQUEST['symbols'];	
						$currency_from=$_REQUEST['currency_codes'];	
						$currency_to = "USD";
						$fromcurrency = $_REQUEST['addcountry'];
				$tocurrency = 'USD';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "http://download.finance.yahoo.com/d/quotes.csv?s=$fromcurrency$tocurrency=X&f=sl1&e=.csv");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			
				$content = curl_exec($curl);			
				curl_close($curl); 
				$value = substr(trim($content), 11, 6);
				$currency = $value*trim($currency_input);
				?>
						
<div class="viewpayment">
  <div class="image"> <img src="<?php echo dataload; ?>/images/logogif.gif"/> </div>
  <div class="viewprice"> <?php echo $symbols; echo  $currency_input; echo "changed Amount:USD".$currency ; echo "Deposit Amount:USD".ceil($currency);?> </div>
  <div class="btn">
    <form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
      <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="item_name" value="Resender Form">
      <input type="hidden" name="item_number" value="1">
    
      <input type="hidden" name="userid" value="1">
      <input type="hidden" name="amount" value="<?php echo ceil($currency); ?>">
      <input type="hidden" name="cpp_header_image" value="http://www.phpgang.com/wp-content/uploads/gang.jpg">
      <input type="hidden" name="no_shipping" value="1">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="handling" value="0">
      <input type="hidden" name="cancel_return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="hidden" name="return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
     <input type="hidden" name="notify_url" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>
<?php	
				/*}else { echo"<div class='errormsg'><p> Data is not saved </p></div>";}		*/			 
				}	
}
add_shortcode('resender-form-courier','resender_courier_form');

function resender_company_form()
{
?> 
<script type="text/javascript">
	$(document).ready(function(){
		$('#info_form').hide();
				
			
		$('#country').change(function(event){
			var country=$('#country').val();
            var servicedata= $(this).find(':selected').attr('servicedata')	
            		
          	$("#appdashboard, #separatestand, #addinstall , #optionnewspaper , #isolatedhousing, #colorhousing, #housingprint, #enlargementmailbox").removeAttr("checked");	
			$.ajax({
						url:'<?php echo dataload ; ?>/ajaxsearch.php?countryv='+country+'&servicedata='+servicedata,
						type:'GET',
						success:function(data)
						{
						var arr=data;
						 var ss= arr.split(",");
						 var basicsystem= ss[0];
						 var separatestand= ss[1];
						 var addinstall= ss[2];
						 var optionnewspaper= ss[3];
						 var isolatedhousing= ss[4];
						 var colorhousing= ss[5];
						 var enlargementmailbox= ss[6];
						 var vatcharges= ss[7];
						 var oneoffcontribute= ss[8];
						 var preorderfees= ss[9];
						 var monthlysub= ss[10];
						 var appdashboard= ss[11];
						 var housingprint= ss[12];
					     var symbol= country;
						 var currency_code= '';
						 var totaloption= basicsystem;					
						 var totalsystem=  parseInt(basicsystem) + parseInt(vatcharges) + parseInt(oneoffcontribute) ;
						$('.symbol').html(ss[13]);
                        $('#symbols').val(symbol);
                        $('#currency_code').val(currency_code);
						$('#basicsystemprice').html(basicsystem);						 
						$('#basicsystem').val(basicsystem);						 
						 $('#separatestandprice').html(separatestand);							  				
						 $('#addinstallprice').html(addinstall);						
						 $('#optionnewspaperprice').html(optionnewspaper);						 
						 $('#isolatedhousingprice').html(isolatedhousing);						
						 $('#colorhousingprice').html(colorhousing);							 					
						 $('#enlargementmailboxprice').html(enlargementmailbox);
						 $('#vatcharges').val(vatcharges);
						 $('#vatchargesprice').html(vatcharges);
						 $('#oneoffcontributeprice').html(oneoffcontribute);
						 $('#oneoffcontribute').val(oneoffcontribute);
						 $('#preorderfees').val(preorderfees);						
						 $('#preorderfeesprice').html(preorderfees);
						 $('#monthlysub').val(monthlysub);
						 $('#monthlysubprice').html(monthlysub);
						  $('#appdashboard').val(appdashboard);
						 $('#appdashboardprice').html(appdashboard);
						 $('#housingprint').val(housingprint);
						 $('#housingprintprice').html(housingprint);
						 $('#totalsystemprice').html(totalsystem);
						 $('#totalsystem').val(totalsystem);
						 $('#totaloptionprice').html(totaloption);						
						 $('#totaloption').val(totaloption);						
						},
						error:function(err){alert(err);}								 
					}); 			
		});			
		$('#separatestand').click(function(){
		   var sep=$('#separatestand').is(':checked');		   		    
		   if(sep==true)
		   {
		      $('.separatestandprice').show();
				var separatestandprice=$('#separatestandprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)+ parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val(separatestandprice);
		   }
		   else {
		   $('.separatestandprice').hide();
		   var separatestandprice=$('#separatestandprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(separatestandprice);
				var ss1=parseInt(totalsystem)- parseInt(separatestandprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#separatestand').val('');
				}			 
		});
		
			$('#appdashboard').click(function(){
		   var adddash=$('#appdashboard').is(':checked');		   		    
		   if(adddash==true)
		   {
				var appdashboardprice=$('#appdashboardprice').text();$('.appdashboardprice').show();					 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)+ parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val(appdashboardprice);
		   }
		   else {
           $('.appdashboardprice').hide();		   
		   var appdashboardprice=$('#appdashboardprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(appdashboardprice);
				var ss1=parseInt(totalsystem)- parseInt(appdashboardprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#appdashboard').val('');
				}			 
		});
		
		$('#housingprint').click(function(){
		   var housepr=$('#housingprint').is(':checked');		   		    
		   if(housepr==true)
		   {
		      $('.housingprintprice').show();	
				var housingprintprice=$('#housingprintprice').text();				 
				var addinstallprice=$('#addinstallprice').text();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)+ parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val(housingprintprice);
		   }
		   else { var housingprintprice=$('#housingprintprice').text();	$('.housingprintprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(housingprintprice);
				var ss1=parseInt(totalsystem)- parseInt(housingprintprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#housingprint').val('');
				}			 
		});
		
		$('#addinstall').click(function(){
		   var addinst=$('#addinstall').is(':checked');
		   if(addinst==true)
		   {
				var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)+ parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val(addinstallprice);
		   }
		   else { var addinstallprice=$('#addinstallprice').text();	$('.addinstallprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(addinstallprice);
				var ss1=parseInt(totalsystem)- parseInt(addinstallprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#addinstall').val('0');
				}
		});		
		$('#optionnewspaper').click(function(){
		   var optionnewspaper=$('#optionnewspaper').is(':checked');
		   if(optionnewspaper==true)
		   {
				var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)+ parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val(optionnewspaperprice);
		   }
		   else { var optionnewspaperprice=$('#optionnewspaperprice').text();	$('.optionnewspaperprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(optionnewspaperprice);
				var ss1=parseInt(totalsystem)- parseInt(optionnewspaperprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#optionnewspaper').val('0');
				}
		});
		$('#isolatedhousing').click(function(){
		   var optionnewspaper=$('#isolatedhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val(isolatedhousingprice);
		   }
		   else { var isolatedhousingprice=$('#isolatedhousingprice').text();	$('.isolatedhousingprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(isolatedhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(isolatedhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#isolatedhousing').val('');
				}
		});
		$('#colorhousing').click(function(){
		   var optionnewspaper=$('#colorhousing').is(':checked');
		   if(optionnewspaper==true)
		   {
				var colorhousingprice=$('#colorhousingprice').text();	$('.colorhousingprice').show();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)+ parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val(colorhousingprice);
		   }
		   else { var colorhousingprice=$('#colorhousingprice').text();$('.colorhousingprice').hide();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(colorhousingprice);
				var ss1=parseInt(totalsystem)- parseInt(colorhousingprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#colorhousing').val('noneed');
				}
		});
		$('#enlargementmailbox').click(function(){
		   var enlargementmailbox=$('#enlargementmailbox').is(':checked');
		   if(enlargementmailbox==true)
		   {
				var enlargementmailboxprice=$('#enlargementmailboxprice').text();$('.enlargementmailboxprice').show();				 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)+ parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)+ parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val(enlargementmailboxprice);
		   }
		   else { var enlargementmailboxprice=$('#enlargementmailboxprice').text();	$('.enlargementmailboxprice').hide();			 
				var totaloption=$('#totaloptionprice').text();
				var totalsystem=$('#totalsystemprice').text();
				var ss=parseInt(totaloption)- parseInt(enlargementmailboxprice);
				var ss1=parseInt(totalsystem)- parseInt(enlargementmailboxprice);
				$('#totaloptionprice').html(ss);
				$('#totaloption').val(ss);
				$('#totalsystemprice').html(ss1);
				$('#totalsystem').val(ss1);
				$('#enlargementmailbox').val('');
				}
		});
		$('#featureform').click(function(){
			var acceptoption=$('#accept').is(':checked');
			var country=$('#country').val();
		    if (country==0)
			{	alert('Please select country'); return false; }
			else if(acceptoption==true)
			{	$('#info_form').show('slow');  return true; }
			
			else { alert('Accept our terms & conditions'); return false;}
		});
		$('#accept').click(function(){
			var acceptoption=$('#accept').is(':checked');			 
		    if (acceptoption==true)
			{ }			
			else {$('#info_form').hide('slow');}
		});		
	});
	</script>
<div style="float:left;width:63%"><form action="" method="post">
<div class="viewfeatures" id="viewfeatures">
<h2> View Features </h2>

<h3>Company Pricing Form</h3>
  <div class="form-group">
    <label style="font-weight: bold; color: rgb(51, 51, 51); float: left; font-size: 16px ! important;"> Tick option boxes of your choice ! </label>
        <div class="price">
		<select name="addcountry" id="country">
                        <option value=""><?php if($_REQUEST['lang']=='en'){ ?>--select-- <?php }else if($_REQUEST['lang']=='de'){ ?>--auswÃƒÂ¤hlen-- <?php }else{ ?>--select--<?php } ?></option>
			 <?php  global $wpdb;            						
				 $myrow = $wpdb->get_results("select  countries.countryname , countries.code,countries.symbol from   countries order by countries.countryname ASC"); 			 			    
					foreach($myrow as $row) { echo "<option servicedata='company' value=$row->code> $row->countryname </option> ";}				
				?>
		</select>
      
    </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="basicsystem" name="basicsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else if($_REQUEST['lang']=='de'){ ?>Resender Basic System (DIY) Do it Yourself <?php }else{ ?>Resender Basic System (DIY) Do it Yourself<?php } ?></label>
    <div class="basicsystem price"  style="text-align:right"> <span class="symbol"></span><span id="basicsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="appdashboard" name="appdashboard" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>App Dashboard <?php }else if($_REQUEST['lang']=='de'){ ?>App Dashboard <?php }else{ ?>App Dashboard<?php } ?></label>
    <div class="appdashboardprice price" style="display:none;text-align:right"> <span class="symbol"> </span><span id="appdashboardprice" > </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="addinstall" name="addinstall" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Installation Basic system by us<?php }else if($_REQUEST['lang']=='de'){ ?>In Installationskosten <?php }else{ ?>Voeg installatiekosten<?php } ?></label>
    <div class="price addinstallprice" style="display:none;"> <span class="symbol"> </span><span  id="addinstallprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="separatestand" name="separatestand" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Separate Outsite Stand <?php }else if($_REQUEST['lang']=='de'){ ?>Separate Outsite StÃƒÂ¤nder <?php }else{ ?>Aparte Outsite Stand<?php } ?></label>
    <div class="price separatestandprice" style="display:none;"> <span class="symbol"> </span><span id="separatestandprice" > </span> </div>
  </div>
  
  <div class="form-group">
    <input type="checkbox"  id="optionnewspaper" value="" name="optionnewspaper"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Newspaper option<?php }else if($_REQUEST['lang']=='de'){ ?>Option Zeitung <?php }else{ ?>optie krant<?php } ?></label>
     <div class="price optionnewspaperprice" style="display:none;"> <span class="symbol"> </span><span id="optionnewspaperprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="isolatedhousing" value="" name="isolatedhousing"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Isolated Housing <?php }else if($_REQUEST['lang']=='de'){ ?>getrennt GehÃƒÂ¤use <?php }else{ ?>geÃƒÂ¯soleerde Housing<?php } ?></label>
    <div class="price isolatedhousingprice" style="display:none;"> <span class="symbol"> </span><span  id="isolatedhousingprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" id="colorhousing"  name="colorhousing1" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Colour of your personal choice <?php }else if($_REQUEST['lang']=='de'){ ?>Farbe GehÃƒÂ¤use <?php }else{ ?>Kleur Behuizing<?php } ?></label>
    <div class="price colorhousingprice" style="display:none;"> <span class="symbol"> </span><span id="colorhousingprice"> </span> </div>
  </div>
   <div class="form-group">
    <input type="checkbox" id="housingprint"  name="housingprint" value="noneed"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Housing Print Option <?php }else if($_REQUEST['lang']=='de'){ ?>Housing Print Option <?php }else{ ?>Housing Print Option<?php } ?></label>
     <div class="price housingprintprice" style="display:none;"> <span class="symbol"> </span><span id="housingprintprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox"   id="enlargementmailbox"  name="enlargementmailbox" value=""/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Enlargement Piece Mailbox <?php }else if($_REQUEST['lang']=='de'){ ?>
Erweiterung Piece Mailbox <?php }else{ ?>Uitbreiding Piece Mailbox<?php } ?></label>
    <div class="price enlargementmailboxprice" style="display:none;"> <span class="symbol"> </span><span id="enlargementmailboxprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="totaloption" name="totaloption" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total Options<?php }else if($_REQUEST['lang']=='de'){ ?>insgesamt Optionen<?php }else{ ?>Totaal Opties<?php } ?></label>
    <div class="price upborder"> <span class="symbol"> </span><span id="totaloptionprice"> </span> </div>
  </div>
  <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="symbols" name="symbols" style="opacity:0;" checked/>
  <input type="checkbox" value=""  id="currency_code" name="currency_codes" style="opacity:0;" checked/>
  <div class="form-group">
    <input type="checkbox" value=""  id="oneoffcontribute" name="oneoffcontribute" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>One of Contribution <?php }else if($_REQUEST['lang']=='de'){ ?>ONE OFF Beitrag <?php }else{ ?>Eenmalige bijdrage<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="oneoffcontributeprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="vatcharges" name="vatcharges" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>VAT Charges <?php }else if($_REQUEST['lang']=='de'){ ?>
Vat GebÃ¯Â¿Â½hren  <?php }else{ ?>BTW-heffing <?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span  id="vatchargesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  name="totalsystem" id="totalsystem" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Total System (including vat) <?php }else if($_REQUEST['lang']=='de'){ ?>Total System (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Total System (inclusief BTW)<?php } ?></label>
    <div class="price updownborder"> <span class="symbol"> </span><span  id="totalsystemprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="" name="preorderfees" id="preorderfees" style="opacity:0;" checked/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Pre Order Fees   <?php }else if($_REQUEST['lang']=='de'){ ?>Pre Order GebÃƒÂ¼hren (einschlieÃƒÅ¸lich Mehrwertsteuer) <?php }else{ ?>Pre order kosten (inclusief BTW)<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="preorderfeesprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value=""  id="monthlysub" name="monthlysub" style="opacity:0;" checked/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Exclusively Monthly Subscriptions <?php }else if($_REQUEST['lang']=='de'){ ?>AusschlieÃƒÅ¸lich Monatliche Abos <?php }else{ ?>Exclusief maandelijkse abonnementen<?php } ?></label>
    <div class="price"> <span class="symbol"> </span><span id="monthlysubprice"> </span> </div>
  </div>
  <div class="form-group">
    <input type="checkbox" value="yes"  id="newsletterbox" name="newsletterbox"/>
    <label> <?php if($_REQUEST['lang']=='en'){ ?>Newsletter Subscription <?php }else if($_REQUEST['lang']=='de'){ ?>Newsletter abonnieren <?php }else{ ?>Nieuwsbrief abonnement<?php } ?></label>
    <div class="price"> </div>
  </div>
  <div class="form-group accept">
    <input type="checkbox" value="accept" id="accept"/>
    <label><?php if($_REQUEST['lang']=='en'){ ?>Accept our terms and conditions <?php }else if($_REQUEST['lang']=='de'){ ?>Akzeptieren Sie unsere Allgemeinen GeschÃƒÂ¤ftsbedingungen <?php }else{ ?>Accepteer onze algemene voorwaarden<?php } ?></label>
  </div>
  <div class="form-group">
    <button type="button" value="Input Your Data"  id="featureform"><?php if($_REQUEST['lang']=='en'){ ?>Input Your Data <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre Daten <?php }else{ ?>Voer uw gegevens<?php } ?></button>
  </div>
  </div>
  <div class="infoform" id="info_form">
  <h2> <?php if($_REQUEST['lang']=='en'){ ?>Enter Your Personal Details <?php }else if($_REQUEST['lang']=='de'){ ?>Geben Sie Ihre persÃƒÂ¶nlichen Daten <?php }else{ ?>Geef uw persoonlijke gegevens<?php } ?></h2>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>First Name <?php }else if($_REQUEST['lang']=='de'){ ?>Vorname <?php }else{ ?>Voornaam<?php } ?></label>
    <input type="text" name="firstname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Last Name <?php }else if($_REQUEST['lang']=='de'){ ?>Nachname <?php }else{ ?>Achternaam<?php } ?></label>
    <input type="text" name="lastname" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Contact Number <?php }else if($_REQUEST['lang']=='de'){ ?>Kontakt Nummer <?php }else{ ?>Contact nummer<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="phone" required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Email <?php }else if($_REQUEST['lang']=='de'){ ?>Basic System <?php }else{ ?>e-mail<?php } ?></label>
    <input type="email" name="email"  required/>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Address <?php }else if($_REQUEST['lang']=='de'){ ?>Anschrift <?php }else{ ?>
adres<?php } ?></label>
    <textarea name="address" required></textarea>
  </div>
  <div class="form-group">
    <label><?php if($_REQUEST['lang']=='en'){ ?>Zip Code <?php }else if($_REQUEST['lang']=='de'){ ?>PLZ <?php }else{ ?>Postcode<?php } ?></label>
    <input type="tel" pattern="[0-9]*" name="zipcode" required/>
  </div>
  <div class="form-group"><?php  echo do_shortcode( '[bws_google_captcha]' );?> </div>
  <div class="form-group">


    <input type="submit" value="<?php if($_REQUEST['lang']=='en'){ ?>Pay Now <?php }else if($_REQUEST['lang']=='de'){ ?>Jetzt bezahlen <?php }else{ ?>Nu betalen<?php } ?>" name="featureform" id="infosubmit"/>
  </div>
  </div>
</form>
</div><div style="float:right;width:37%"><img src="<?php echo dataload; ?>/images/special.png"></div>

<?php
				if(isset($_REQUEST['featureform']))					
				{					
				 	if(isset($_REQUEST['addcountry'])) {$countryid=$_REQUEST["addcountry"]; }
					if(isset($_REQUEST['basicsystem'])) {$basicsystem=$_REQUEST["basicsystem"]; }
					if(isset($_REQUEST['appdashboard'])) {$appdashboard=$_REQUEST["appdashboard"]; }
					if(isset($_REQUEST['separatestand'])) { $separatestand=$_REQUEST['separatestand']; }
					if(isset($_REQUEST['addinstall'])) { $addinstall=$_REQUEST['addinstall'];}				  			   
					if(isset($_REQUEST['optionnewspaper'])) { $optionnewspaper=$_REQUEST['optionnewspaper'];}
					if(isset($_REQUEST['isolatedhousing'])) {  $isolatedhousing=$_REQUEST['isolatedhousing'];}
					if(isset($_REQUEST['colorhousing1'])) { $colorhousing1=$_REQUEST['colorhousing1'];}
					if(isset($_REQUEST['housingprint'])) { $housingprint=$_REQUEST['housingprint'];}
				    if(isset($_REQUEST['enlargementmailbox'])) {$enlargementmailbox=$_REQUEST['enlargementmailbox'];}
					if(isset($_REQUEST['colorhousing1'])) {  $totaloption=$_REQUEST["totaloption"]; }
					if(isset($_REQUEST['totaloption'])) {   $vatcharges=$_REQUEST["vatcharges"]; }
					if(isset($_REQUEST['totalsystem'])) {  $totalsystem=$_REQUEST["totalsystem"]; }
					if(isset($_REQUEST['oneoffcontribute'])) {   $oneoffcontribute=$_REQUEST["oneoffcontribute"];}
					if(isset($_REQUEST['preorderfees'])) {   $preorderfees=$_REQUEST["preorderfees"];}
					if(isset($_REQUEST['monthlysub'])) {   $monthlysub=$_REQUEST["monthlysub"];}				 
					if(isset($_REQUEST['newsletterbox'])) {  $newsletterbox=$_REQUEST["newsletterbox"];}				 
					if(isset($_REQUEST['firstname'])) {$firstname=$_REQUEST['firstname'];}
					if(isset($_REQUEST['lastname'])) {$lastname=$_REQUEST['lastname'];}
					if(isset($_REQUEST['phone'])) {$phone=$_REQUEST['phone'];}
					if(isset($_REQUEST['email'])) {$email=$_REQUEST['email'];}
					if(isset($_REQUEST['address'])) {$address=$_REQUEST['address'];}
					if(isset($_REQUEST['zipcode'])) {$zipcode=$_REQUEST['zipcode'];} 
                    global $wpdb;
                    /*$myrow=$wpdb->query("insert into user_info values('','$countryid' , '$basicsystem','$separatestand' ,'$addinstall' ,'$optionnewspaper' ,'$isolatedhousing' ,'$colorhousing','$enlargementmailbox' ,'$totaloption', '$vatcharges' ,'$oneoffcontribute', '$totalsystem' ,'$preorderfees' , '$monthlysub' , '$newsletterbox','$firstname' ,'$lastname' ,'$phone','$email','$address','$zipcode',0)");					
					if($myrow>0)
					{	*/
						echo "<script> $('#viewfeatures').hide();</script>";				
						$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
						//$paypal_id='restroom256-facilitator@gmail.com'; 
                                                $paypal_id='anjo@resender.eu'; 
						$currency_input=$_REQUEST['totalsystem'];
						$symbols=$_REQUEST['symbols'];	
						$currency_from=$_REQUEST['currency_codes'];	
						$currency_to = "USD";
						$fromcurrency = $_REQUEST['addcountry'];
				$tocurrency = 'USD';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "http://download.finance.yahoo.com/d/quotes.csv?s=$fromcurrency$tocurrency=X&f=sl1&e=.csv");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			
				$content = curl_exec($curl);			
				curl_close($curl); 
				$value = substr(trim($content), 11, 6);
				$currency = $value*trim($currency_input);
				?>
						
<div class="viewpayment">
  <div class="image"> <img src="<?php echo dataload; ?>/images/logogif.gif"/> </div>
  <div class="viewprice"> <?php echo $symbols; echo  $currency_input; echo "changed Amount:USD".$currency ; echo "Deposit Amount:USD".ceil($currency);?> </div>
  <div class="btn">
    <form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
      <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="item_name" value="Resender Form">
      <input type="hidden" name="item_number" value="1">
    
      <input type="hidden" name="userid" value="1">
      <input type="hidden" name="amount" value="<?php echo ceil($currency); ?>">
      <input type="hidden" name="cpp_header_image" value="http://www.phpgang.com/wp-content/uploads/gang.jpg">
      <input type="hidden" name="no_shipping" value="1">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="handling" value="0">
      <input type="hidden" name="cancel_return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="hidden" name="return" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
     <input type="hidden" name="notify_url" value="https://resender.eu/delivery/wp-content/themes/Delivery/paypal.php">
      <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>
<?php	
				/*}else { echo"<div class='errormsg'><p> Data is not saved </p></div>";}		*/			 
				}	
}
add_shortcode('resender-form-company','resender_company_form'); 
