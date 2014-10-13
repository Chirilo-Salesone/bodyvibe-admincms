<?php
     ob_start();
     include("../secure/lib/adminConfig.php");
     include("../secure/lib/classes/class.adminOrderListing.php");
     include("userBlocker.php");
     

     $info = new adminOrderListing();
     
    
     ($_GET) ? $info->cmdOptions() : '';
     ($_POST[windowExport]!="") ? $info->exportWinPfi() : '';


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Wholesale Body Jewelry - Belly Rings, Barbells, Nose Studs, plugs and more! &#151; ADMIN PANEL</title>

<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_INCLUDE_CSS?>/theMain.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_INCLUDE_CSS?>/thePages.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_INCLUDE_CSS?>/adminCss.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_INCLUDE_CSS?>/orderDetail.css" />
<link rel="SHORTCUT ICON" href="<?php echo SITE_URLS ?>/images/favicon.ico"/>
<link rel="icon" href="<?php echo SITE_URLS ?>/images/animated_favicon.gif" type="image/gif"/>

		 <script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/accordion/ddaccordion.js"></script>
                 <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_INCLUDE_JS ?>/accordion/accordion.css" />
                 <script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/tooltip/jquery.js"></script>
                 <script type="text/javascript" charset="utf-8" src="<?php echo ADMIN_INCLUDE_JS ?>/accordion/setters.js"></script>
   
<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/rowHighLighter.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/adminCheckAll.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/confirmDelete.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS ?>/orderDelete.js"></script>

<!--<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS?>/my-j-query.js"></script>-->
<script type="text/javascript" src="<?php echo ADMIN_INCLUDE_JS?>/order-list.js<?php echo REFRESHER_EXT?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

            jQuery("#orderStatus").bind('change',function(){ 
	
		adminOrderDetail.changeOrder(this);

	     });

            adminOrderDetail.orderID="<?php echo $_GET[order_id]?>";
            
             jQuery("#sendmail").hover(function(){
                                                      jQuery(this).stop().animate({"opacity": .5});
                                                  },function(){
                                                      jQuery(this).stop().animate({"opacity": 1});
                                                  });


    });
</script>
<script type="text/javascript">
function sendEmailConfirmation(){

  if(confirm("Proceed sending order tracking information?")){
                      window.location= "<?php echo SITE_URLS?>/admincms/orderDetailInfo/<?php echo $_GET['order_id']?>/<?php echo $_GET['cmd']?>&email=ordertrackerinfo"; 
 }
}

</script>



</head>
<body>
   <div class="page-container">
       <?php include("include-html/html-header.php"); ?>

       <div class="page-content">

           <?php include("include-html/html-left.php") ?>

           <div class="content-section">
                <div class="content-wrapper">
                        <div class="orderList-page-section">
                             <div class="title">
                                 <?php 
                                 if($_GET[cmd]=="update"){?>
                                 <div style="padding-left:100px; line-height:12px;"><b>&#187;</b>
                                    <span style="font-size:12px;font-weight:bold;font-family:Verdana">VIEW DETAIL & UPDATES</span>
                                 </div>
                                 <?php } ?>
                             </div>
                             <div class="content adminPagination">
                               <?php
                                 switch($_GET[cmd]){

                                   case "update":
                                        include("includes/orderDetail.php");
                                   break;
                                   
                                   default:
                                       include("includes/orderDisplay.php");
                                   break;

                                 }
                               ?>
                             </div>
                        </div>

           </div>
           <div class="page-spacer"></div>

       </div>
   </div>
 </div>   
  
</body>

</html>
<?php ob_end_flush(); ?>
