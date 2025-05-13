<?php
namespace App\Infrastructure\Eloquent\Models;

use App\Infrastructure\Eloquent\Factories\DocumentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = ['title','content','user_id'];
    protected $casts = [
        'user_id' => 'integer',
    ];

    public function versions(){
        return $this->hasMany(DocumentVersion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function newFactory(): DocumentFactory
    {
        return DocumentFactory::new();
    }
}

