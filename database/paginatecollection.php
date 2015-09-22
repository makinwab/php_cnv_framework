<?php
	/**
	*
	*/
	class paginatecollection extends daocollection implements daocollectioninterface
	{

		public function __construct(dao $currentPaginate)
		{
			$this->currentPaginate = $currentPaginate;
		}

		public function getwithdata()
		{
			$connection = db_factory::factory(DB_TYPE);

			$sql = "SELECT * FROM PaginateDao";
			$results = $connection->getArray($sql);

			$this->populate($results, 'paginate');
		}

		public function getpaginateddata($position)
		{
			$connection = db_factory::factory(DB_TYPE);
			$sql = "SELECT id,name,message FROM PaginateDao ORDER BY id DESC LIMIT $position ,".ITEM_PER_PAGE;
			$results = $connection->getArray($sql);

			$this->populate($results, 'paginate');
		}

	}
?>
