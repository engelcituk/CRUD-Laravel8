<?php

namespace App\Repositories;

interface RepositoryInterface {

    public function paginated();
    public function created();
    public function update(int $id);
    public function delete(int $id);
    public function find(int $id);

}