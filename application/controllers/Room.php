<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Room_model','model');
        $this->load->helper('url');    
        
        if (!$this->is_logged_in()) {
            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('room/list');
    }

    public function room_list(){

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rooms) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $rooms->room_no;
        $row[] = $rooms->rate;
        $row[] = $rooms->capacity;
        $row[] = $rooms->location;
        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/room/'.$rooms->room_image.'" class="img-responsive" height=60 width=80 /></a>';
          
        //add html for action
        $row[] = '<a data-id='.$rooms->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-eye"></i></a>
        <a href="room/edit/'.$rooms->id.'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        <a data-toggle="modal" data-id='.$rooms->id.' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';
        $data[] = $row;
        }
        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
   
   
     

    public function create() {

        $this->form_validation->set_rules('room_no', 'Room no', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_type', 'Room type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rate', 'Rate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('extra_bed_rate', 'Extra Bed Rate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('capacity', 'Capacity', 'trim|required|xss_clean');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('facility[]', 'Facility', 'trim|required|xss_clean');

        if (empty($_FILES['upl_files']['name'][0])){

            $this->form_validation->set_rules('upl_files[]', 'Image', 'required');
        }


        if ($this->form_validation->run() == FALSE) {

            $data['room_type'] = $this->model->getRoomTypeData();

            $data['facility'] = $this->model->getRoomFacilityData();

            $this->load->view('room/add',$data);

        } else {

            if (!is_dir('uploads/room'))
            {
                mkdir('uploads/room/', 0755, TRUE);
            }

            if($_FILES['upl_files']['name'])
            {

                $number_of_files_uploaded = count($_FILES['upl_files']['name']);

                for ($i = 0; $i < $number_of_files_uploaded; $i++) :

                    $_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
                    $_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
                    $_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
                    $_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
                    $config = array(
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size'      => 3000,
                    'overwrite'     => FALSE,
                    'upload_path'   => 'uploads/room/',
                    'encrypt_name'  => TRUE,
                    'remove_spaces' =>  TRUE,
                    );
                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload()) :
                    $error = array('error' => $this->upload->display_errors());
                    else :
                    $data = $this->upload->data();
                    // Continue processing the uploaded data
                    $multi_images[] = $data['file_name'];

                    $this->load->library('upload', $config);

                    $file_name = $data['file_name'];  
                    $params['gambar'] = $file_name;
                    $this->load->library('image_lib');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'uploads/room/'.$file_name;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']     = 400;
                    $config['height']   = 400;
                    $config['new_image']        = 'uploads/room/' .$file_name;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    endif;
                endfor;
            }
            else{

                $multi_images[] = "";

            }

            $room_no = $this->input->post('room_no');
            $room_type = $this->input->post('room_type');
            $rate = $this->input->post('rate');
            $extra_bed_rate = $this->input->post('extra_bed_rate');
            $capacity = $this->input->post('capacity');
            $location = $this->input->post('location');
            $facility = $this->input->post('facility');

            $value = array('room_no' => $room_no,'room_type_id' => $room_type,'rate' => $rate, 'extra_bed_rate' => $extra_bed_rate,'capacity'=>$capacity,'location'=>$location);

            $this->model->insertRoomData($value,$multi_images,$facility);
            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('room');
        }
    }

    public function view() {

        $id = $this->input->post('rowid');
        $data['rooms'] = $this->model->viewData($id);
        $data['images'] = $this->model->viewImageData($id);
        $data['facility'] = $this->model->viewFacilityData($id);
        $this->load->view('room/view', $data);
    }

    public function edit($id) {
        $data['rooms'] = $this->model->viewData($id);
        $data['image'] = $this->model->viewImageData($id);
        $data['selected_facility'] = $this->model->viewFacilityData($id);
        $data['facility'] = $this->model->getRoomFacilityData();
        $data['room_type'] = $this->model->getRoomTypeData();
        $this->load->view('room/edit', $data);
    }

    public function update() {

        if (isset($_POST['submit'])) {

            $id = $this->input->post('id');

            if($_FILES['upl_files']['name'][0])
            {

                $number_of_files_uploaded = count($_FILES['upl_files']['name']);

                for ($i = 0; $i < $number_of_files_uploaded; $i++) :

                    $_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
                    $_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
                    $_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
                    $_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
                    $config = array(
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size'      => 3000,
                    'overwrite'     => FALSE,
                    'upload_path'   => 'uploads/room/',
                    'encrypt_name'  => TRUE,
                    'remove_spaces' =>  TRUE,
                    );
                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload()) :
                    $error = array('error' => $this->upload->display_errors());
                    else :
                    $data = $this->upload->data();
                    // Continue processing the uploaded data
                    $multi_images[] = $data['file_name'];

                    $this->load->library('upload', $config);

                    $file_name = $data['file_name'];  
                    $params['gambar'] = $file_name;
                    $this->load->library('image_lib');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'uploads/room/'.$file_name;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']     = 400;
                    $config['height']   = 400;
                    $config['new_image']        = 'uploads/room/' .$file_name;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    endif;
                endfor;
            }
            else{

                $multi_images[] = "";

            }

            $room_no = $this->input->post('room_no');
            $room_type_id = $this->input->post('room_type_id');
            $rate = $this->input->post('rate');
            $extra_bed_rate = $this->input->post('extra_bed_rate');
            $capacity = $this->input->post('capacity');
            $location = $this->input->post('location');

            $facility = $this->input->post('facility');

            $value = array('room_no' => $room_no,'room_type_id' => $room_type_id,'rate' => $rate, 'extra_bed_rate' => $extra_bed_rate,'capacity'=>$capacity,'location'=>$location);

            $this->model->updateRoomsData($id,$value,$multi_images,$facility);
            $this->session->set_flashdata('update', 'Updated Successfully');
            redirect('room');
        }
    }

    public function delete() {
        $this->load->view('room/delete');
        if (isset($_POST['delete'])) {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $this->model->delete($id,$name);
            $this->session->set_flashdata('delete', 'Deleted Successfully');
            redirect('room');
        }
    }

    public function deleteImage(){

        $id=$_POST['rowid'];
        $this->model->deleteImage($id);
    }

    public function deleteFacility(){
       
        $id=$_POST['rowid'];

        $this->model->deleteFacilityList($id);
    }

}
