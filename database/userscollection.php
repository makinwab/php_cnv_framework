<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/4/13
 * Time: 12:57 PM
 * To change this template use File | Settings | File Templates.
 */

class userscollection extends daocollection implements daocollectioninterface
{
    public function __construct(dao $currentuser)
    {
        $this->currentuser = $currentuser;
    }

    public function getwithdata()
    {
        $connection = db_factory::factory(DB_TYPE);

        $sql = "select * from userdao order by username";
        $results = $connection->getArray($sql);

        $this->populate($results, 'user');
    }
}
