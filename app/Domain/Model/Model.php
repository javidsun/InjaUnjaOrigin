<?php

namespace App\Domain\Model;

use App\Domain\ModelEntityConvertable;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel implements ModelEntityConvertable
{

}
