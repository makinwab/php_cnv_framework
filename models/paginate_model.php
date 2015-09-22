<?php
	/**
	*
	*/
	class Paginate_Model extends PaginateDao
	{
		public function index()
		{
			$connection = db_factory::factory(DB_TYPE);
			$sql = "SELECT COUNT(*) as num FROM PaginateDao";

			$result = $connection->getArray($sql);

			$pages = ceil((int)$result[0]['num']/ITEM_PER_PAGE);

			return $pages;

		}

		public function fetch_pages($page_number)
		{
			//Using links pagination
			/*Get the current starting point of records;
			$postion = (int)$page_number * ITEM_PER_PAGE;*/

			//Limit our result within a specified rang
			$pagcoll = new paginatecollection(Session::get('user'));

			//Using scrolless pagination
			$pagcoll->getpaginateddata($page_number);

			return $pagcoll;
		}
	}
?>
