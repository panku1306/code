<?php
include_once dirname(dirname(dirname(__FILE__))).'/_inc.php';

$id = $_GET['id'];

if ($_POST) {
    $err=0;

    while (list($index,$ob) = each($_POST)) {
        $info[$index] = ms($ob);
    }

    if (!$info['incident_date']) $err+=1;
    if (!$info['incident_time']) $err+=2;
    if (!$info['location']) $err+=4;
    if (!$info['date_reported']) $err+=8;
    if (!$info['first_name']) $err+=16;
    if (!$info['last_name']) $err+=32;
    if (!$info['dob']) $err+=64;
    if (!$info['age']) $err+=128;
    if (!$info['contact_number']) $err+=256;
    if (!$info['occupation']) $err+=512;
    
    if (!$err) {

        $query = "SELECT id FROM application WHERE first_name='".$info['first_name']."' AND last_name ='".$info['last_name']."' AND dob = '".date('Y-m-d', strtotime($info['dob']))."' AND status IN('submitted', 'approved') ORDER BY id DESC LIMIT 1";

        $result = mysqli_query($db,$query);
        $rows = mysqli_num_rows($result);

        if($rows==1){
            while ($ob = mysqli_fetch_array($result)) {
                $matches[] = $ob;
            }

            $application_id = $matches[0]['id'];
        }
        else{
            $application_id = $info['application_id'];
        }

         # Set upload directory
        $dir = dirname(dirname(dirname(__FILE__)))."/attachments/incident";
        # Getting file extension
        /*if(isset($_FILES['upload']['name']) && count($_FILES['upload']['name']) > 0){
             //Loop through each file
            for($i=0; $i<count($_FILES['upload']['name']); $i++) {

                $image_mime = strtolower(image_type_to_mime_type(exif_imagetype($_FILES["upload"]["tmp_name"][$i])));
                $ext = explode("/", strtolower($image_mime));
                $ext = strtolower(end($ext));
                $filename = rand(10000, 990000) . '_' . time() . '.' . $ext;
              //Upload the file into the temp dir
              if(move_uploaded_file($_FILES['upload']['tmp_name'][$i],$dir."/".$filename)){
                  chmod($dir."/".$filename, 0755);
                  $files[] = $filename;
                  
                  $sql = "UPDATE incident_investigation SET 
                    incident_date = '".date('Y-m-d', strtotime($info['incident_date']))."',
                    employee =  '$application_id',
                    incident_time = '".$info['incident_time']."',
                    location = '".$info['location']."',
                    date_reported = '".date('Y-m-d', strtotime($info['date_reported']))."',
                    first_name = '".$info['first_name']."',
                    last_name = '".$info['last_name']."',
                    dob = '".date('Y-m-d', strtotime($info['dob']))."',
                    age = '".$info['age']."',
                    contact_number = '".$info['contact_number']."',
                    occupation = '".$info['occupation']."',
                    file='".implode(",",$files)."',
                    form_data = '".mysqli_real_escape_string($db,serialize($_POST))."'
                    WHERE id='".$id."'";

                $result = mysqli_query($db,$sql) or die(mysqli_error());
                if($result){

                    $_SESSION['success_msg'] = "Initial Investigation form has been Updated.";

                    header('Location:/incident_investigation/incident.php?id='.$id);
                    exit;
                }else{
                    $_SESSION['error_msg'] = "Some thing error";
                }

              }
            }    
        }*/

         # Set upload directory
        $dir = dirname(dirname(dirname(__FILE__)))."/attachments/incident";
        # Getting file extension
        if(count($_FILES['upload']['name']) > 0){
                //Loop through each file
            for($i=0; $i<count($_FILES['upload']['name']); $i++) {

                $image_mime = strtolower(image_type_to_mime_type(exif_imagetype($_FILES["upload"]["tmp_name"][$i])));
                $ext = explode("/", strtolower($image_mime));
                $ext = strtolower(end($ext));
                $filename = rand(10000, 990000) . '_' . time() . '.' . $ext;
              //Upload the file into the temp dir
              if(move_uploaded_file($_FILES['upload']['tmp_name'][$i],$dir."/".$filename)){
                  chmod($dir."/".$filename, 0755);
                  $files[] = $filename;
              }
            }    
        }


        if(isset($_FILES['upload']['name'])){ 
            /*$sql = "UPDATE incident_investigation SET 
                    incident_date = '".date('Y-m-d', strtotime($info['incident_date']))."',
                    employee =  '$application_id',
                    incident_time = '".$info['incident_time']."',
                    location = '".$info['location']."',
                    date_reported = '".date('Y-m-d', strtotime($info['date_reported']))."',
                    first_name = '".$info['first_name']."',
                    last_name = '".$info['last_name']."',
                    dob = '".date('Y-m-d', strtotime($info['dob']))."',
                    age = '".$info['age']."',
                    contact_number = '".$info['contact_number']."',
                    occupation = '".$info['occupation']."',
                    file='".implode(",",$files)."',
                    form_data = '".mysqli_real_escape_string($db,serialize($_POST))."'
                    WHERE id='".$id."'";

                $result = mysqli_query($db,$sql) or die(mysqli_error());
                if($result){

                    $_SESSION['success_msg'] = "Initial Investigation form has been Update.";

                    header('Location:/incident_investigation/incident.php?id='.$id);
                    exit;
                }else{
                    $_SESSION['error_msg'] = "Some thing error";
                }*/

                 $_SESSION['success_msg'] = "Initial Investigation form has been Update.";

               // echo "img updated";
        }




        else{
               $sql = "UPDATE incident_investigation SET 
                    incident_date = '".date('Y-m-d', strtotime($info['incident_date']))."',
                    employee =  '$application_id',
                    incident_time = '".$info['incident_time']."',
                    location = '".$info['location']."',
                    date_reported = '".date('Y-m-d', strtotime($info['date_reported']))."',
                    first_name = '".$info['first_name']."',
                    last_name = '".$info['last_name']."',
                    dob = '".date('Y-m-d', strtotime($info['dob']))."',
                    age = '".$info['age']."',
                    contact_number = '".$info['contact_number']."',
                    occupation = '".$info['occupation']."',
                    form_data = '".mysqli_real_escape_string($db,serialize($_POST))."'
                    WHERE id='".$id."'";

                $result = mysqli_query($db,$sql) or die(mysqli_error());

                if($result){

                    $_SESSION['success_msg'] = "Initial Investigation form has been Updated.";

                    header('Location:/incident_investigation/incident.php?id='.$id);
                    exit;
                }else{
                    $_SESSION['error_msg'] = "Some thing error";
                 }
        } 

    }
}


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = 'SELECT * FROM incident_investigation WHERE id='.$id;

    $re = mysqli_query($db, $sql);
    if(mysqli_num_rows($re)>0){
        $info  = mysqli_fetch_array($re);
        foreach(unserialize($info['form_data']) as $key=>$val){
            $info[$key] = $val;
        }
    }
}

include_once dirname(dirname(dirname(__FILE__))).'/_head.php';
?>

<hr>
<div id="frame" style="height: auto;">
    <h3 class="ttext">Incident Investigation Form</h3>
    <?php if (isset($_SESSION['success_msg'])){ ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php 
        echo $_SESSION['success_msg'];
        unset($_SESSION['success_msg']); 
        ?>
    </div>
    <?php } elseif ($_SESSION['error_msg']) { ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php 
        echo $_SESSION['error_msg'];
        unset($_SESSION['error_msg']); 
        ?>
    </div>
    <?php } ?>

    <form  class="col-lg-12 form-horizontal" id="ins_frm" name="ins_frm" method="post" action=""  enctype="multipart/form-data">
         <fieldset>
            <div id="personal_edit" >
                <input type="hidden" name="application_id" value="<?php echo $info['employee']; ?>"/>

                <h4 class="header">PARTICULARS OF INCIDENT</h4>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Incident Date:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                               <input id="incident_date" type="text" name="incident_date" value="<?php echo $info['incident_date']>0?date("m/d/Y",strtotime($info['incident_date'])):""?>" class="form-control" placeholder="MM/DD/YYYY" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6">
                                <span class="en">Time:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-3">
                                <input id="incident_time" type="text" name="incident_time" value="<?php echo $info['incident_time']>0?date("h:i:s",strtotime($info['incident_time'])):""?>" class="form-control" placeholder="H:I:S" >
                            </div>
                            <div class="col-sm-3">
                                <label>
                                    <input type="radio" name="am_pm" id="am_pm" style="float: left;" value="am" <?php echo ($info['am_pm'] == 'am') ? " checked" : ""; ?>>
                                    <span style="float: right;">&nbsp;AM</span>
                                </label>
                                <label style="margin-right: 5px;">
                                    <input type="radio" name="am_pm" id="am_pm" style="float: left;" value="pm" <?php echo ($info['am_pm'] == 'pm') ? " checked" : ""; ?>>
                                    <span style="float: right;">&nbsp;PM</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Location:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                               <input type="text" name="location" id="location" placeholder="" class="form-control"  value="<?php echo $info['location'] ; ?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                              <label style="margin-right: 12px;"  class="col-sm-6">
                                    <input type="checkbox" name="cmp_permises" id="cmp_permises" value="cmp_permises" <?php echo ($info['cmp_permises'] == 'cmp_permises') ? " checked" : ""; ?>>&nbsp; Company Premises
                                </label>
                            <div class="col-sm-5">
                                <label style="margin-right: 12px;">
                                    <input type="checkbox" name="j_site" id="j_site" value="job_site" <?php echo ($info['j_site'] == 'job_site') ? " checked" : ""; ?>>&nbsp; Job Site
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Supervisor:</span>
                            </label>
                            <div class="col-sm-5">
                               <input type="text" name="supervisor" id="supervisor" class="form-control" value="<?php echo $info['supervisor']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Date Reported:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                                <input id="date_reported" type="text" name="date_reported" value="<?php echo $info['date_reported']>0?date("m/d/Y",strtotime($info['date_reported'])):""?>" class="form-control" placeholder="MM/DD/YYYY" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr">&nbsp;<br></div>

                <h4 class="header">REPORTING THE INCIDENT</h4>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">First Name:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $info['first_name']; ?>">
                            </div>                          
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Last Name:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $info['last_name']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Date Of Birth:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="dob" id="dob"  value="<?php echo $info['dob']>0?date("m/d/Y",strtotime($info['dob'])):""?>" class="form-control" placeholder="MM/DD/YYYY">
                            </div>                          
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Age:</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="age" id="age" class="form-control" value="<?php echo $info['age']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="form-group">
                        <label class="col-sm-5 control-label">
                            <span class="en">Address:</span>
                        </label>
                    </div>              
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="inc_addr" id="inc_addr" class="form-control" rows="5" cols="50"><?php echo $info['inc_addr']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Phone Number:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                               <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php echo $info['contact_number']; ?>">
                            </div>                          
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Job title or occupation:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="occupation" id="occupation" class="form-control" value="<?php echo $info['occupation']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Hire Date:</span>
                            </label>
                            <div class="col-sm-5">
                               <input type="text" name="h_date" id="h_date" class="form-control" placeholder="MM/DD/YYYY" value="<?php if($info['h_date'] != '') echo $info['h_date']; ?>">
                            </div>                          
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">How long at this assignment:</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="time_period" id="time_period" class="form-control" value="<?php echo $info['time_period']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">What was employee doing when incident occurred?  What machine or tool?   What operation?</span>
                        </label>
                    </div>              
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="inc_addr" id="inc_addr" class="form-control" rows="5" cols="50"><?php echo $info['inc_addr']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-8 nopad">
                        <span class="en" style="float: left;margin-right: 12px;">Is an injury alleged to have occurred in connection with the reported incident?</span>
                    </label>
                    <div class="col-sm-4 nopad">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="repo_inc" id="repo_inc" style="float: left;" value="yes" <?php echo ($info['repo_inc'] == 'yes') ? " checked" : ""; ?>>
                            <span style="float: right;">Yes</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="repo_inc" id="repo_inc" style="float: left;" value="no" <?php echo ($info['repo_inc'] == 'no') ? " checked" : ""; ?>>
                            <span style="float: right;">No</span>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">If YES, who was allegedly injured?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="allegedly_injry" id="allegedly_injry" class="form-control" rows="5" cols="50"><?php echo $info['allegedly_injry']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-5 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">Has injury been confirmed?</span>
                    </label>
                    <div class="col-sm-6 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="conf_injry" id="conf_injry" style="float: left;" value="yes" <?php echo ($info['conf_injry'] == 'yes') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Yes</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="conf_injry" id="conf_injry" style="float: left;" value="no" <?php echo ($info['conf_injry'] == 'no') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;No</span>
                        </label>
                    
                        <label style="margin-right: 12px;">
                            <input type="radio" name="conf_injry" id="conf_injry" style="float: left;" value="can_not_confrm" <?php echo ($info['conf_injry'] == 'can_not_confrm') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Cannot Confirm</span>
                        </label>                           
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">If injury has NOT been confirmed, explain why?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="injry_nt_confrm" id="injry_nt_confrm" class="form-control" rows="5" cols="50"><?php echo $info['injry_nt_confrm']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-3 nopad" style="padding-left: 0px;">
                        <label>
                            <span style="float: left;margin-right: 12px;" class="en">Type of injury alleged:</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury" id="type_injury" style="float: left;" value="sprain" <?php echo ($info['type_injury'] == 'sprain') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Strain/sprain</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury1" id="type_injury1" style="float: left;" value="amputation" <?php echo ($info['type_injury1'] == 'amputation') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Amputation</span>
                        </label><br/>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury2" id="type_injury2" style="float: left;" value="laceration" <?php echo ($info['type_injury2'] == 'laceration') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Laceration/cut</span>
                        </label>
                    </div>
                    <div class="col-sm-2 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury3" id="type_injury3" style="float: left;" value="bruising" <?php echo ($info['type_injury3'] == 'bruising') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Bruising</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury4" id="type_injury4" style="float: left;" value="internal" <?php echo ($info['type_injury4'] == 'internal') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Internal</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury5" id="type_injury5" style="float: left;" value="fracture" <?php echo ($info['type_injury5'] == 'fracture') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Fracture</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury6" id="type_injury6" style="float: left;" value="dislocation" <?php echo ($info['type_injury6'] == 'dislocation') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Dislocation</span>
                        </label>
                    </div>
                    <div class="col-sm-3 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury7" id="type_injury7" style="float: left;" value="chemical_reaction" <?php echo ($info['type_injury7'] == 'chemical_reaction') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Chemical reaction</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury8" id="type_injury8" style="float: left;" value="abrasion" <?php echo ($info['type_injury8'] == 'abrasion') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Scratch/abrasion</span>
                        </label></br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury9" id="type_injury9" style="float: left;" value="foreign_body" <?php echo ($info['type_injury9'] == 'foreign_body') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Foreign body</span>
                        </label>
                        </br>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury10" id="type_injury10" style="float: left;" value="burn_scald" <?php echo ($info['type_injury10'] == 'burn_scald') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Burn scald</span>
                        </label>
                    </div>
                    <div class="col-sm-3 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="type_injury11" id="type_injury11" style="float: left;" value="other" <?php echo ($info['type_injury11'] == 'other') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Other (specify)</span>
                        </label>
                    </div>
                </div>
                <div class="clr">&nbsp;</div> 
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6 nopad" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <span class="en">Part of body:</span>
                            </label>
                            <div class="col-sm-8">
                               <input type="text" name="body_part" id="body_part" placeholder="Part of body" class="form-control"  value="<?php echo $info['body_part']; ?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 nopad" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <span class="en">Remarks:</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="remark" id="remark" placeholder="Remarks" class="form-control"  value="<?php echo $info['remark']; ?>"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr">&nbsp;<br><br></div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-7 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">Has medical examination & treatment by a physician been rendered?</span>
                    </label>
                    <div class="col-sm-4 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="examin" id="examin" style="float: left;" value="yes" <?php echo ($info['examin'] == 'yes') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Yes</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="examin" id="examin" style="float: left;" value="no" <?php echo ($info['examin'] == 'no') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;No</span>
                        </label>                          
                    </div>
                </div> 
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">If YES, where, by whom and when:</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="where_whom" id="where_whom" class="form-control" rows="5" cols="50"><?php echo $info['where_whom']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">If YES, What was physician’s initial diagnosis and treatment?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="initial_diagnosis" id="initial_diagnosis" class="form-control" rows="5" cols="50"><?php echo $info['initial_diagnosis']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-5 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">If YES, What was physician’s initial duty determination?</span>
                    </label>
                    <div class="col-sm-7 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="physicians_duty" id="physicians_duty" style="float: left;" value="return_duty" <?php echo ($info['physicians_duty'] == 'return_duty') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Return to duty</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="physicians_duty1" id="physicians_duty1" style="float: left;" value="duty_restrct" <?php echo ($info['physicians_duty1'] == 'duty_restrct') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Duty with restrictions</span>
                        </label>
                    
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="physicians_duty2" id="physicians_duty2" style="float: left;" value="full_release_duty" <?php echo ($info['physicians_duty2'] == 'full_release_duty') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Full release from duty</span>
                        </label>                           
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">What treatment, if any, was provided?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="treatment" id="treatment" class="form-control" rows="5" cols="50"><?php echo $info['treatment']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-7 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">Did the physician write one or more prescriptions relating to the examination?</span>
                    </label>
                    <div class="col-sm-4 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="prescriptions" id="prescriptions" style="float: left;" value="yes" <?php echo ($info['prescriptions'] == 'yes') ? " checked" : ""; ?>>
                            <span style="float: right;">Yes</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="prescriptions" id="prescriptions" style="float: left;" value="no" <?php echo ($info['prescriptions'] == 'no') ? " checked" : ""; ?>>
                            <span style="float: right;">No</span>
                        </label>
                    
                        <label style="margin-right: 12px;">
                            <input type="radio" name="prescriptions" id="prescriptions" style="float: left;" value="n_a" <?php echo ($info['prescriptions'] == 'n_a') ? " checked" : ""; ?>>
                            <span style="float: right;">N/A</span>
                        </label>                           
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">If YES, what were the prescriptions (if known):</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="details_prescription" id="details_prescription" class="form-control" rows="5" cols="50"><?php echo $info['details_prescription']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-7 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">Was a post-accident drug screen rendered in accordance with company drug-free workplace policy?</span>
                    </label>
                    <div class="col-sm-4 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="post_accident" id="post_accident" style="float: left;" value="yes" <?php echo ($info['post_accident'] == 'yes') ? " checked" : ""; ?>>
                            <span style="float: right;">Yes</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="post_accident" id="post_accident" style="float: left;" value="no" <?php echo ($info['post_accident'] == 'no') ? " checked" : ""; ?>>
                            <span style="float: right;">No</span>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">Where and by whom was the drug screen sample collected?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="drug_collect" id="drug_collect" class="form-control" rows="5" cols="50"><?php echo $info['drug_collect']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-7 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">What was the method of collection?</span>
                    </label>
                    <div class="col-sm-4 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="method" id="method" style="float: left;" value="urine" <?php echo ($info['method'] == 'urine') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Urine</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="method1" id="method1" style="float: left;" value="blood" <?php echo ($info['method1'] == 'blood') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Blood</span>
                        </label>
                    
                        <label style="margin-right: 12px;">
                            <input type="checkbox" name="method2" id="method2" style="float: left;" value="other" <?php echo ($info['method2'] == 'other') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Other</span>
                        </label>                           
                    </div>
                </div>
                <div class="clr">&nbsp;<br></div>

                <h4 class="header">DAMAGED PROPERTY</h4>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">Property / material damaged:</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="material_damage" id="material_damage" class="form-control" rows="5" cols="50"><?php echo $info['material_damage']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">Nature of damage:</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="nature_damage" id="nature_damage" class="form-control" rows="5" cols="50"><?php echo $info['nature_damage']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <span class="en">Object/substance inflicting damage:</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="inflicting_damage" id="inflicting_damage" class="form-control" rows="5" cols="50"><?php echo $info['inflicting_damage']; ?></textarea>
                    </div>
                </div>
                <div class="clr">&nbsp;<br></div>

                <h4  class="header">THE INCIDENT AS REPORTED</h4>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">DESCRIPTION  Describe what reportedly happened.  Use of drawings, photos and diagrams may be included.</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="description" id="description" class="form-control" rows="5" cols="50"><?php echo $info['description']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">1. State the conditions prior to the event.  This includes status of task performed or equipment used.</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="state_conditn" id="state_conditn" class="form-control" rows="5" cols="50"><?php echo $info['state_conditn']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">2. What was the employee’s work assignment prior to the event?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="wrk_assgn" id="wrk_assgn" class="form-control" rows="5" cols="50"><?php echo $info['wrk_assgn']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">3. What work controls (procedures, work order, clearance, etc.) applied to the work assignment?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="wrk_control" id="wrk_control" class="form-control" rows="5" cols="50"><?php echo $info['wrk_control']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">4. List any noted equipment problems or inadequacies both before and after the event?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="equ_prblm" id="equ_prblm" class="form-control" rows="5" cols="50"><?php echo $info['equ_prblm']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">5. Explain if there are any procedure or work  instruction deficiencies associated with the event.</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="instrct_deficiency" id="instrct_deficiency" class="form-control" rows="5" cols="50"><?php echo $info['instrct_deficiency']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">6. What do you believe caused this event?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="cause" id="cause" class="form-control" rows="5" cols="50"><?php echo $info['cause']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">7. What recommendations do you have to prevent reoccurrence of this event?</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="prvnt_reoccurence" id="prvnt_reoccurence" class="form-control" rows="5" cols="50"><?php echo $info['prvnt_reoccurence']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">8. List others present or involved with this event.</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="list_involved" id="list_involved" class="form-control" rows="5" cols="50"><?php echo $info['list_involved']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                   <div class="form-group">
                        <label class="col-sm-10 control-label">
                            <span class="en">WITNESSES List name of any witnesses here.   Attach individual witness statements as obtained.</span>
                        </label>
                    </div> 
                </div>
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <textarea name="witnesses" id="witnesses" class="form-control" rows="5" cols="50"><?php echo $info['witnesses']; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-5 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">HOW SERIOUS COULD IT HAVE BEEN?</span>
                    </label>
                    <div class="col-sm-7 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="serious" id="serious" style="float: left;" value="serious" <?php echo ($info['serious1'] == 'serious') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Serious</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="serious" id="serious" style="float: left;" value="vryserious" <?php echo ($info['serious'] == 'vryserious') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Very serious</span>
                        </label>                    
                        <label style="margin-right: 12px;">
                            <input type="radio" name="serious" id="serious" style="float: left;" value="serious2" <?php echo ($info['serious'] == 'serious2') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp;Not Serious</span>
                        </label>                           
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <label class="col-sm-5 nopad">
                        <span style="float: left;margin-right: 12px;" class="en">WHAT IS THE CHANCE OF IT HAPPENING AGAIN?</span>
                    </label>
                    <div class="col-sm-7 nopad" style="padding-left: 0px;">
                        <label style="margin-right: 12px;">
                            <input type="radio" name="chance_happng" id="chance_happng" style="float: left;" value="frequent" <?php echo ($info['chance_happng'] == 'frequent') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Frequent</span>
                        </label>
                        <label style="margin-right: 12px;">
                            <input type="radio" name="chance_happng" id="chance_happng" style="float: left;" value="occasional" <?php echo ($info['chance_happng'] == 'occasional') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Occasional</span>
                        </label>
                        
                        <label style="margin-right: 12px;">
                            <input type="radio" name="chance_happng" id="chance_happng" style="float: left;" value="rare" <?php echo ($info['chance_happng'] == 'rare') ? " checked" : ""; ?>>
                            <span style="float: right;">&nbsp; Rare</span>
                        </label>                           
                    </div>
                </div>
                <div class="clr">&nbsp;</div>

                <h4 class="header">PREVENTION</h4>
                <div class="col-sm-12 nopad">
                    <table>
                        <tr>
                            <th class="col-sm-6 nopad">What specific action has or will be taken to prevent a recurrence? Check items already actioned. Use additional pages if required.</th>
                            <th class="col-sm-3 nopad">By whom</th>
                            <th class="col-sm-3 nopad">When</th>
                        </tr>
                        <tr>
                            <td class="col-sm-6 nopad">
                                <input type="text" name="spcf_action" id="spcf_action"  class="form-control" value="<?php echo $info['spcf_action'] ; ?>">
                                </br>
                                <input type="text" name="spcf_action1" id="spcf_action1"  class="form-control"  value="<?php echo $info['spcf_action1'] ; ?>">
                                </br>
                                <input type="text" name="spcf_action2" id="spcf_action2" class="form-control"  value="<?php echo $info['spcf_action2'] ; ?>">
                                </br>
                                <input type="text" name="spcf_action3" id="spcf_action3" class="form-control"  value="<?php echo $info['spcf_action3'] ; ?>">
                            </td>
                            <td class="col-sm-3 nopad">
                                <input type="text" name="by_whom" id="by_whom"  class="form-control"  value="<?php echo $info['by_whom'] ; ?>">
                                </br>
                                <input type="text" name="by_whom1" id="by_whom1"  class="form-control"  value="<?php echo $info['by_whom1'] ; ?>">
                                </br>
                                <input type="text" name="by_whom2" id="by_whom2" class="form-control"  value="<?php echo $info['by_whom2'] ; ?>">
                                </br>
                                <input type="text" name="by_whom3" id="by_whom3" class="form-control"  value="<?php echo $info['by_whom3'] ; ?>">
                            </td>
                            <td class="col-sm-3 nopad">
                                <input type="text" name="whn" id="whn"  class="form-control"  value="<?php echo $info['whn'] ; ?>">
                                </br>
                                <input type="text" name="whn1" id="whn1"  class="form-control"  value="<?php echo $info['whn1'] ; ?>">
                                </br>
                                <input type="text" name="whn2" id="whn2" class="form-control"  value="<?php echo $info['whn2'] ; ?>">
                                </br>
                                <input type="text" name="whn3" id="whn3" class="form-control"  value="<?php echo $info['whn3'] ; ?>">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clr">&nbsp;</div>
                <div class="clr">&nbsp;</div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-7 control-label">
                                <span class="en">Report prepared & submitted by:</span>
                                <span class="error">*</span>
                            </label>
                            <div class="col-sm-5">
                               <input type="text" name="repo_prepared" id="repo_prepared" class="form-control" value="<?php echo $info['repo_prepared']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-7 control-label">
                                <span class="en">With review by:</span>
                            </label>
                            <div class="col-sm-5">
                               <input id="revw" type="text" name="revw" value="Pending" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <span class="en">Date:</span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="witns_date" id="witns_date" class="form-control" placeholder="MM/DD/YYYY" value="<?php if($info['witns_date'] != '') echo $info['witns_date']; ?>">
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Witness Statement:</span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <textarea name="witns_statement" id="witns_statement" class="form-control" rows="5" cols="50"><?php echo $info['witns_statement']; ?></textarea>
                    </div>
                </div>
                 
                <div class="col-sm-12 nopad">
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">
                                <span class="en">Upload Image:</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="upload[]" id="upload" multiple accept="image/*">    
                                <small>
                                    <em>
                                        <b <?php if(!empty($file_type_error_name) && in_array("upload", $file_type_error_name)){ echo "style='color: #ed0f0f;'"; }?>>
                                        (Upload only image file)
                                        </b>
                                    </em>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                         <div class="col-sm-12 nopad">
                <?php
                         $show=explode(",",$info['file']);
                         if(!empty($info['file'])){ 
                         for($i=0;$i<count($show);$i++){   
                ?>
                               <div class="col-sm-3" style="padding-left: 0px;">
                                <a  href='../attachments/incident/<?php echo  $show[$i] ?>' target='_blank'> <img src="../attachments/incident/<?php echo  $show[$i] ?>" class="img-thumbnail" alt="Responsive image"  width='100px' style='border:1px solid #ccc;padding:2px;margin: 0 0 10px 0;'></a>
                                 </div> 
                <?php
                    }
                  }
                ?>
                      </div>  

                <div class="col-sm-12 nopad">
                   <div class="col-sm-3" style="padding-left: 0px;">
                        <label class="control-label">
                            <span class="en">Witness Signature:</span>
                            <span class="error">*</span>
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <div id="sign_ipad">
                            <div  class="sig sigWrapper current" style="cursor:crosshair;width:585px;height: 130px; overflow: hidden;">
                                <div style="display: none;" class="typed"></div>
                                <canvas class="pad" width="585" height="130"></canvas>
                                <input name="signature" id="signature" value="" class="output" type="hidden">
                            </div>
                            <a href="#clear" class="clearButton">Clear signature</a>
                        </div>
                    </div>
                </div>
                <div class="clr">&nbsp;</div> 
                <div class="col-sm-12 nopad">
                    <label class="col-sm-3 control-label" style="padding-left: 0px;">
                        <span class="en">Date:</span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" name="witns_date1" id="witns_date1" class="form-control" placeholder="MM/DD/YYYY" value="<?php if($info['witns_date1'] != '') echo $info['witns_date1']; ?>">
                    </div>                          
                </div>
            </div>
            <div class="clr">&nbsp;<br><br></div>   
            <div class="col-sm-12 nopad">
                <div class="col-sm-3 row">          
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/incident_investigation/'">Cancel</button>
                    &nbsp;
                    <input id="submit" type="submit" name="submit" class="btn btn-success" value="Submit">
                </div>      
            </div>
        </fieldset>
    </form>
    <div class="clr">&nbsp;</div> 
</div>

<script src="/js/jquery.maskedinput.min.js"></script>
<script src="/js/jquery.signaturepad.js"></script>

<script>
/*function validateImage(img){
    var img_ext=img.split('.').pop();
    var valid_ext=["jpeg","jpg","gif","png"];
    var ext=valid_ext.indexOf(img_ext);
    if(ext==-1){
        alert("Only jpeg,jpg,gif,png files are allowed");
        document.getElementById('upload').value=" ";
        return false;
    }else{
        return true;
    }
}*/


$(document).ready(function() {
    var i;
    $("#ins_frm").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            dob: "required",
            incident_date: "required",
            location: "required",
            date_reported: "required",
            name: "required",
            age: "required",
            contact_number: "required",
            occupation: "required",
        },
    });
    <?php if(isset($info['signature']) && trim($info['signature'])!=''){ ?>
    $('#sign_ipad').signaturePad({drawOnly:true,validateFields:false, lineWidth :0}).regenerate('<?php echo $info['signature'] ?>');
    <?php }else{ ?>
    $('#sign_ipad').signaturePad({drawOnly:true,validateFields:false, lineWidth :0});
    <?php } ?>
    
    $( "#incident_date, #dob, #h_date, #date_reported, #witns_date, #witns_date1").datetimepicker({
        timepicker:false,
        format:'m/d/Y',
        closeOnDateSelect: true,
        scrollInput: false,
    });
    
    data_mask();
});

function data_mask(){
    $('.maskd').mask("99/99/9999", {placeholder: "MM/DD/YYYY"}); 

    $('.maskd').change(function() {
        if ($(this).val().substring(0, 2) > 12 || $(this).val().substring(0, 2) == "00") {
            alert("Invaid Date Format");
            $(this).val('');
            return false;
        }
        if ($(this).val().substring(3, 5) > 31 || $(this).val().substring(0, 2) == "00") {
            alert("Invaid Date Format");
            $(this).val('');
            return false;
        }
    });
}
</script>
<style>
.header{background: #ccc;padding: 8px 5px 5px 5px;margin-bottom: 20px;}
span.error{color:red;}
.signerr{border: 2px solid red;}     
label {font-weight: 600;}
.col-sm-4.nopad input[type="radio"] { margin-right: 5px;} 
.pad{ width: 100%;}
.sub_head {font-size: 20px;border: 1px solid;background-color: #ccc;border-radius: 4px;padding: 4px;}
</style>
<?php include_once dirname(dirname(dirname(__FILE__))).'/_foot.php'; ?>