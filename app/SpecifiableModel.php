<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecifiableModel extends Model
{
    protected bool $specifiable = true;

    abstract protected function specifics();

}
