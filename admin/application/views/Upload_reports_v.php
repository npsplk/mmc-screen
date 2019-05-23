<script>
    var jsreturn_url = "<?php echo!empty($return_url) ? $return_url : '' ?>";
</script>
<body class="form-page">
    <?php $this->load->view('template/sidebar'); ?>
    <div class="main-container">            
        <?php $this->load->view('template/header_image'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h3><?php echo $title ?></h3>
                </div>
            </div>
        </div>
        <style>
            .main-container .row {
                margin: 0;
            }

        </style>
        <div class="row">
            <div id="clearance_application" >
                <form name="report_updates" id="report_updates" class="form-horizontal" enctype="multipart/form-data">

                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="division_id" class="control-label col-lg-4 validate-parent">Report Type<span> *</span></label>
                            <div class="col-lg-8 validate-parent">
                                <?php
                                echo form_dropdown('report_type" id="report_type" required class="form-control text-left"', $report_type, 0);
                                ?> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="letter_file_name" class="control-label col-lg-4">File &nbsp; (Max 15mb)<span> *</span></label>
                            <div class="col-lg-8 validate-parent">
                                <div id="fileName"></div>
                                <div id="fileSize"></div>
                                <div id="fileType"></div>

                                <input type="file" data-toggle="tooltip" data-placement="top" title="Supported file formats:  doc | docx | pdf | xls | xlsx" id="fileToUpload" name="fileToUpload" onchange="" class="form-control validate-parent"/>

                            </div>                                    
                        </div>
                        <div class="form-group">
                            <label for="division" class="control-label col-lg-4">Division</label>
                            <div class="col-lg-8 validate-parent">
                                <?php
                                echo form_dropdown('division_id" id="division_id" class="form-control text-left"', $division, isset($vehicle_info->division_id) ? $vehicle_info->division_id : '', $divi_disable);
                                ?> 

                            </div>
                        </div>
                        <div class="form-group">
                            <label style="" class="checkbox-inline control-label col-lg-11" ><input id="check_doc" type="checkbox" value="">Check to select the reference document</label>
                        </div>
                        <div class="form-group hidden" id="reference_document">
                            <label for="division" class="control-label col-lg-4">Reference Document</label>
                            <div class="col-lg-8 validate-parent">
                                <?php
                                echo form_dropdown('ref_document" id="ref_document" class="form-control text-left"', $subjects, isset($vehicle_info->division_id) ? $vehicle_info->division_id : '', $divi_disable);
                                ?> 

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="letter_date" class="control-label col-lg-4">Report Date<span class="required-field"> *</span></label>
                            <div class="col-lg-8 validate-parent">
                                <input type="text"  name="letter_date"  id="letter_date"  class="form-control " placeholder="yyyy-mm-dd" value="<?php echo isset($letter_log->letter_date) ? $letter_log->letter_date : ''; ?>" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject"
                                   class="control-label col-lg-4">Subject<span> *</span></label>
                            <div class="col-lg-8 validate-parent">
                                <input type="text"
                                       name="subject"
                                       id="subject"
                                       class="form-control text-left subject"
                                       value=""
                                       required=""
                                       />
                            </div>
                        </div>
                    </div>






                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                        <div class="form-group">
                            <label for="ref_no"
                                   class="control-label col-lg-4">Reference No<span> </span></label>
                            <div class="col-lg-8 validate-parent">
                                <input type="text"
                                       name="ref_no"
                                       id="ref_no"
                                       <?php echo $readonly ?>
                                       class="form-control text-left ref_no"
                                       value=""
                                       required=""
                                       />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label col-lg-4">Description<span class="required-field"> </span></label>
                            <div class="col-lg-8 validate-parent">

                                <textarea style="height: 60px;" class="form-control remarks" name="remarks" rows="5" id="remarks"></textarea>

                            </div>
                        </div>

                    </div>



                    <div class="col-lg-12 col-md-12">

                        <?php
                        if (!empty($letter_log->letter_id)) {
                            echo '<button type="button" id="btn_update" name="btn_update" class="btn btn-success pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</button>';
                        } else {
                            echo '<button type="button" id="btn_save" name="btn_save" class="btn btn-success pull-right"><i class="fa fa-save" aria-hidden="true"></i> Save</button>';
                        }
                        ?>

                    </div>
                </form>     
            </div> 
        </div>

        <br>


        <div class="clearfix"></div>
        <div id="loading_animation_div" style="display: none;" class="loading_animation_content">
            <img id="loading_animation_img" src="<?php echo base_url("assets/images/loading.gif"); ?>" style="max-height:50px;">
        </div>
        <div class="backDrop loading_animation_content" style="display: none;" ></div>             





