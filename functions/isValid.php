<?php
    function isValid($id, $model) {
        $model->id = $id;
        $result = $model->read_single();
        return $result;
    }