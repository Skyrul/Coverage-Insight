<?php
$this->page_label = "Account Setup";

// remove goto menu
$this->goto_menu = false;
?>

<style>
    input[name="checkbox_type"] {
        width: 20px;
        height: 20px;
    }    
    
    span.select2.select2-container.select2-container--default {
        text-align: left;
    }
    
    thead {
        padding-bottom: 12px;
        display: table-caption; 
    }
    
    .table-head-row {
        background-color: #f4f4f4;
        font-weight: bold;
    }
    
    .billing-status-box {
        padding: 1px;
        padding-left: 14px;
        border: 1px solid;
        margin-bottom: 7px;
    }
    
    .status-box-Success {
        background-color: lime;
        color: black;    
    }
    
    .status-box-Declined {
        background-color: red;
        color: white;    
    }
    
    .billing-status-description {
        color: red;
    }
    
    .next-billing {
        background-color: lightgreen;
    }
</style>

<div class="col-xs-offset-3 col-xs-8">
	<div class="form-horizontal">
        
        
        <div id="A2"><!-- Begin -->
            <!-- ******************************************************************** -->
    		<!-- Group Header -->
    		<a name="info" href="#!"></a>
    		<div class="form-group">
    			<h4>Your Information</h4>
    		</div>
		
    		<?php
    		echo CHtml::beginForm('/setup/update_info', 'post', array('id'=>'info-form', 'autocomplete'=>'off'));
    		echo CHtml::errorSummary($info);
    		?>

			<?php echo CHtml::activeHiddenField($info,'id', array('value'=>$acctsetup->id)); ?>

    		<!-- Text input-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">First Name:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($info,'first_name',array('size'=>60,'maxlength'=>45,'value'=>$acctsetup->first_name)); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Last Name:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($info,'last_name',array('size'=>60,'maxlength'=>45,'value'=>$acctsetup->last_name)); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Email Address:</label>
    			  <div class="col-md-4">
    				<?php //echo CHtml::activeTextField($info,'email',array('size'=>60,'maxlength'=>75,'value'=>$acctsetup->email)); ?>
    				<input class="form-control" type="text" value="<?php echo $acctsetup->email; ?>" disabled />
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Office Phone Number:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($info,'office_phone_number',array('size'=>60,'maxlength'=>75,'value'=>$acctsetup->office_phone_number, 'class'=>'phone-mask')); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Agency Name:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($info,'agency_name',array('size'=>60,'maxlength'=>75,'value'=>$acctsetup->agency_name)); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Timezone:</label>
    			  <div class="col-md-4">
    				<?php
    				echo CHtml::activeDropDownList($info,'timezone',
    					AccountSetupFunc::timezones(),
    					array('options' =>
    						array($acctsetup->timezone=>array('selected'=>true))
    					)
    				);
    				?>
    			  </div>
    			</div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
		</div><!--End: A2 -->
		
		
		
		<div id="A3"><!-- Begin -->
    		<?php
    		echo CHtml::beginForm('', 'post', array(
    				'id'=>'logo-form',
    				'enctype'=>'multipart/form-data',
    		));
    		echo CHtml::errorSummary($logo);
    		?>
    		<!-- File upload-->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Logo</label>
    			  <div class="col-md-4">
        			  	<img src="<?php echo $this->applicationLogo(EnumLogo::CLIENT); ?>" class="img-thumbnail"><br>
        			  	<span style="font-size:11px;"><strong>Note:</strong> Program will automatically compress and scale your image to fit on our reports and header</span><br>
        				<?php if($acctsetup->logo === null): ?>
        					<?php echo CHtml::button('Upload Image', array('class'=>'btn btn-primary', 'id'=>'btn-upload-image')); ?>    					
        				<?php else: ?>
        					<?php echo CHtml::activeHiddenField($logo,'logo'); ?>
        					<?php echo CHtml::submitButton('Remove', array('submit'=>array('/setup/remove_logo'),'class'=>'btn btn-primary')); ?>
        				<?php endif; ?>
    			  </div>
    			</div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
		</div><!--End: A3 -->
		

		<div id="A4"><!-- Begin -->
    		<?php
    		echo CHtml::beginForm('/setup/update_password', 'post',array('id'=>'password-form'));
    		echo CHtml::errorSummary($changepass);
    		?>
    
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Change Password:</label>
    			  <div class="col-md-4">
    				<?php
    					echo CHtml::activePasswordField($changepass,'password', array('size'=>60,'maxlength'=>100,'value'=> '' ));
    				?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Confirm Password:</label>
    			  <div class="col-md-4">
    			  	<?php
    			  		echo CHtml::activePasswordField($changepass,'repeat_password', array('size'=>60,'maxlength'=>100,'value'=> '' ));
    			  	?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">&nbsp;</label>
    			  <div class="col-md-4">
    			  		<?php echo CHtml::submitButton('Update Password',
    				  		array(
    				  		   'class'=>'btn btn-primary'
    				  		)); ?>
    			  </div>
    			</div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
		</div><!--End: A4 -->

		<?php if($this->currentUserRole()==EnumRoles::ADMINISTRATOR): ?>
			
			<div id="A5"><!-- Begin -->
    			<!-- ******************************************************************** -->
        		<hr>
        		<!-- Group Header -->
        		<a name="security-group" href="#!"></a>
        		<div class="form-group">
        			<h4>Security Group</h4>
        		</div>
                <div class="row">
                	<table class="table table-bordered" width="100%">
                			<tr class="table-head-row">
                			  <td>Name</td>
                			  <td>Status</td>
                			  <td>Options</td>
                			</tr>
                			<?php 
                			if(!empty($security_group)):
                			   foreach($security_group as $k=>$v):
                			?>
                			<tr>
                				<td><?php echo $v->group_name; ?></td>
                				<td><?php echo strtoupper($v->status); ?></td>
                				<td>
                					<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->group_name; ?>" class="btn btn-default btn-m btn-edit-security-group">Edit Group</a>
                					<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->group_name; ?>" class="btn btn-default btn-m btn-set-permission-group">Set Permission</a>
        							<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->group_name; ?>" type="button" class="btn btn-default btn-m btn-delete-security-group">
        								<i class="fa fa-trash"></i>&nbsp;Delete
        							</button>
                				</td>
                			</tr>
                			<?php
                			   endforeach;
                			else:
                			   echo '<td colspan="3">No Security Group Assigned</td>';
                			endif;
                			?>
                			<tr>
                				<td colspan="3">
                					<button type="button" class="btn btn-primary btn-new-security-group">New Security Group</button>
                				</td>
                			</tr>
                	</table>
                </div>
            </div><!-- End: A5 -->
		
            
            <div id="A6"><!-- Begin -->
                <!-- ******************************************************************** -->
        		<hr>
        		<!-- Group Header -->
        		<a name="staff" href="#!"></a>
        		<div class="form-group">
        			<h4>Staff List</h4>
        		</div>
        		
        		<?php if(StaffFacade::getRemainingCredits() > 0): ?>
                    <div class="row">
                    	<table class="table table-bordered" width="100%">
                    			<tr class="table-head-row">
                    			  <td>Name</td>
                    			  <td>Position</td>
                    			  <td>Security Group</td>
                    			  <td>Options</td>
                    			</tr>
                    			
            					<?php 
                					if(!empty($staff)): 
                    					foreach($staff as $k=>$v):
                    					?>
                    					<tr>
                    						<td><?php echo $v->fullname; ?><br><a href="!#"><?php echo $v->email; ?></a></td>
                    						<td><?php echo $v->position; ?></td>
                    						<td>
                    						<?php
                    						$sg = SecurityGroup::model()->find('id = :id', array(
                    						    ':id'=>$v->security_group_id
                    						));
                    						if ($sg != null) {
                    						    echo $sg->group_name;
                    						}
                    						?>
                    						</td>
                    						<td>
                    							<?php if ($v->status == EnumStatus::ACTIVE): ?>
                        							<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->fullname; ?>" type="button" class="btn btn-warning btn-m btn-edit-staff">
                        								<i class="fa fa-edit"></i>&nbsp;Edit
                        							</button>
                    							<?php else: ?>
                        							<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->fullname; ?>" type="button" class="btn btn-default btn-m btn-send-staff-verification">
                        								<i class="fa fa-paper-plane-o"></i>&nbsp;Resend Registration
                        							</button>
                    							<?php endif; ?>
                    							&nbsp;&nbsp;
                    							<button data-id="<?php echo $v->id; ?>" data-fullname="<?php echo $v->fullname; ?>" type="button" class="btn btn-default btn-m btn-delete-staff">
                    								<i class="fa fa-trash"></i>&nbsp;Delete
                    							</button>
                    						</td>
                    					</tr>
                    					<?php 
                    					endforeach;
                    				else:
                    				    echo "<tr><td colspan='10'>No Staff Assigned</td></tr>";
                					endif; 
            					?>
            					
            					
                    			<tr>
                    				<td colspan="10">
                    					<?php if(StaffFacade::getRemainingCredits() > 0): ?>
                    					<button type="button" class="btn btn-primary btn-new-staff">New Staff</button>
                    					<?php endif; ?>
                    					<span><b style="color:red;">*</b> You have <strong><?php echo StaffFacade::getRemainingCredits(); ?></strong> more staff credits left</span>&nbsp;
                    					<span>[<a href="<?php echo $this->programURL(); ?>/account/setup?buy_staff_credits=true#billing">Buy More Staff Credit</a>]</span>
                    				</td>
                    			</tr>
                    	</table>
                    </div>
                <?php else: ?>
                	<div class="row">
                		<a class="btn btn-primary" href="<?php echo $this->programURL(); ?>/account/setup?buy_staff_credits=true#billing">Buy Staff Credit (<?php echo Yii::app()->numberFormatter->formatCurrency(ChargesFacade::fees()->staff_fee, "USD"); ?>)</a>
                	</div>
                <?php endif; ?>
            </div><!-- End: A6 -->

        <?php endif;  // Viewable By Admin Only ?>

		


		<div id="A7"><!-- Begin -->
            <!-- ******************************************************************** -->
    		<hr>
    		<!-- Group Header -->
    		<a name="email" href="#!"></a>
    		<div class="form-group">
    			<h4>Email Settings</h4>
    		</div>
                    
    		<?php
            echo CHtml::beginForm('/setup/update_email', 'post', array(
                'id' => 'email-form'
            ));
            echo CHtml::errorSummary($emailsetting);
            ?>
    		<!-- Text radio -->
    		<div class="row">
    			<div class="form-group">
    				<label class="col-md-2 control-label" for="">Mail Type:</label>
    				<div class="col-md-3 text-center">
    					<select id="checkbox_type" name="checkbox_type"
    						class="form-control" value="<?php echo $acctsetup->smtp_type; ?>">
    						<option value="system">System Default</option>
    						<option value="custom">Custom Mail</option>
    						<option value="gmail">Gmail</option>
    					</select>
    				</div>
    			</div>
    		</div>
    		<?php echo CHtml::activeHiddenField($emailsetting,'smtp_type', array('value'=> $acctsetup->smtp_type)); ?>
    
    		<!-- Text input -->
    		<div class="row" data-form="email">
    			<div class="form-group">
    				<label class="col-md-2 control-label" for="">SMTP Server:</label>
    				<div class="col-md-4">
    				     <?php echo CHtml::activeTextField($emailsetting,'smtp_server',array('size'=>60,'maxlength'=>45,'value'=>$acctsetup->smtp_server, 'placeholder'=>'e.g smtp.acme-mail.com')); ?>
    			    </div>
    			    <label class="col-md-1 control-label" style="width: 40px; margin-left: -8px;">Port:</label>
    				<div class="col-md-1">
    				     <?php echo CHtml::activeTextField($emailsetting,'smtp_port',array('size'=>60,'maxlength'=>4,'value'=>$acctsetup->smtp_port, 'placeholder'=>'25')); ?>
    			    </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row" data-form="email">
    			<div class="form-group">
    				<label class="col-md-2 control-label" for="">Username:</label>
    				<div class="col-md-4">
    				<?php echo CHtml::activeTextField($emailsetting,'smtp_username',array('size'=>60,'maxlength'=>45,'value'=>$acctsetup->smtp_username)); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row" data-form="email">
    			<div class="form-group">
    				<label class="col-md-2 control-label" for="">Password:</label>
    				<div class="col-md-4">
    				<?php echo CHtml::activePasswordField($emailsetting,'smtp_password',array('size'=>60,'maxlength'=>45,'value'=>$this->security_decrypt($acctsetup->smtp_password))); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Send Test Email / Gmail  -->
    		<div class="row">
    			<div class="form-group">
        			<div class="col-xs-offset-2 col-xs-10">
                            <?php echo CHtml::submitButton('Update', array('id'=>'btn-update-email-setting', 'class'=>'btn btn-primary')); ?>
                            
        					<button id="btn-testemail" href="/tests/email" type="button"
        						class="btn btn-primary">Test Email</button>
    
        					<button id="btn-gmail" type="button"
        						class="btn btn-warning" data-toggle="modal"
        						data-target="#gmail-instruction">Gmail Instruction</button>
        			</div>
    			</div>
    		</div>
    		
    		<div class="row">
    			<div class="form-group">
        			<div class="col-xs-offset-2 col-xs-8">
                            <!-- <img id="email-indicator" /> -->
    						<h2 id="email-indicator-text"></h2>
        			</div>
    			</div>
    		</div>
    
    		<div id="gmail-instruction" class="modal fade" role="dialog">
    			<div class="modal-dialog">
    				<div class="modal-content">
    					<div class="modal-header">
    						<button type="button" class="close" data-dismiss="modal">&times;</button>
    						<h4 class="modal-title">Update Your Gmail Account Setting</h4>
    					</div>
    					<div class="modal-body">
    						<div class="row">
    							<div class="form-group">
    								<div class="col-xs-offset-1 col-md-9" style="font-size: 13px !important;">
    									<p>
    										1. Login to your Gmail account at <a target="_blank"
    											href="https://myaccount.google.com/">https://myaccount.google.com/</a>
    									</p>
    									<p>
    										2. On the account homepage, click Sign-in & security or
    										navigate to <a target="_blank"
    											href="https://myaccount.google.com/security">https://myaccount.google.com/security</a>
    									</p>
    									<img style="width: 120%;"
    										src="//res.cloudinary.com/dugzxvsa2/image/upload/v1519121628/1_cdxp77.png" />
    									<br>
    									<br>
    									<p>
    										3. Scroll down to the <strong>"Allow less secure Apps"</strong>,
    										and have it enabled.
    									</p>
    									<img style="width: 120%;"
    										src="//res.cloudinary.com/dugzxvsa2/image/upload/v1519121628/2_w6lvxs.png" />
    									<br>
    									<br>
    									<p>
    										4. Now navigate to <a target="_blank"
    											href="https://accounts.google.com/DisplayUnlockCaptcha">https://accounts.google.com/DisplayUnlockCaptcha</a>
    										and Click <strong>Continue</strong>
    									</p>
    									<img style="width: 120%;"
    										src="//res.cloudinary.com/dugzxvsa2/image/upload/v1519121628/3_bbmvai.png" />
    									<br>
    									<br><img style="width: 120%;" src="//res.cloudinary.com/dugzxvsa2/image/upload/v1519121628/4_kafbtn.png" />
    									<br>
    									<br>
    									<p>
    										5. Viola! Setup Complete. Test it by Clicking "Test Email"
    									</p>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
        </div><!-- End: A7 -->
        
		<div id="A7-b"><!-- Begin -->
            <!-- ******************************************************************** -->
    		<hr>
    		<!-- Group Header -->
    		<a name="email-template" href="#!"></a>
    		<div class="form-group">
    			<h4>Email Templates</h4>
    		</div>

    		<?php
            echo CHtml::beginForm('/setup/update_email', 'post', array(
                'id' => 'email-tempalte-form'
            ));
            ?>
    		<div class="row">
    			<div class="col-xs-8">
    				<button type="button" class="btn btn-success btn-add-email-template"><i class="fa fa-send"></i> Add Template</button>
    				<br>
    				<br>
					<?php
					if (!empty($emailtemplates)):
					?>
    				<table class="table table-responsive table-bordered">
    					<tbody>
    						<tr class="table-head-row">
    							<td>Name</td>
    							<td>Options</td>
    						</tr>
    						
    						<?php 
    						foreach($emailtemplates as $k=>$v):
    						?>
    						<tr>
    							<td>
								<?php 
									$t = EnumStatus::emailtemplates();
									if (array_key_exists($v->code, $t)) {
										echo EnumStatus::emailtemplates()[$v->code]; 
									} else {
										echo '**deleted**';
									}
								?>
								</td>
    							<td>
								    <button type="button" class="btn btn-primary btn-sm btn-edit-email-template" data-id="<?php echo $v->id; ?>">Edit</button>
    								<button type="button" class="btn btn-primary btn-sm btn-delete-email-template" data-id="<?php echo $v->id; ?>">Delete</button>
									<button type="button" class="btn btn-primary btn-sm btn-preview-email-template" data-id="<?php echo $v->id; ?>">Preview</button>
									<!-- <button type="button" class="btn btn-primary btn-sm btn-send-email-template" data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->code; ?>">Send Test</button> -->
    							</td>
    						</tr>
    						<?php 
    						endforeach;
    						?>

							<tr>
								<td colspan="10"><b class="red">Note: </b>Email events that not listed here will use the default message</td>
							</tr>
    					</tbody>
    				</table>
					<?php
					endif;
					?>
    			</div>
    		</div>
    		<?php 
    		echo CHtml::endForm();
    		?>
    		
    		
    	</div>
        

		
		<?php if($this->currentUserRole()==EnumRoles::ADMINISTRATOR): ?>
			
			<!-- ******************************************************************** -->
    		<hr>
    		<a name="billing" href="#!"></a>
    		<!-- Group Header -->
    		<div class="form-group">
    			<h4>Billing</h4>
    		</div>
    
    		<?php
            echo CHtml::beginForm('/setup/bill_payment', 'post', array(
                'id' => 'billing-form'
            ));
            ?>		
    		<!-- Text input -->
    		<div class="row">
    			<div class="col-md-10">
    				<div class="col-md-2">
    				</div>
    				<div class="col-md-6">
    					<?php 
    					if(isset($_GET['billstatus'])): 
    					$billstatus = ($_GET['billstatus'] == 'ok') ? 'Success' : 'Declined';
    					?>
    					<div class="billing-status-box status-box-<?php echo $billstatus; ?>">
    						<h4 class="billing-status-text">Status - <?php echo $billstatus; ?></h4>
    					</div>
    					<?php 
    					endif; 
    					?>
    				</div>
    				<div class="col-md-4">
    					<button type="button" class="btn btn-warning btn-block btn-billing-process-card">Process Card</button>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-offset-2 col-md-10">
    				<?php if(Yii::app()->user->hasFlash('billerror')): ?>
    					<p class="billing-status-description"><?php echo Yii::app()->user->getFlash('billerror'); ?></p>
                        <!--    <p class="billing-status-description">The attempt to process your charge failed. Please update your payment information</p> -->
    				<?php endif; ?>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-10">
    				<div class="col-md-2 text-right">
    					<span>Credit Card:</span>
    				</div>
    				<div class="col-md-6">
    					<?php 
    					$arr_creditcard = array();
    					foreach($credit_cards as $k=>$v) {
    					    $arr_creditcard[$v->id] = $v->card_type .' - '. $this->creditcardHide($v->credit_card);
    					    if ($v->is_primary == '1') {
    					        $arr_creditcard[$v->id] .= ' (Default)';
    					    }
    					}
    					?>
    					<?php echo CHtml::activeDropDownList($billingform, 'credit_card', $arr_creditcard, array('class'=>'form-control')); ?>
    				</div>
    				<div class="col-md-4">
    					<button type="button" class="btn btn-primary btn-block btn-credit-card-settings">Credit Card Settings</button>
    				</div>
    			</div>
    		</div>
    		
    		
    		<?php if (isset($_GET['buy_staff_credits'])): ?>
    			<?php echo CHtml::activeHiddenField($billingform, 'invoice_type', array('value'=>EnumStatus::BUYSTAFF)); ?>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Number Credits:</span>
        				</div>
        				<div class="col-md-6">
        					<label><?php echo ChargesFacade::fees()->staff_credits; ?></label>
        				</div>
        				<div class="col-md-2">
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Charge Amount:</span>
        				</div>
        				<div class="col-md-6">
        					<label><?php echo Yii::app()->numberFormatter->formatCurrency(ChargesFacade::fees()->staff_fee, "USD"); ?></label>
        				</div>
        				<div class="col-md-2">
        				</div>
        			</div>
        		</div>
    		<?php else: ?>
    			<?php echo CHtml::activeHiddenField($billingform, 'invoice_type', array('value'=>EnumStatus::SUBSCRIPTION)); ?>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Next Billing Date:</span>
        				</div>
        				<div class="col-md-6">
        					<?php echo CHtml::activeTextField($billingform, 'next_billing', array('class'=>'form-control next-billing','onkeypress'=>'return false', 'value'=>  BillingFacade::next_billing() )); ?>
        				</div>
        				<div class="col-md-2">
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Invoice:</span>
        				</div>
        				<div class="col-md-6">
        					<?php echo CHtml::activeDropDownList($billingform, 'invoice_no', BillingFacade::invoices(), array('class'=>'form-control')); ?>
        				</div>
        				<div class="col-md-4">
        					<button type="button" class="btn btn-primary btn-block btn-download-invoice">Download Invoice</button>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Promo Code:</span>
        				</div>
        				<div class="col-md-6">
        					<?php echo CHtml::activeTextField($billingform, 'promo_code', array('class'=>'form-control')); ?>
        				</div>
        				<div class="col-md-2">
        				</div>
        			</div>
        		</div>

			    <?php if(!empty(BillingFacade::giftcard_orders())): ?>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-2 text-right">
        					<span>Giftcards Orders:</span>
        				</div>
        				<div class="col-md-6">
							<?php 
							BillingFacade::giftcard_orders_html();
							?>
        				</div>
        				<div class="col-md-2">
        				</div>
        			</div>
        		</div>
				<?php endif; ?>

    		<?php endif; ?>		
    		<?php echo CHtml::endForm(); ?>

			<div id="A18"><!-- Begin -->
				<script>
				function cancelAccountNow() {
					var needtosettle = '';
					$('#BillingForm_invoice_no option').each(function(k, v) {
						var inv = $(v).text();
						if(inv.indexOf('UNPAID') != -1) {
							bootbox.alert('You have UNPAID invoice need to be settle.');
							needtosettle = 'yes';
						}
					});
					if (needtosettle == '') {
						var email = '<?php echo $acctsetup->email; ?>';
						bootbox.prompt('To Confirm Enter this Email address "'+ email +'"', function(inpt) { 
							if (!inpt) {
								return;
							}
							if (email === inpt) {
								$('#cancel-form').submit();
							} else {
								bootbox.alert('Invalid Email');
							}
						});
					}
				}
				</script>
				<!-- ******************************************************************** -->
				<hr>
				<!-- Group Header -->
				<a name="membership" href="#!"></a>
				<div class="form-group">
					<h4>Membership</h4>
				</div>
				<?php
				echo CHtml::beginForm('/setup/cancel_account', 'post', array(
					'id' => 'cancel-form',
				));
				?>	
					<div class="row">
						<div class="col-md-12">
								<input type="button" class="btn btn-warning btn-block pull-left" onclick="cancelAccountNow()" value="Cancel Subscription" />
								<br>
								<br>
								<p style="color:red" class="text-center"><b>NOTE:</b> You can cancel your account anytime, as long theres no outstanding bill invoice</p>
						</div>
					</div>
				<?php echo CHtml::endForm(); ?>
			</div><!-- End: A18 -->
		<?php endif; ?>
		
		

		<div id="A11"><!-- Begin -->
    		<!-- ******************************************************************** -->
    		<hr>
    		<a name="listing" href="#!"></a>
    		<!-- Group Header -->
    		<div class="form-group">
    			<h4>List</h4>
    		</div>
    		
            <?php
            echo CHtml::beginForm('/setup/update_listing', 'post', array(
                'id' => 'listing-form'
            ));
            echo CHtml::errorSummary($listing);
            ?>
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Appointment Locations:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($listing,'apointment_locations',array('size'=>60,'maxlength'=>1000,'value'=>$acctsetup->apointment_locations, 'placeholder'=>'e.g New York, Washington, Toronto, New Jersey')); ?>
    			  </div>
    			</div>
    		</div>
    
    		<!-- Text input -->
    		<div class="row">
    			<div class="form-group">
    			  <label class="col-md-2 control-label" for="">Staff:</label>
    			  <div class="col-md-4">
    				<?php echo CHtml::activeTextField($listing,'staff',array('size'=>60,'maxlength'=>1000,'value'=>$acctsetup->staff,'placeholder'=>'e.g Adam, Jacob, Ronnie, Eve, Rey')); ?>
    			  </div>
    			</div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
		</div><!-- End: A11 -->
		
		<div id="A12"><!-- Begin -->
    		<!-- ******************************************************************** -->
    		<hr>
    		<?php
    		echo CHtml::beginForm('/setup/update_colour','post',array('id'=>'colour-form'));
    		?>
    
    		<!-- Group Header -->
    		<a name="colour" href="#!"></a>
    		<div class="form-group">
    		  <h4>Color Scheme</h4>
    		</div>
    
    		<!-- Text input -->
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Page Text Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_1" class="colour-box" style="background-color: <?php echo $colors->color_1; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_1]" value="<?php echo $colors->color_1; ?>">
    		    </div>
    		    <div class="col-md-2">
    		      <label class="control-label" for="">Color Scheme:</label>
    		      <table>
    		        <tr>
    		          <td>
    		            <?php
    		            $scheme_id = is_null($acctsetup->colour_scheme_id) ? 1 : $acctsetup->colour_scheme_id;
    		            echo CHtml::activeDropDownList($colour, 'colour_scheme_id',
    		                 CHtml::listData(ColourScheme::model()->findAll(), "id", "scheme_name"),
    		                 array('options'=>array($scheme_id=>array('selected'=>'true')),
    		                       'class'=>'col-xs-12'
    		                 ));
    		            ?>
    		          </td>
    		        </tr>
    		      </table>
    		    </div>
    		  </div>
    		</div>
    
    		<input type="hidden" id="hidden_colour_scheme_id" name="CustomColor[scheme_id]" value="<?php echo $scheme_id; ?>">
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Input Field Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_2" class="colour-box" style="background-color: <?php echo $colors->color_2; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_2]" value="<?php echo $colors->color_2; ?>">
    		    </div>
    		  </div>
    		</div>
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Button Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_3" class="colour-box" style="background-color: <?php echo $colors->color_3; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_3]" value="<?php echo $colors->color_3; ?>">
    		    </div>
    		  </div>
    		</div>
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Button Text Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_4" class="colour-box" style="background-color: <?php echo $colors->color_4; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_4]" value="<?php echo $colors->color_4; ?>">
    		    </div>
    		  </div>
    		</div>
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Box Background Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_5" class="colour-box" style="background-color: <?php echo $colors->color_5; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_5]" value="<?php echo $colors->color_5; ?>">
    		    </div>
    		  </div>
    		</div>
    		<div class="row">
    		  <div class="form-group">
    		    <label class="col-md-2 control-label" for="">Box Text Color:</label>
    		    <div class="col-md-2">
    		      <div id="color_6" class="colour-box" style="background-color: <?php echo $colors->color_6; ?>;"></div>
    		      <input type="hidden" name="CustomColor[color_6]" value="<?php echo $colors->color_6; ?>">
    		    </div>
    		  </div>
    		</div>
    		<?php echo CHtml::endForm(); ?>
		</div><!-- End: A12 -->
		
		
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
					'id'=>'gift-cards-form',
					'enableAjaxValidation'=>false,
		));
		?>
		<div id="A13"><!-- Begin A13 -->
        		<!-- ******************************************************************** -->
        		<hr>
        		<a name="referral" href="#!"></a>
        		<!-- Group Header -->
        		<div class="form-group">
        			<h4>Referral Program</h4>
        		</div>
        		<!-- Text input -->
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-offset-1 col-md-10">
        					<table width="100%">
        						<tr>
        							<td><?php echo $form->checkbox($giftcards,'use_referral'); ?></td>
        							<td><label>Use Coverage Insights Referral Program</label></td>
        						</tr>
        						<tr>
        							<td><?php echo $form->checkbox($giftcards,'i_agree'); ?></td>
        							<td><label>I agree to the terms and use of Coverage Insight Referral Program <a href="#">Term of Use</a></label></td>
        						</tr>
        					</table>
        				</div>
        			</div>
        		</div>
    	</div><!-- End: A13 -->
		<?php if ($giftcards->use_referral == 1 && $giftcards->i_agree == 1): ?>
		<input type="hidden" name="referralON" value="true" />
    	<div id="A14"><!-- Begin A14 -->
        		<div class="form-group">
        			<h4>Build your Referral Program</h4>
        		</div>
        		<div class="row">
        			<div class="col-md-10">
        				<div class="col-md-offset-1 col-md-10">
        					<table width="100%">
        						<!-- <tr>
        							<td><?php echo $form->checkbox($giftcards,'offer_pre_enrollment_credit'); ?></td>
        							<td><label>Offer Pre-Enrollment Credit</label></td>
									
        						</tr>
        						<tr>
        							<td></td>
        							<td>Credit Amounts:</td>
        							<td><?php echo $form->textField($giftcards,'pre_credit_amounts', array('class'=>'form-control', 'placeholder'=>'e.g 10,20,30')); ?></td>
        						</tr>
        						<tr>
        							<td></td>
        							<td>Gift Cards to Offer:</td>
        							<td><?php echo $form->textField($giftcards,'pre_gift_cards_offer', array('class'=>'form-control', 'placeholder'=>'e.g Amazon, BestBuy')); ?></td>
        						</tr> -->

								
        
        						<tr>
        							<td>&nbsp;</td>
        						</tr>
        
        						<tr>
        							<td><?php //echo $form->checkbox($giftcards,'offer_enrollment_credit'); ?></td>
        							<td><label>Gift Card Credit</label></td>
        						</tr>
        						<tr>
        							<td></td>
        							<td>Credit Amounts:</td>
        							<td><?php echo $form->textField($giftcards,'credit_amounts', array('class'=>'form-control', 'placeholder'=>'e.g 10,20,30')); ?></td>
        						</tr>
        						<tr>
        							<td></td>
        							<td>Gift Cards to Offer:</td>
        							<td><?php echo $form->textField($giftcards,'gift_cards_offer', array('class'=>'form-control', 'placeholder'=>'e.g Amazon, BestBuy')); ?></td>
        						</tr>

        					</table>
        				</div>
        			</div>
        		</div>
		</div><!-- End: A14 -->
		<?php endif; ?>

		<?php $this->endWidget(); ?> <!-- A13 & A14 mixed -->

		
		<div id="A15"><!-- Begin -->
    		<!-- ******************************************************************** -->
    		<hr>
    		<!-- Group Header -->
    		<a name="policies" href="#!"></a>
    		<div class="form-group">
    			<h4>Policy Type Setup</h4>
    		</div>
    
    		<?php foreach(AccountSetupFunc::insurance_types() as $insurance_type): ?>
    		<?php $insurance_type = str_replace(' ', '_', $insurance_type); ?>
    		<?php echo CHtml::beginForm('','post',array('id'=>'policies-'.$insurance_type.'-form')); ?>
    		<hr>
    		<div class="row">
    			<!-- Option -->
    			<table id="tbl-<?php echo $insurance_type; ?>" class="tbl-policies">
    				<input type="hidden" id="<?php echo $insurance_type; ?>-count" name="PoliciesForm[<?php echo $insurance_type; ?>_count]" value="1" />
    				<thead>
    					<tr>
    						<td>
    							<input
    							name="PoliciesForm[ParentChk_<?php echo $insurance_type; ?>]"
    							type="checkbox"
    							class="setup-checkbox pull-right"
    							data-type="<?php echo $insurance_type; ?>"
    							<?php echo ($acctsetup['is_'. $insurance_type .'_checked']==1) ? 'checked' : ''; ?>
    							/>
    						</td>
    						<td colspan="10">
    							<span class="text-left" style="display:inline-block; width: 21vw;">&nbsp;<?php echo str_replace('_', ' ', $insurance_type); ?></span>
    							<button type="button" class="btn-resource-upload btn btn-primary pull-right" data-itype="<?php echo $insurance_type; ?>"><i class="fa fa-upload"></i>&nbsp;Resource Upload</button>
    						</td>
    					</tr>
    				</thead>
    				<tbody></tbody>
    				<tfoot>
    					<tr>
    						<td>&nbsp;</td>
    						<td>
    							<br>
    							<div class="col-xs-offset-2 col-xs-6">
    								<button id="btn-<?php echo $insurance_type; ?>" type="button" name="button" class="btn btn-primary pull-right">Add</button>
    							</div>
    						</td>
    					</tr>
    				</tfoot>
    			</table>
    		</div>
            <?php echo CHtml::endForm(); ?>
            <?php endforeach; ?>
	  	</div><!-- End: A15 -->

		<p>&nbsp;</p>

	</div>
</div>

<script>
	app.policies = '<?php $this->returnJSON($policies); ?>';
	// Cloudinary
	app.cl_cloud_name         = "<?php echo Yii::app()->params['cl_cloud_name']; ?>";
	app.cl_upload_preset      = "<?php echo Yii::app()->params['cl_upload_preset']; ?>";  // company logo
	app.cl_client_docs_preset = "<?php echo Yii::app()->params['cl_client_docs_preset']; ?>";  // client documents
	app.cl_api_endpoint       = global_config.base_url + "/api/cloudinary_usage";
</script>

<?php
// cloudinary library
Yii::app()->clientScript->registerScriptFile(
    '//widget.cloudinary.com/global/all.js',
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/node_modules/lodash/lodash.js',
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/node_modules/cloudinary-core/cloudinary-core.js',
    CClientScript::POS_END
);

// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/account_setup.js',
	CClientScript::POS_END
);
?>