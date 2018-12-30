<?php

namespace App\Repositories;

interface BaseInterface{

    function getAll();

    function getById($id);

    function create(array $attributes);

    function update(array $attributes);

    function delete($id);

}
