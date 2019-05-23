<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->library("Nusoap_library"); //load the library here
//        $this->load->database();
//        $this->nusoap_server = new soap_server();
//        $this->nusoap_server->configureWSDL("MySoapServer", "urn:MySoapServer");
//        $this->nusoap_server->wsdl->schemaTargetNamespace = 'urn:MySoapServer';
//
//        //DATA TYPES
//        $this->nusoap_server->wsdl->addComplexType(
//                'Profile', 'complexType', 'struct', 'all', '', array(
//            'profile_id' => array('name' => 'profile_id', 'type' => 'xsd:integer'),
//            'person_name' => array('name' => 'person_name', 'type' => 'xsd:string'),
//            'person_contact' => array('name' => 'person_contact', 'type' => 'xsd:string'),
//            'person_email' => array('name' => 'person_email', 'type' => 'xsd:string')
//                )
//        );
//
//        $this->nusoap_server->wsdl->addComplexType(
//                "ProfileArray", "complexType", "array", "", "SOAP-ENC:Array", array(), array(
//            array("ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Profile[]")
//                ), "tns:Profile"
//        );
//        //REGISTRATION
//        $this->nusoap_server->register(
//                'getProfile', array('profile_id' => 'xsd:integer'), //parameters
//                array('return' => 'tns:Profile'), //output
//                'urn:MySoapServer', //namespace
//                'urn:MySoapServer#getProfile', //soapaction
//                'rpc', // style
//                'encoded', // use
//                'Get Profile Info by ID' //description
//        );
//
//        $this->nusoap_server->register(
//                'getAll', array(), //parameters
//                array('return' => 'tns:ProfileArray'), //output
//                'urn:MySoapServer', //namespace
//                'urn:MySoapServer#getCds', //soapaction
//                'rpc', // style
//                'encoded', // use
//                'Get all CDs' //description
//        );
//        //IMPLEMENTATION
//        function getProfile($id) {
//            $ci = & get_instance();
//            $ci->db->where('profile_id', $id);
//            $qcd = $ci->db->get('profile');
//            if ($qcd->num_rows() > 0) {
//                return $qcd->row_array();
//            } else {
//                return false;
//            }
//        }
//
//        function getAll() {
//            $ci = & get_instance();
//            $qcd = $ci->db->get('profile');
//            if ($qcd->num_rows() > 0) {
//                $ret_val = array();
//                $i = 0;
//                //echo "masuk hasil";
//                foreach ($qcd->result_array() as $row) {
//                    //var_dump($row);
//                    $ret_val[$i] = $row;
//                    $i++;
//                }
//                //var_dump($ret_val);
//                return $ret_val;
//            } else {
//                return false;
//            }
//        }        
        
    }

    public function index() {
        $data['title'] = 'Home';

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('home_page');
        $this->load->view('template/footer', $data);
//        $this->load->view('welcome_message');
    }

    public function addProfile() {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
//        $data = array(
//            'species_name' => $this->input->input_stream('species_name'),
//            'commission_rate' => $this->input->input_stream('commission_rate'),
//            'aaa' => $this->input->post('species_name')
//            
//        );
//        $this->form_validation->set_data($data);
//
//
        $this->form_validation->set_rules('person_name', 'Username', 'required');
//        $this->form_validation->set_rules(
//                'username', 'Username',
//                'required|min_length[5]|max_length[12]|is_unique[users.username]',
//                array(
//                        'required'      => 'You have not provided %s.',
//                        'is_unique'     => 'This %s already exists.'
//                )
//        );
//        $this->form_validation->set_rules('password', 'Password', 'required');
//        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
//        $this->form_validation->set_rules('person_email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('person_email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("msgType" => 2, "msg" => validation_errors('<span class="error-msg">', '</span>')));
            return;
        }


        $this->load->database();
        $data = array(
            'person_name' => $this->input->post('person_name'),
            'person_contact' => $this->input->post('person_contact'),
            'person_email' => $this->input->post('person_email')
        );

        $flag = $this->db->insert('profile', $data);

        if ($flag) {
            echo json_encode(array("msgType" => 1, "msg" => "Successfully Saved"));
        } else {
            echo json_encode(array("msgType" => 2, "msg" => "Cannot Save"));
            $error = $this->db->error();
            //set config/database db_debug=false
            //config log_threshold=1
            log_message('error', $error['message']);
        }
    }

    public function web_service() {
        $this->nusoap_server->service(file_get_contents("php://input")); //shows the standard info about service
    }

//    public function testClient() {
//        $wsdl = 'http://localhost/test/ci312/index.php/Home/web_service?wsdl';
//        $this->load->library("Nusoap_library"); //load the library here
//
//        $client = new nusoap_client($wsdl, 'wsdl');
//
//        $res1 = $client->call('getProfile', array('profile_id' => 1));
//        echo json_encode($res1);
//
//        $res2 = $client->call('getAll');
//        echo '<pre>';
//        echo json_encode($res2);
//        echo '</pre>';
//    }
//    public function testClient() {
//        $wsdl = 'http://220.247.238.176/EXAMONLINE/ECole.svc/ws?singleWsdl';
//
//        $client = new SoapClient($wsdl);
//
//        $res1 = $client->__soapCall('ConnectToWs', array());
//        echo json_encode($res1);
//    }
//    corect
//    public function GetMemberProfile() {
//        //set appropriate veriables
//        $wsdl = 'http://220.247.238.176/WebService/Smms.svc/ws?wsdl';
////		$endpoint = 'http://220.247.238.176/WebService/Smms.svc/soapService';
//        $signature = '0';
//
//        $verificationCode = '654da6b6b2f7e75d77a6396b2f9233e6:MTI0LjQzLjY0LjI0MjppbmRpa2FAcG9vcmFuZWUubGs6MTQ4OTc0Nzk3NA==';
//
//        //create soap client
//        $client = new SoapClient($wsdl);
//
//        //set input parameters
//        // $accounttype['ICASLAccountType'] = "Member";
//        $request['NumberOfDataSend'] = "1";
//        // $request['RequestOwnerAccountType']=  "Member";
//        $request['Signature'] = $signature;
//        $request['VerificationCode'] = $verificationCode;
//        $request['ICASLIdNo'] = '';
//        $request['MemberNo'] = '3881';
//        $request['NIC'] = '';
//        $request['TempNo'] = '';
//        $parms['wst'] = $request;
//
//        //echo "<pre>";
////		print_r( $parms);
//        //Call webservice and get the response
//        $request = $client->GetMemberProfile($parms);
////		$wsResult = $request->GetMemberProfileResult;
//
//        return $request;
//    }


  

}
