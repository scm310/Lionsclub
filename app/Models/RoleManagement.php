<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleManagement extends Model
{
    use HasFactory;

    protected $table = 'role_managements';
    protected $fillable = ['role_name'];
}
