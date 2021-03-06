<?php
Class User extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}

	//kiểm tra callback username
	function check_email(){
		$email = $this->input->post('email');
		$where = array('email'=> $email);
		if($this->user_model->check_exits($where)){
			//trả về thông báo lỗi
			$this->form_validation->set_message(__FUNCTION__,'Email đã tồn tại !');
			return false;
		}
		else{
			return true;
		}
	}

	function register(){

		if($this->input->post()){
			$this->form_validation->set_rules('name','Họ tên','required|min_length[6]');
			$this->form_validation->set_rules('email','Địa chỉ email','required|valid_email|callback_check_email');
			$this->form_validation->set_rules('password','Mật khẩu','required|min_length[6]');
			$this->form_validation->set_rules('repassword','Nhập lại mật khẩu','matches[password]');
			if($this->form_validation->run()){
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$password = md5($password);
				$phone = $this->input->post('phone');
				$address = $this->input->post('address');
				$data = array(
					'name'=>$name,
					'email'=>$email,
					'password'=>$password,
					'phone'=>$phone,
					'address'=>$address,
					'created' =>now()
					);

			$this->user_model->create($data);
			redirect(base_url());
			}

		}
		$this->data['temp'] = "site/user/register";
		$this->load->view('site/layout',$this->data);
	}


	function check_login(){
		$user = $this->_get_userinfo();
		if($user){
			return true;
		}
		else{
			$this->form_validation->set_message(__FUNCTION__,'Đăng nhập thất bại !');
			return false;
		}
	}

	function login(){

		if($this->input->post()){
		$this->form_validation->set_rules('email','Địa chỉ email','required');
		$this->form_validation->set_rules('password','Mật khẩu','required');
		$this->form_validation->set_rules('login','Login','callback_check_login');
		if($this->form_validation->run()){

				//lấy ra thông tin thành viên
				$user = $this->_get_userinfo();
				$this->session->set_userdata('user_id_login', $user->id);
				redirect(base_url());
			}
		}

		$this->data['temp'] = "site/user/login";
		$this->load->view('site/layout',$this->data);
	}

	function logout(){
		if($this->session->userdata('user_id_login')){
				$this->session->unset_userdata('user_id_login');
				redirect(base_url());
			}
	}

	//lấy ra thông tin thành viên
	private function _get_userinfo(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$password = md5($password);
		$where = array('email'=>$email, 'password'=>$password);
		$user = $this->user_model->get_info_rule($where);
		return $user;
	}

	//hiển thị ra thông tin thành viên đăng nhập
	function index(){
		if(!$this->session->userdata('user_id_login')){
			redirect();
		}
		$user_id = $this->session->userdata('user_id_login');
		$user = $this->user_model->get_info($user_id);
		if(!$user){
			redirect();
		}
		$this->data['user'] = $user;
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;

		$this->data['temp'] = "site/user/index";
		$this->load->view('site/layout',$this->data);
	}

	function edit(){
		$user_id = $this->session->userdata('user_id_login');
		$user = $this->user_model->get_info($user_id);
		$this->data['user'] = $user;

		if($this->input->post()){
			$this->form_validation->set_rules('name','Tên thành viên','required');
			//$this->form_validation->set_rules('email','Địa chỉ email','required|valid_email|callback_check_email');
			// nếu nhập vào ô password thì validate
			if($password){
			$this->form_validation->set_rules('pasword','Mật khẩu','required|min_length[6]');
			$this->form_validation->set_rules('repassword','Nhập lại mật khẩu','required|matches[password]');
						}
			if($this->form_validation->run()){
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$phone = $this->input->post('phone');
				$address = $this->input->post('address');
				$data = array(
					'name'=>$name,
					'phone'=>$phone,
					'address'=>$address
					);
				if($password){
					$data['password'] = md5($password);
				}
			$this->user_model->update($user_id,$data);
			$this->session->set_flashdata('message', 'Sửa dữ liệu thành công !');
			redirect(base_url('user/index'));
			}
		}

		$this->data['temp'] = "site/user/edit";
		$this->load->view('site/layout',$this->data);

	}

}//end class