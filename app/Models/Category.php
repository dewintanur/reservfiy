<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // Ensure this is correct or it's okay to omit if naming conventions are followed

    protected $fillable = ['name'];

    public function cafes()
    {
        return $this->belongsToMany(Cafe::class, 'cafe_category');
    }

}
