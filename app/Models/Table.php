<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Validator;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_number', 'capacity', 'status', 'cafe_id'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($table) {
            $rules = [
                'table_number' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) use ($table) {
                        $exists = static::where('table_number', $value)
                            ->where('cafe_id', $table->cafe_id)
                            ->where('id', '!=', $table->id)
                            ->exists();
                        if ($exists) {
                            $fail('The table number has already been taken for this cafe.');
                        }
                    },
                ],
                'capacity' => 'required|integer',
                'status' => 'required|in:available,reserved',
                'cafe_id' => 'required|exists:cafes,id',
            ];

            $validator = Validator::make($table->attributesToArray(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }
}

