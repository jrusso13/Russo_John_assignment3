<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grantschool extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('school', '', TRUE);
        $this->load->model('site');
        $this->load->model('display_model');
        $this->load->model('update_model');
        $this->load->library('pagination');

    }


    public function add() {
        $config =array(
            'upload_path' => 'upload',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 500,
            'max_width' => 1920,
            'max_height' => 1080,
        );
        $this->load->library('upload', $config);

        $this->load->helper('form');
        $this->load->view('bootstrap/header');
        // Populate schools.
        $this->load->model('School');
        $schools = $this->School->get();
        $school_form_options = array();
        foreach ($schools as $id => $school) {
            $school_form_options[$id] = $school->school_name;
        }
        // Validation.
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
           array(
               'field' => 'school_id',
               'label' => 'School',
               'rules' => 'required',
           ),
           array(
               'field' => 'site_number',
               'label' => 'Site number',
           ),
           array(
               'field' => 'site_date_school',
               'label' => 'School date',
               'rules' => 'required|callback_date_validation',
           ),
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
        $check_file_upload = FALSE;
        IF (isset($_FILES['site_logo']['error']) && $_FILES['site_logo']['error'] != 4){
            $check_file_upload = TRUE;
        }
        if (!$this->form_validation->run()|| ($check_file_upload && !$this->upload->do_upload ('site_logo'))) {
            $this->load->view('grantschool_form', array(
                'school_form_options' => $school_form_options,
            ));
        }
        else {
            $this->load->model('Site');
            $site = new Site();
            $site->school_id = $this->input->post('school_id');
            $site->site_number = $this->input->post('site_number');
            $site->site_date_school = $this->input->post('site_date_school');
            $upload_data = $this->upload->data();
            if (isset($upload_data['file_name'])){
                $site->site_logo = $upload_data['file_name'];
            }
            $site->save();
            $this->load->view('grantschool_form_success', array(
                'site' => $site,
            ));
        }
    }

    public function date_validation($input) {
        $test_date = explode('-', $input);
        if (!@checkdate($test_date[1], $test_date[2], $test_date[0])) {
            $this->form_validation->set_message('date_validation', 'The %s field must be in YYYY-MM-DD format.');
            return FALSE;
        }
        return TRUE;
    }

    public function view($site_id){
        $this->load->helper('html');
        $this->load->view('bootstrap/header');
        $this->load->model(array('Site', 'School'));
        $site = new Site();
        $site->load($site_id);
        if (!$site->site_id){
            show_404();
        }
        $school = new School();
        $school->load($site->school_id);
        $this->load->view('grantschool', array(
            'site' => $site,
            'school' => $school
        ));
    }

    public function show_site_id() {
        $id = $this->uri->segment(3);
        $data['schooltypes'] = $this->update_model->show_sites();
        $data['school'] = $this->update_model->show_site_id($id);
        $this->load->view('bootstrap/header');
        $this->load->view('grantschool_form_edit', $data);
    }

    public function update_site_id1() {
        $id= $this->input->post('did');
        $data = array(
            'site_number' => $this->input->post('dname'),
            'site_date_school' => $this->input->post('ddate'),
            'fname' => $this->input->post('dfname'),
            'lname' => $this->input->post('dlname'),
            'email' => $this->input->post('demail'),
            'eid' => $this->input->post('deid'),
            'phone' => $this->input->post('dphone')
        );
        $this->update_model->update_site_id1($id,$data);
        redirect('/grantschool/');
    }

    public function delete($site_id) {
        $this->load->view('bootstrap/header');
        $this->load->model(array('Site'));
        $site = new Site();
        $site->load($site_id);
        if (!$site->site_id){
            show_404();
        }
        $site->delete();
        redirect('/grantschool/');
//        $this->load->view('grantschool_deleted', array(
//            'site_id' => $site_id,
//        ));
    }

    public function index($sort_by = 'site_id', $sort_order = 'asc',$offset = 0){

        $limit = 20;

        $data['fields'] = array(

            'site_id' => 'Site ID',
            'site_number' => 'School',
            'site_date_school' => 'Grant Approved',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'eid' => 'EID',
            'email' => 'Email',
            'phone' => 'Phone'
        );

        $this->load->model('display_model');

        $results = $this->display_model->search($limit, $offset, $sort_by, $sort_order);
        $data['grants'] = $results['rows'];
        $data['num_results'] = $results['num_rows'];

        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = site_url("grantschool/index/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('bootstrap/header');
        $this->load->view('sites', $data);
    }



}