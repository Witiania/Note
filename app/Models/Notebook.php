<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $full_name
 * @property string $company_name
 * @property string $phone
 * @property string $email
 * @property string $birthday
 * @property string $photo_url
 * @property string $created_at
 * @property string $updated_at
 */
class Notebook extends Model {
    use HasFactory;

    protected $table = 'notebooks';

    protected $fillable = [
        'full_name',
        'company_name',
        'phone',
        'email',
        'birthday',
        'photo_url',
    ];
}
