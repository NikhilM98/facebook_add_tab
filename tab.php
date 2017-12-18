<?php //include("functions/functions.php"); ?>
<?php include("../mainframe.php"); 

// $strings = explode('?', $_SERVER['REQUEST_URI']);
// if (isset($strings[1])) {
//   foreach (explode('&', $strings[1]) as $sPair) {
//       if (empty($sPair)) continue;
//       list($sKey, $sValue) = explode('=', $sPair);
//       $_GET[$sKey] = $sValue;
//   }
// }

$modal_clinic_name = $functions->show_clinic_name($_GET['cid']);
$modal_doc_img = $functions->show_doc_name($_GET['id']);

$doc_category = json_decode($modal_doc_img['specialization'],true);

$doc_first_specliz = $doc_category[0]['specialization'];
if(is_numeric($doc_first_specliz)){
	$doc_specliaztion_l = $functions->get_data_by_id($doc_first_specliz, $table = 'speciality', $field = 'specialization');
	$doc_1_spelize = $doc_specliaztion_l[0];
}else{
    $doc_1_spelize = $doc_first_specliz;
}

if(isset($_GET['cid']) && !isset($_GET['id'])) { ?> 
<script>
    clinic_name(<?php echo $_GET['cid'] ?>);
    function clinic_name(val){
        
        $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_clinic_name.php/",
                    data: {
                        'clinic_id':val
                    },
                    success: function(data) {
                        
                        $("#modal_clinic_name").html(data);
                        
                    }
                });  
    }
</script>
<?php } ?>
<style>

@media only screen and (min-width: 1100px) {
.bp-doc-info-div {
   
    width: 300px;
    position: fixed;
   
    background-color: #eee;
    margin-top: 80px;
    text-align: center;
    border: 0px solid #fff;
    border-radius: 5px;
    background-color: #fff;
    -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.4);
    -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.4);
    box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.4);
}
.clinics-cards {
    margin-left: 350px;
}


#sticky {
    z-index: 99;
    position: fixed;
    right: 0;
    top: 14%;
    width: 8em;
    margin-top: -2.5em;
    background-color: #ffffff;
    padding: 0px;
    width: 100%;
    color: #000;
    font-size: 16px;
    border-radius: 0.5ex;
}



.scroll {
    margin-top: 90px;
}

#stickynav{
    z-index: 999;
    width:100%;
    position: fixed;
    padding: 0em;
    left: 50%;
    top: 21%;
    transform: translate(-50%, -50%);
    background-color: #fff;
}
}

@media only screen and (max-width: 1160px) and (min-width: 800px) {
    
    
    div#stickynav {
        z-index: 999;
    background: #fff;
    width: 90%;
}
}

@media only screen and (max-width: 768px) {
    
 .info-right.clinics-cards {
   
    background-color: transparent !important;
    
}
    .image-rounded.logo-image .logo_docconsult .logo-image {
    position: relative;
    top: 0;
   
}

div#stickynav {
    z-index: 999;
   margin-left: -20%;
    width: 95%;
      background: #fff;
}

.button_sign_ups, .button_sign_ups:hover {
   
    width: 100%;
    
}

.time-option {
    border: 1px solid #ccc;
    width: 27%;
    
}

div#date1 {
    text-align: center;
    margin: 20px;
}

.scroll {
    width: 95%;
    margin-top: -160px;
    margin-left: -20%;
}
.image-rounded.logo-image .logo_docconsult .logo-image {
    position: relative;
    top: 0;
    
}

}
.doctor-day{font-size: 1.4em;
    padding-bottom: 4vh;
    font-weight: 500;}

@media only screen and (max-width: 767px) and (min-width: 567px) {
  

.col-sm-8.info-right.clinics-cards.cards-responsive {
    padding: 20px;
}

      .btn-li-top {
   
    width: 25%;
}


    div#stickynav {
    z-index: 999;
    background-color: #fff;
    padding: 20px;
    width: 50% ;
}

   .time-option {
    border: 1px solid #ccc;
    position: relative;
    margin: 4px 3%!important;
    width: 20% !important;
    float: left;
    left: 10%;
}
    
   div#slot1 {
    width: 74%;
    text-align: center;
    margin: 0 0 0 3% !important;
}

    #appointment span.clinic-name {
    font-size: 10px;
    text-align: center;
    float: left;
    font-weight: 700;
}

.calender-date {
    width: 14%;
    padding: 0px !important;
}

div#date1 {
    margin:0 !important;
    width: 60%;
    text-align: center;
}

 .image-rounded.logo-image .logo_docconsult .logo-image {
    position: relative;
    top: 0;
    left: 40%;
}
}

@media only screen and (max-width: 767px)  and  (min-width: 736px){
     div#slot1 {
    width: 74%;
    text-align: center;
    margin: 0 0 0 5% !important;
}

 div#date1 {
    margin:0 !important;
    width: 70%;
    text-align: center;
}   
   
}
@media only screen and (max-width: 735px)  and  (min-width: 667px){
     div#slot1 {
    width: 74%;
    text-align: center;
    margin: 0 0 0 5% !important;
}

 div#date1 {
    margin:0 !important;
    width: 60%;
    text-align: center;
}   
   
}

@media only screen and (max-width: 568px) {
    
    .btn-li-top {
    margin: 10px 0 !important;
    width: 100%;
}


    div#stickynav {
        z-index: 999;
    background-color: #fff;
    padding: 20px;
   
}

    .time-option {
    margin: 0 auto !important;
    width: 46% !important;
   
}
    
    div#slot1 {
    width: 50%;
    text-align: center;
    margin: 0 !important;
}

    #appointment span.clinic-name {
    font-size: 10px;
    text-align: center;
    float: left;
    font-weight: 700;
}


.bp-doc-info-div {
    margin-bottom: 50px;
    margin-top: -80px;
}

div#date1 {
    margin:0 !important;
    width: 54%;
    text-align: center;
}

  .clinic-cards  .bp-doctor-image {
    float: none;
    height: 30px;
    width: 30px;
    margin-left: -20px;
}
   
   
    .time-option {
    border: 1px solid #ccc;
    position: relative;
    margin: 2px !important;
    width: 30% !important;
    float: left;
    left: 10%;
}

.scroll {
    width: 95%;
    margin-top: -80px;
    margin-left: -19%;
    padding: 20px;
}   
    .col-sm-8.info-right.clinics-cards.cards-responsive {
    padding: 20px;
}

}


@media only screen and (max-width: 414px) {
    
    .btn-li-top {
    margin: 10px 0 !important;
    width: 100%;
}


    div#stickynav {
        z-index: 999;
    background-color: #fff;
    padding: 20px;
   
}

    .time-option {
    margin: 0 auto !important;
    width: 46% !important;
   
}
    
    div#slot1 {
    width: 26%;
    text-align: center;
    margin: 0 !important;
}

    #appointment span.clinic-name {
    font-size: 10px;
    text-align: center;
    float: left;
    font-weight: 700;
}


.bp-doc-info-div {
    margin-bottom: 50px;
    margin-top: -80px;
}

div#date1 {
    margin:0 !important;
    width: 28%;
    text-align: center;
}

  .clinic-cards  .bp-doctor-image {
    float: none;
    height: 30px;
    width: 30px;
    margin-left: -20px;
}
   
   
    .time-option {
    border: 1px solid #ccc;
    position: relative;
    margin: 2px !important;
    width: 30% !important;
    float: left;
    left: 10%;
}


 .scroll {
    padding: 20px;
}   
    .col-sm-8.info-right.clinics-cards.cards-responsive {
    padding: 20px;
}

}



.active button#clinicbtn, .active button#date , .active button#slot {
    background: white;  !important
    color: green;
}

.mobile-show {
    margin-top: -40px;
}

.info-right.clinics-cards {
   margin-top: 40px;
     margin-bottom: 40px;
     text-align: center;
    border: 0px solid #fff;
    border-radius: 5px;
    background-color: #fff;
    -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.4);
    -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.4);
    box-shadow: 0px 0px 7px 0px rgba(0,0,0,0);
}
   .calender-date {
       
       float:left;
    background: white;
    width: 14%;
    border: 1px solid;
    text-align: center;
    padding: 0px 15px;
}

 .calender-date:hover {
     float:left;
    background: darkgrey;
    cursor:pointer;
    width: 14%;
    border: 1px solid;
    text-align: center;
    padding: 0px 15px;
    
    
}

small.day-cal {
    top: -10px;
    position: relative;
}

h3.date-cal {
    margin-top: -10px;
    }
    
.fa.fa-bed.clinic-icon
{
    font-size: 40px;
}
.book{
    font-size: 3em;
    font-weight: 500;
}
</style>
<body style="background-color: #ffffff; font-family: 'Open Sans', sans-serif;">
<div  id="appointment" role="style">
    
<div class="container book-an-appoint">   
<div class="heading  text-center" id="sticky">
<div id="stickynav">
 <h3 class="book"><i class="fa fa-bed clinic-icon" aria-hidden="true"></i>Book an Appointment </h3>
	<input type="hidden" id="hidden_did">
				<input type="hidden" id="hidden_cid">
					
<ul class="nav nav-tabs" role="tablist" style="border: none;text-align: center;      padding: 20px ;">
        <?php if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id']))) {?>
                                <li role="presentation" class="active btn-li-top" style="float:none;display:inline-block;"><button href="#clinic1" id="clinicbtn"  data-toggle="tab" class="slct">Clinic</button></li> <?php } ?>
                         

                                <li role="presentation" class="btn-li-top" style="float:none;display:inline-block;margin-left: 3%"><button href="#date1" id="date" data-toggle="tab" disabled="true" class="slct" >Select Date</button></li>


                                <li role="presentation"  class="btn-li-top" style="float:none;display:inline-block;margin-left: 3%"><button href="#slot1"  id="slot" data-toggle="tab" disabled="true" class="slct" >Slot</button></li>
                                          
</ul>
</div>		 	
</div>

<div class="scroll" style="background-color:#fafafa;font-family: 'Open Sans', sans-serif;">
        <div class="col-sm-4 info-left responsive-div" style="margin-top: -40px;" >
           <?php if(isset($_GET['cid']) && isset($_GET['id'])) { ?>
           
           <div class="bp-doc-info-div" style="height:auto">
                    <div class="row col-sm-12 col-sm-offset-0" style="margin-bottom:15px;text-align:center">
                        
                        
                     
                      <img class=" bp-doctor-image" src="<?php echo base_url_image.$modal_doc_img['image'];?>">
                        
                        
                            </div>
                            	<div class='clearfix'></div>
                            <div class="row" style="margin: 15px 30px;">
                                <p style="font-size:1.1em;color:#333;"><h5  class="text-center "><?php echo $modal_doc_img['name'];?></h5></p>
                                <p id="modal_doc-cat" style="font-size:.9em;color:#666;;"><?php echo $doc_1_spelize;?></p>
                                <p style="font-size:.9em;color:#666;"><h5 class="text-center "><?php echo $modal_clinic_name;?></h5></p>
                           </div>
                            <div class="doc-line"></div>
                            <div class="row" style="margin: 10px 30px;">
                                <p style="font-size:1.1em;color:#333;">Details</p>
                                <p id="appoint_date" style="font-size:.9em;color:#666;">Date : </p>
                                
                            </div>
            </div>
           
 <?php } else { ?>
                <div class="bp-doc-info-div" style="height:auto">
                    <div class="row col-sm-12 col-sm-offset-0" style="margin-bottom:15px;text-align:center">
                        <?php if(isset($_GET['cid']) && !isset($_GET['id'])) { ?>  
                        <img class="bp-doctor-image" src="<?php echo base_url_image.'dp-clinic/medical_clinic.png';?>">
                         <img class=" bp-doctor-image" src="<?php echo base_url_image."dp/".$modal_doc_img['image'];?>">                                                                                                                                                                                                
                        <?php } ?>
                                </div>
                                	<div class='clearfix'></div>
                                <div class="row" style="margin: 15px 30px;">
                                    <p style="font-size:1.1em;color:#333;"><h5 id="modal_doc_name" class="text-center "></h5></p>
                                    <p id="modal_doc-cat" style="font-size:.9em;color:#666;;"></p>
                                    <p style="font-size:.9em;color:#666;"> <h5 id="modal_clinic_name" class="text-center "></h5></p>

                                </div>
                                <div class="doc-line"></div>
                                <div class="row" style="margin: 15px 30px;">
                                    <p style="font-size:1.1em;color:#333;">Details</p>
                                    <p id="appoint_date" style="font-size:.9em;color:#666;">Date : </p>
                                    
                                </div>
                </div>
            <?php } ?>    
            
        </div>
		
        <div class="col-sm-8 info-right clinics-cards cards-responsive dddd">
            
           <div class="clinics-slots ">

			
        <div class="tab-content calender-show">  
         
        <!-- <h5 id="modal_doc_name" class="text-center "></h5><br>
        <h5 id="modal_clinic_name" class="text-center "></h5>-->
                     <?php if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id'])) ) {?>
        			<div id="clinic1" class="tab-pane fade in active">
   
					</div>
					<?php } ?>
        			<div id="date1"  class=" tab-pane fade calender-slot" style="text-align: center;margin: 20px 50px 20px 50px;" >
        	
        		<div class="color-row-date">
        		    <div class="row-align doctor-day"> <span class="currentday"></span> Current Day</div>
        		     <div class="row-align doctor-day"> <span class="sundayleave"></span> On Leave</div>
        		      <div class="row-align doctor-day"> <span class="monthleave"></span> Sunday</div>
        		      <div class="row-align doctor-day"> <span class="availableday"></span>Available</div>
        		      
        		    </div>
        			  <div class="clearfix"></div>  <?php 
        			    
        			    for($i=0;$i<=30;$i++){ 
        			    
        			    $date = strtotime("+$i day", strtotime(date("Y-m-d")));
                        if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id']))) {
                            if(substr(date("l", $date),0,3)=='Sun'){
        			    ?>
        			  <div style="background-color:rgba(45, 156, 219, 0.58);" class="calender-date text-center" onClick="slot_show('<?php echo date("Y-m-d", $date);?>')">
        			      <?php } else{ ?>
        			                  			  
        			  <div class="calender-date text-center" onClick="slot_show('<?php echo date("Y-m-d", $date);?>')">

        			      <?php }  } else { if(substr(date("l", $date),0,3)=='Sun') { ?> 
        			   <div style="background-color:#D8D8D8;" class="calender-date text-center" onClick="slot_show1('<?php echo date("Y-m-d", $date);?>')">
        			       <?php } else { ?>
        			     <div  class="calender-date text-center" onClick="slot_show1('<?php echo date("Y-m-d", $date);?>')">
                        <?php } }?>
                        <p><?php echo substr(date("F", $date),0,3);?></p>
                        <small class="day-cal"><?php echo substr(date("l", $date),0,3);?></small>
                        <h3 class="date-cal"><?php echo date("d", $date);?></h3>
        
                        </div>
                        <?php
                        
                        if(($i+1)%7==0){
                            echo "<div class='clearfix'></div>";
                        }
                        
                         if(($i+1)%5==0){
                            echo "<script>
$(document).ready(function() {
  $('.calender-date').addClass('available-color');
  $('.calender-date:first').toggleClass('available-color')

});
</script>";
                        }
                        }
                        ?>                    
        				<div class='clearfix'></div>
        			</div>

					<div id="slot1" class="tab-pane fade" style="text-align: center;margin: 20px 50px 20px 50px;">
                        
					</div>
					
					
				<!--form div start-->
									<div id="patient_deatils" class="tab-pane fade" style="margin: 20px 0px 20px 0px;">
                        <div class="col-sm-12">
  <form action="">
      <div class="col-sm-6">
    <div class="form-group">
      <label for="email" class = "pull-left">Name:</label>
      <input type="email" class="form-control" id="name" placeholder="Enter Name" name="name">
    </div>
    </div>
     <div class="col-sm-6">
    <div class="form-group">
      <label for="email" class = "pull-left">Phone:</label>
      <input type="email" class="form-control" id="phone" placeholder="Enter phone" name="phone">
    </div>
    </div>
     <div class="col-sm-6">
    <div class="form-group" >
      <label for="email" class = "pull-left">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    </div>
     <div class="col-sm-6">
    <div class="form-group">
      <label for="email" class = "pull-left">Address:</label>
      <input type="email" class="form-control" id="address" placeholder="Enter Address" name="address">
    </div>
    </div>
    <div class="col-sm-12">
    <div class="form-group">
      <label for="email" class = "pull-left">Text Message :</label>
      <textarea type="email" class="form-control" id="textmessage" placeholder="Enter Message" name="textmessage"></textarea>
    </div>
    <button type="button" class="btn btn-primary btn btn-info" data-toggle="modal" data-target="#myModal">Submit</button>
    <div class="clearfix"></div>
    </div>
    
    
  </form>
    <div class="clearfix"></div>
</div>
<!--form end patient details-->
					</div>

					
				<!--form div End-->	
					
				</div><!--tab-content end-->

                </div><!--clinics-slots End-->
</div>

        </div>
    </div>


    
		
	</div>
	</div>
	
	
	
	
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;">
         
        </div>
        <div class="modal-body" style="padding: 15px;">
            <center>Enter Your OTP : <input text="text" name="patitent-otp" ></center>
        </div>
         <center><button type="button" class="btn btn-default" style=" margin: 10px;">Reset</button>
          <button type="button" class="btn btn-default" style=" margin: 10px;">Send</button></center>
           <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!--
  
  <div class=" mobile-show">
      
    <center> <h3><i class="fa fa-bed clinic-icon" aria-hidden="true"></i>Book an Appointment </h3></center>
 	<div class='clearfix'></div>
 <div class="info-left" >
           
                <div class="bp-doc-info-divs" style="height:auto">
                    <div class="col-sm-4 col-xs-4" style="margin-bottom:15px;text-align:center">
                        <img class=" bp-doctor-image " src="<? echo base_url."images/".$res[0]['image']; ?>"> 
                    </div>
                    	   
                    <div class="col-sm-7 col-xs-7" style="margin-top:15px">
                        <p style="font-size:1.1em;color:#333;"><h5 id="modal_doc_name" class="text-center "></h5><br></p>
                        <p style="font-size:.9em;color:#666;"> <h5 id="modal_clinic_name" class="text-center "></h5></p>
                        <p style="font-size:.9em;color:#666;">category</p>
                        <p style="font-size:.9em;color:#666;padding-bottom:20px;">category</p>
                    </div>
                    <div class='clearfix'></div>
                    <div class="col-sm-12 text-center" style="margin-top:5px; border-top:1px dashed #999; ">
                        <p style="font-size:1.1em;color:#333;">Details</p>
                        <p style="font-size:.9em;color:#666;">Date : <?php echo $date; ?></p>
                        <p style="font-size:.9em;color:#666;">Time : <?php echo $time; ?></p>
                    </div>
                </div>
            
        </div>

<div class="heading  text-center">

 
	<input type="hidden" id="hidden_did">
				<input type="hidden" id="hidden_cid">
					
						<ul class="nav nav-tabs" role="tablist" >
        <?php if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id']))) {?>
        <li role="presentation" class="active" style="width: 40%;
           margin: 10px auto;
    float: none;"><button href="#clinic1" id="clinicbtn"  data-toggle="tab" class="slct" style="background-color: green;">Clinic</button></li> <?php } ?>
 

        <li role="presentation" style="width: 40%;
           margin: 10px auto;
    float: none;"><button href="#date1" id="date" data-toggle="tab"  class="slct" >Select Date</button></li>


        <li role="presentation" style="width: 40%;
          margin: 10px auto;
    float: none;"><button href="#slot1"  id="slot" data-toggle="tab"  class="slct" >Slot</button></li>
                  
        <li role="presentation" style="width: 40%;
         margin: 10px auto;
    float: none;"><button href="#patient_deatils"  id="patient_slot" data-toggle="tab"  class="slct" >Patient Details</button></li>
  
        </ul>
</div>		 	


<div style="background-color:#fafafa;font-family: 'Open Sans', sans-serif;">
        
		
        <div class="col-sm-8 info-right clinics-cards">
            
           <div class="clinics-slots ">

			
        <div class="tab-content calender-show">  
         
      
                     <?php if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id'])) ) {?>
        			<div id="clinic1" class="tab-pane fade in active">
   
					</div>
					<?php } ?>
        			<div id="date1"  class=" tab-pane fade calender-slot" style="text-align: center;margin: 20px 50px 20px 50px;" >
        	
        		
        			    <?php 
        			    
        			    for($i=0;$i<=30;$i++){ 
        			    
        			    $date = strtotime("+$i day", strtotime(date("Y-m-d")));
                        if(!isset($_GET['cid']) ||(isset($_GET['cid']) && !isset($_GET['id']))) {
        			    ?>
        			  <div class="calender-date text-center" onClick="slot_show('<?php echo date("Y-m-d", $date);?>')">
        			      <?php } else { ?>
        			   <div class="calender-date text-center" onClick="slot_show1('<?php echo date("Y-m-d", $date);?>')">
        			       <?php } ?>     
                        <p><?php echo substr(date("F", $date),0,3);?></p>
                        <small><?php echo substr(date("l", $date),0,3);?></small>
                        <h3><?php echo date("d", $date);?></h3>
        
                        </div>
                        <?php
                        
                        if(($i+1)%7==0){
                            echo "<div class='clearfix'></div>";
                        }
                        
                        } ?>                    
        				<div class='clearfix'></div>
        			</div>

					<div id="slot1" class="tab-pane fade" style="text-align: center;margin: 20px 50px 20px 50px;">
                        
					</div>-->
					
					
				<!--form div start-->
								<!--	<div id="patient_deatils" class="tab-pane fade" style="margin: 20px 0px 20px 0px;">
                        <div class="col-sm-12">
  <form action="">
      <div class="col-sm-6 col-xs-3" style="float:none;">
    <div class="form-group">
      <label for="email" class = "pull-left">Name:</label>
      <input type="email" class="form-control" id="name" placeholder="Enter Name" name="name">
    </div>
    </div>
     <div class="col-sm-6 col-xs-3" style="float:none;">
    <div class="form-group">
      <label for="email" class = "pull-left">Phone:</label>
      <input type="email" class="form-control" id="phone" placeholder="Enter phone" name="phone">
    </div>
    </div>
     <div class="col-sm-6 col-xs-3" style="float:none;">
    <div class="form-group" >
      <label for="email" class = "pull-left">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    </div>
     <div class="col-sm-6 col-xs-3" style="float:none;">
    <div class="form-group">
      <label for="email" class = "pull-left">Address:</label>
      <input type="email" class="form-control" id="address" placeholder="Enter Address" name="address">
    </div>
    </div>
    <div class="col-sm-12 col-xs-3" style="float:none;">
    <div class="form-group">
      <label for="email" class = "pull-left">Text Message :</label>
      <textarea type="email" class="form-control" id="textmessage" placeholder="Enter Message" name="textmessage"></textarea>
    </div>
    <button type="button" class="btn btn-primary form-submit-btn feed-submit register_button" data-toggle="modal" data-target="#myModal" style="margin: 20px;" >Submit</button>
    <div class="clearfix"></div>
    </div>
    
  </form>
    <div class="clearfix"></div>
</div>-->
<!--form end patient details-->
				<!--	</div>
-->
					
				<!--form div End-->	
					
		<!--		</div>--><!--tab-content end-->

                <!--</div>--><!--clinics-slots End-->
<!--</div>

        </div>
    </div>
 
      
  </div>--><!--mobile show data-->
  
  
  
  
  
  
<script>

// $("div.clinic-cards").on("click",function(event) {
//     //alert(event.target);
//     // var target = $(event.target);
//     // if (target.is('input:checkbox')) return;
    
//     var checkbox = $(this).find("input[type='radio']");
   
    
//     if( !checkbox.prop("checked") ){
//         checkbox.prop("checked",true);
//          $(this).find("input[type='radio']").trigger('click');
//     } else {
//         checkbox.prop("checked",false);
//     }
// });


<?php if(!isset($_GET['cid'])) {?>
    modaldata(<?php echo $_GET['id']; ?>);
    
    <?php } elseif(isset($_GET['cid']) && !isset($_GET['id']) && !isset($_GET['request_for_call'])) { ?>
    
    modaldata1(<?php echo $_GET['cid']; ?>);
    <?php } elseif(isset($_GET['request_for_call'])) { ?>
    modaldata_request_for_call(<?php echo $_GET['cid']; ?>);
    <?php } else { ?>
    
    $(document).ready(function(){
        $("#date1").addClass("in");
        $("#date1").addClass("active");
    });
    <?php } ?>
function select_cid(val){
    document.getElementById('hidden_cid').value=val;
}


function modaldata(val)
{
   
    document.getElementById('hidden_did').value=val;
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_clinic_app_ajax.php/",
                    data: {
                        'doc_id':val
                    },
                    success: function(data) {
                        
                        $("#clinic1").html(data);
                        
                    }
                });
    
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_doc_name.php/",
                    data: {
                        'doc_id':val
                    },
                    success: function(data) {
                        
                        $("#modal_doc_name").html(data);
                        
                    }
                });
    
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_doc_cat.php/",
                    data: {
                        'doc_id':val
                    },
                    success: function(data) {
                        
                        $("#modal_doc-cat").html(data);
                        
                    }
                });
    
             

}

function modaldata1(val)
{
   
    document.getElementById('hidden_cid').value=val;
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_clinic_app_ajax.php/",
                    data: {
                        'clinic_id':val
                    },
                    success: function(data) {
                        
                        $("#clinic1").html(data);
                        
                    }
                });
   
}

function modaldata_request_for_call(val)
{
   
    document.getElementById('hidden_cid').value=val;
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_clinic_app_ajax.php/",
                    data: {
                        'clinic_id':val,
                        'request_for_call':"<?php echo $_GET['request_for_call'] ?>"
                    },
                    success: function(data) {
                        
                        $("#clinic1").html(data);
                        
                    }
                });
}

function redirect_for_request(cid){
    var url = '<?php echo base_url ?>';
    var did= "<?php echo $_GET['id']?>";
    var date= "<?php echo date("Y-m-d") ?>";
    var time = "<?php echo date("h:i:A") ?>";
        
        window.location.href = url+'bookappointment.php?did='+did+'&cid='+cid+'&date='+date+'&time='+time+'&request_for_call=true'; 
}


function redirect_for_request_clinic(did){
    var url = '<?php echo base_url ?>';
    var cid= "<?php echo $_GET['cid']?>";
    var date= "<?php echo date("Y-m-d") ?>";
    var time = "<?php echo date("h:i:A") ?>";
        
        window.location.href = url+'bookappointment.php?did='+did+'&cid='+cid+'&date='+date+'&time='+time+'&request_for_call=true'; 
}
</script>
<script>

$(document).ready(function() {
  $('.calender-date:first').addClass('current-color');
});


$(document).ready(function () {
    
    
      $('.calender-date').click(function () {
                 $("#slot").prop('disabled',false);
          $("#slot").trigger('click');
          $('#slot').css('background-color','green');
          $('#slot1').tab('show');
      });
       
      $( "#<?php echo $page?>" ).addClass( "active" );

        time = setInterval(plusDivs(+3),2000);
         
  });
  
  <?php if($_GET['cid']){?>
  
 $(document).ready(function(){
     $("#slot").prop('disabled',true);
     $("#date").prop('disabled',false);
 });
 <?php } ?>
  
 function slot_show1(val){
   
     $("#appoint_date").html(val);
     var docid=<?php if ($_GET['id']){echo $_GET['id'];} else{ echo "''"; } ?>;
     var clinicid=<?php if ($_GET['cid']){echo $_GET['cid'];} else{ echo "''"; } ?>;
    
    
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url ?>show_clinic_slot_ajax.php/",
                    data: {
                        'doc_id':docid,
                        'clinic_id':clinicid,
                        'date':val
                    },
                    success: function(data) {
                        $("#slot1").html(data);
                        $("#slot").prop('disabled',false);
                    }
                });

    
    //document.getElementById('hidden_did').value=val;
} 
</script>
<?php 
// include("footer.php");
?>
