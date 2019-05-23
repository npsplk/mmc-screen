<body class="form-page">
    <?php $this->load->view('template/sidebar'); ?>
    <div class="main-container">            
        <div class="container">
            <?php $this->load->view('template/header_image'); ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h3>Tender Information</h3>
                    </div>
                </div>
            </div>


            <form name="stall_booking_form" 
                  id="stall_booking_form" 
                  class="form-horizontal stall_booking_form_c">

                <input type="hidden" name="tender_id" id="tender_id" value="<?php echo $data->tender_id; ?>">


                <div id="stalls" style="">
                    <div class="row">

                        <div class="col-md-6" style="">

                            <div class="form-group">
                                <label for="job_order" 
                                       class="control-label col-lg-4">Job Order/PR<span> *</span></label>
                                <div class="col-lg-8 validate-parent">
                                    <input type="text" 
                                           name="job_order" 
                                           id="job_order" 
                                           placeholder="type order" 
                                           class="form-control text-left job_order" 
                                           value="<?php echo $data->job_order; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_division" 
                                       class="control-label col-lg-4">User Division<span> *</span></label>
                                <div class="col-lg-8 validate-parent">
                                    <select type="text" 
                                            name="user_division" 
                                            id="user_division" 
                                            class="form-control text-left user_division" 
                                            >
                                        <option value=""> - Select Option - </option>
                                        <?php foreach ($CorpDivision as $key1 => $val1) { ?>
                                            <option <?php $val1->value == $data->user_division ? print 'selected="selected"' : print ''; ?> value="<?php echo $val1->value; ?>"> <?php echo $val1->name; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="procurement_type_id" 
                                       class="control-label col-lg-4">Procurement Type<span> *</span></label>
                                <div class="col-lg-8 validate-parent">
                                    <select type="text" 
                                            name="procurement_type_id" 
                                            id="procurement_type_id" 
                                            class="form-control text-left procurement_type_id" 
                                            >
                                        <option value=""> - Select Option - </option>
                                        <?php foreach ($SuppliesProcurementType as $key2 => $val2) { ?>
                                            <option <?php $val2->value == $data->procurement_type_id ? print 'selected="selected"' : print ''; ?> value="<?php echo $val2->value; ?>"> <?php echo $val2->name; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="procurement_no" 
                                       class="control-label col-lg-4">Procurement No<span> *</span></label>
                                <div class="col-lg-8 validate-parent">
                                    <input type="text" 
                                           name="procurement_no" 
                                           id="procurement_no"
                                           placeholder="Eg: TY234"  
                                           class="form-control text-left procurement_no" 
                                           value="<?php echo $data->procurement_no; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="selection_type_id" 
                                       class="control-label col-lg-4">Supplier Selection<span> *</span></label>
                                <div class="col-lg-8 validate-parent">
                                    <select type="text" 
                                            name="selection_type_id" 
                                            id="selection_type_id" 
                                            class="form-control text-left selection_type_id"
                                            >
                                        <option value=""> - Select Option - </option>
                                        <?php foreach ($getSuppliesSupplierSelection as $key3 => $val3) { ?>
                                            <option <?php $val3->value == $data->selection_type_id ? print 'selected="selected"' : print ''; ?> value="<?php echo $val3->value; ?>"> <?php echo $val3->name; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6" style="">

                            <div class="form-group">
                                <label for="document_fee" 
                                       class="control-label col-lg-4">Document Fee<span> </span></label>
                                <div class="col-lg-8 validate-parent">
                                    <input type="text" 
                                           name="document_fee" 
                                           id="document_fee" 
                                           placeholder="Eg: 3000" 
                                           class="form-control text-left document_fee" 
                                           value="<?php echo $data->document_fee; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estimated_value" 
                                       class="control-label col-lg-4">Estimated Value<span> </span></label>
                                <div class="col-lg-8 validate-parent">
                                    <input type="text" 
                                           name="estimated_value" 
                                           id="estimated_value" 
                                           placeholder="Eg: 45000" 
                                           class="form-control text-left estimated_value" 
                                           value="<?php echo $data->estimated_value; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bid_bond" 
                                       class="control-label col-lg-4">Bid Bond<span> </span></label>
                                <div class="col-lg-8 validate-parent">
                                    <input type="text" 
                                           name="bid_bond" 
                                           id="bid_bond" 
                                           placeholder="type value" 
                                           class="form-control text-left bid_bond" 
                                           value="<?php echo $data->bid_bond; ?>"/>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12" style="">
                            <div class="form-group">
                                <label for="procurement_title" 
                                       class="control-label col-lg-2">Title<span class="required-field"> *</span></label>
                                <div class="col-lg-10 validate-parent">
                                    <textarea type="text" 
                                              name="procurement_title" 
                                              id="procurement_title" 
                                              placeholder="type a title" 
                                              class="form-control text-left procurement_title" 
                                               required=""><?php echo $data->procurement_title; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tender_remarks" 
                                       class="control-label col-lg-2">Remarks<span> </span></label>
                                <div class="col-lg-10 validate-parent">
                                    <textarea type="text" 
                                              name="tender_remarks" 
                                              id="tender_remarks" 
                                              placeholder="your remarks" 
                                              class="form-control text-left tender_remarks" 
                                              ><?php echo $data->tender_remarks; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10">
                                </div>
                                <!--<label class="col-md-8 control-label" for="save"></label>-->
                                <div class="col-md-2">

                                    <button id="save_button" name="save_button" type="button" class="btn btn-success" style="">
                                        <?php if ($data->tender_id > 0): ?>
                                            Update
                                        <?php else: ?>
                                            Save
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>

        </div>
