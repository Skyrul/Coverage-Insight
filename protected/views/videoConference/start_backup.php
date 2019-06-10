<?php
$this->page_label = "Video Conference & Screen Share";
?>

<style>
    .local-wrapper {
    }

    .local-img {
        position: absolute;
        top: 27vh;
        left: 31vw;
        width: 166px;
        background-color: black;
        border: 1px solid white;
        cursor: move;
    }
    
    .remote-img {
        width: 96%;
        display: block;
        margin: 0 auto;
        background-color: black;
        border: 5px solid gray;
        box-shadow: 0px 0px 10px #888888;
    }

    .circle-button {
        border-radius: 7px;
        border: 2px solid #b48700;
        color: #f4f2ed;
        background-color: #FF9800;
        text-align: center;
        width: 108px;
        height: 74px;
        padding: 8px;
        cursor: pointer;
    }

    .circle-button:hover {
        border: 2px solid #30439e;
        color: #ffffff;
        background-color: #0e5976de;
        box-shadow: 0px 0px 10px #888888;
    }

    .vid-btns {
        display: block;
        margin: 0 auto;
        padding-top: 10px;
    }

</style>

<div class="col-md-12">
    <!-- Action buttons -->
    <div class="col-md-1">
        <table class="vid-btns">
            <tr>
                <td>
                    <div id="vidbtn-audio" class="circle-button">
                    <i class="fa fa-phone fa-2x"></i><br> Call
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="vidbtn-video" class="circle-button">
                    <i class="fa fa-video-camera fa-2x"></i><br> Video
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="vidbtn-screen-share" class="circle-button">
                    <i class="fa fa-desktop fa-2x"></i><br> Share Screen
                    </div>
                </td>
            </tr>
        </table>
    </div>


    <!-- Video stream -->
	<div class="col-md-6 form">

        <div class="local-wrapper">
            <span class="local-info-text"></span>
            <table>
                <tr>
                    <td><img src="<?php echo $this->programURL(); ?>/images/screen1.png" class="remote-img" alt="Remote Webcam"></td>
                </tr>
                <tr>
                    <td><img src="<?php echo $this->programURL(); ?>/images/screen1.png" class="local-img" id="dragable" alt="Local Webcam"></td>
                </tr>
            </table>
        </div>
	</div>


    <!-- Customer information -->
    <div class="col-md-4">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#appointment">Appointment</a></li>
                <li><a data-toggle="tab" href="#primary">Primary Information</a></li>
                <li><a data-toggle="tab" href="#secondary">Secondary Information</a></li>
            </ul>

            <div class="tab-content">
                <div id="appointment" class="tab-pane fade in active">
                    <?php if($appointment != null): ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="alert-info2" width="20%">Date:</td>
                                <td><?php echo $appointment->appointment_date; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Time:</td>
                                <td><?php echo $appointment->appointment_time; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Location:</td>
                                <td><?php echo $appointment->location; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
                <div id="primary" class="tab-pane fade">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td class="alert-info2" width="20%">Name: </td><td><?php echo $customer->primary_firstname.' '.$customer->primary_lastname; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Telephone: </td><td><?php echo $customer->primary_telno; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Mobile: </td><td><?php echo $customer->primary_cellphone; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Alt Telephone: </td><td><?php echo $customer->primary_alt_telno; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Email: </td><td><?php echo $customer->primary_email; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Emergency Contact: </td><td><?php echo $customer->primary_emergency_contact; ?></td>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <div id="secondary" class="tab-pane fade">
                        <table class="table table-bordered">
                            <!-- <tbody>
                            <tr>
                                <td colspan="10" class="alert-info"><strong>Secondary Information</strong></td>
                            </tr> -->
                            <tr>
                                <td class="alert-info2" width="20%">Name: </td><td><?php echo $customer->secondary_firstname.' '.$customer->secondary_lastname; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Telephone: </td><td><?php echo $customer->secondary_telno; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Mobile: </td><td><?php echo $customer->secondary_cellphone; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Alt Telephone: </td><td><?php echo $customer->secondary_alt_telno; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Email: </td><td><?php echo $customer->secondary_email; ?></td>
                            </tr>
                            <tr>
                                <td class="alert-info2" width="20%">Emergency Contact: </td><td><?php echo $customer->secondary_emergency_contact; ?></td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div><!--end: row -->

        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <tr>
                    <td colspan="10" class="alert-info2">
                        Coverage Insights Links:<br>
                        <ul>
                            <li><a href="<?php echo $this->programURL() . '/agentprep/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Agent Prep (AP)</a></li>
                            <li><a href="<?php echo $this->programURL() . '/needassessment/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Needs Assessment (NA)</a></li>
                            <li><a href="<?php echo $this->programURL() . '/cir/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Customer Review (CIR)</a></li>
                            <li><a href="#!" onclick="showReport('<?php echo $this->programURL(); ?>/reports/renderpdf?report_name=cir&report_type=basic&customer_id=<?php echo $customer->id; ?>')">CIR Report</a></li>
                        </ul>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div><!-- end: col-md-12 -->