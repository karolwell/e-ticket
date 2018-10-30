
<?php
use yii\helpers\Html;
?>
<script type="text/javascript">
    
	function start(){
			$('#id_begincustomer').show(); 		
			$('#id_startcustomer').hide(); 		
	}
	
	
	function send_response(){
	        var response=document.getElementById('response').value;
	        if(response.trim()!=""){
			    $('#response').val("");
				var url_submit = "<?php echo Yii::$app->homeUrl ?>/site/send_reponse";
				var url_image='<div style="text-align:center;margin-top:20px"><?= Html::img(Yii::getAlias("@web/images/ajax-loader.gif"),["width"=>"200px","height"=>"200px",]) ?></div>';			
				$('#screen').html(url_image);
				
				
				$.ajax({
					url: url_submit,
					type: "POST",
					data: { 
						 response: encodeURIComponent(response)
					},
					success: function(data) {
						console.log(data);
							$('#screen').html(data);
							if(response.trim()=="*8686#"){
								$('#show_code').hide(); 
							}
							 		
					}
				});
					
			
			}		
	}	
	
</script>
<section >
    <div class="container">

        <div class="row">
		    <center><h2 style="margin-bottom:0px!important"><?php echo \Yii::t('app', 'E-TICKET USSD');?></h2></center>
		    <center><img style="height:120px;" src="<?=Yii::getAlias("@web/images/logo.png")?>" alt="logo.png"  /></center>
                    <center>22891121670</center>
		    <center>*8686#</center>
            <div class="col-md-4 col-sm-4">
			</div>
            <div class="col-md-4 col-sm-4" style="border:1px solid #dedede;padding:20px">
			
				<form action="" method="post" style="margin-bottom:20px">
				
				    <a href="#" onclick="start();return false" class="btn btn-sm" style="margin-bottom:10px;float:right;color:#FFFFFF;background:#CF295A!important" >REDEMMARRER</a>
					
					<div id="id_begincustomer" style="display:none">

						<input type="text" class="form-control" required name="phone_number" value="" placeholder="Veuiller entrer le numero de telephone" />
						<input type="submit"  value="<?php echo \Yii::t('app', 'SEND');?>" name="send" class="btn btn-sm btn-info" style="float:right;margin-top:10px"/>
					 
					</div>
					
					
					<?php 
					$session = Yii::$app->session;
					if ($session->has('status')){
						$type=$session->get('status');
						if($type=="READY"){ 
						$phone=$session->get('user_mobile');
					?>
					<div id="id_startcustomer" >
						<span style="font-size:15px;font-weight:bold"><?php echo \Yii::t('app', 'PHONE');?> <?php echo $phone ?></span>
						<br/><span id="show_code" style="color:red;font-size:13px;font-weight:bold">DEMMARER</span>
						<div  id="screen" style="margin-top:20px;margin-bottom:20px;min-height:250px;padding:10px;border:1px solid #dedede!important">
								
						</div>
						<input type="text" name="response" id="response" placeholder="numero" class="form-control" >
						<a href="#" onclick="send_response();return false" class="btn btn-sm btn-info" style="margin-top:10px;float:right;" ><?php echo \Yii::t('app', 'REPONDRE');?></a>
					
					</div>
					
					<?php } }?>
            
				</form>
				
			</div>
			<div class="col-md-4 col-sm-4">
			</div>
            
        </div>

    </div>
</section>
<!-- / -->