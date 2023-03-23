<?php
    // This function verifies that an entry with param $id exists within the param $model
    function isValid($id, $model) {
        $model->id = $id;
        $result = $model->read_single();
        return $result;
    }