<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $table = 'add_members';

    protected $fillable = [
        'id',
        'parent_multiple_district',
        'parent_district',
        'account_name',
        'member_id',
        'salutation',
        'first_name',
        'last_name',
        'suffix',
        'spouse_name',
        'dob',
        'anniversary_date',
        'mailing_address_line_1',
        'mailing_address_line_2',
        'mailing_address_line_3',
        'mailing_city',
        'mailing_state',
        'mailing_country',
        'mailing_zip',
        'preferred_email',
        'email_address',
        'work_email',
        'alternate_email',
        'preferred_phone',
        'phone_number',
        'work_number',
        'home_number',
        'fax',
        'membership_full_type',
        'membership_type',
        'profile_photo',
        'password',
    ];

    protected $casts = [
        'anniversary_date' => 'date',
    ];

    public function getAuthIdentifierName()
    {
        return 'member_id';
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'membership_full_type', 'id');
    }

    public function parentMultipleDistrict()
    {
        return $this->belongsTo(ParentsMultipleDistrict::class, 'parent_multiple_district', 'id');
    }

    public function parentDistrict()
    {
        return $this->belongsTo(District::class, 'parent_district', 'id');
    }




    public function team()
    {
        return $this->hasOne(\App\Models\DGTeam::class, 'member_id', 'id');
    }

    public function regionMembers()
    {
        return $this->hasMany(RegionMember::class, 'member_id');
    }

    public function account()
    {
        return $this->belongsTo(Chapter::class, 'account_name', 'id');
    }

    public function client()
    {
        return $this->hasMany(Client::class, 'member_id'); // Adjust based on your actual relationship
    }

    public function testimonial()
    {
        return $this->hasMany(Testimonial::class, 'member_id'); // Adjust based on your actual relationship
    }

    public function project()
    {
        return $this->hasMany(Project::class, 'member_id'); // Adjust based on your actual relationship
    }
    public function service()
    {
        return $this->hasMany(Service::class, 'member_id'); // Adjust based on your actual relationship
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'member_id'); // Adjust based on your actual relationship
    }

    public function company()
    {
        return $this->hasMany(Company::class, 'member_id'); // Adjust based on your actual relationship
    }
}
