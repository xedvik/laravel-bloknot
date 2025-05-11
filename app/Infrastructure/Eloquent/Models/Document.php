<?php
namespace App\Infrastructure\Eloquent\Models;
use Illuminate\Database\Eloquent\Model;

class  Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['title','content','user_id'];

    public function versions(){
        return $this->hasMany(DocumentVersion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

