<?php
  
namespace App\Model;

use App\Model\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Government extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name', 'country_id'
    ];
    public function country(){
        return $this->belongsTo(Country::class);
    }
}