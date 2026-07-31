<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['first_name', 'last_name', 'dni', 'age'];

    // Un paciente puede tener muchos estudios
    public function studies()
    {
        return $this->hasMany(Study::class);
    }
}
