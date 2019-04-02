<?php

namespace App;


class Department extends CustomModel
{

    public function changeDB($id)
    {
        $this->connection = $id;
    }
}
