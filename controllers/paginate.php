<?php
	class paginate extends Controller{

		public function __construct()
		{
			parent::__construct();
			Auth::handleLogin();
		}

		public function index()
		{
			$this->template->template_file = 'paginate/index';

			/* Using scrolless pagination */
			$total_group = $this->model->index();

			$pag = new Pagination();
			$p = $pag->useScrolless($total_group, URL.'paginate/fetch_pages');

        	$this->template->entries[] = (object)[
        	'pagination' => $p, 'jquery' => URL."public/js/jquery.min.js", 'custom' => URL."public/js/custom.js",
        	'image' => URL."public/images/ajax-loader.gif",'back' => URL."user", 'logout' => LOGOUT
        	];

			$markup = $this->template->generate_markup();

			echo $this->view->render($markup);
		}

		public function fetch_pages()
		{
			$this->template->template_file = 'paginate/fetch_pages';

			//Using scrolless pagination

	        if($_POST)
	        {
	            //sanitize post value
	            $group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

	            //throw HTTP error if group number is not valid
	            if(!is_numeric($group_number)){
	                header('HTTP/1.1 500 Invalid number!');
	                exit();
	            }

	            //get current starting point of records
	            $position = ($group_number * ITEM_PER_PAGE);

	            $result= $this->model->fetch_pages($position);
	            foreach ($result as $key => $value) {

					$this->template->entries[] = (object)['id' => $value->id, 'name' => $value->name, 'message' => $value->message];

				}
				unset($result);
	            $markup = $this->template->generate_markup();

				echo $this->view->render($markup);

	        }
		}
	}
?>
