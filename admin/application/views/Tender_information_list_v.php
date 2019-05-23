<body class="form-page">
    <?php $this->load->view('template/sidebar'); ?>
    <div class="main-container">            
        <div class="container">
            <?php $this->load->view('template/header_image'); ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h3>Tender Information List</h3>
                    </div>
                </div>
            </div>
             <!--end of row-->
             <?php 
//             print_r($permissions);
             ?>
            <br/>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading"> Tender Information List</div>
                        <div class="panel-body">
                            <table class="table grid_list_table" id="grid_list_table" style="width: 100%"> 
                                <thead> 
                                    <tr> 
                                        <th>Job Order</th> 
                                        <th>User Division</th> 
                                        <th>Procurement No.</th> 
                                        <th>Document Fee</th>  
                                        <th>Estimated Value</th> 
                                        <th>Actions</th> 
                                    </tr> 
                                </thead> 
                                <tbody>

                                </tbody> 
                            </table>                            
                        </div>

                    </div>

                </div>
            </div>
        </div>


