<?php

namespace Wave;

use Illuminate\Database\Eloquent\Model;


class Document extends Model
{
    protected $fillable = [
      'user_id',
      'filename',
      'original_name',
      'file_path',
      ];
}
