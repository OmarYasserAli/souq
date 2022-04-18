<?php
  
namespace App\Model;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Government;
class Country extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name', 'code'
    ];

    public function governments(){
        return $this->hasMany(Government::class);
    }
}