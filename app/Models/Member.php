<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Member extends Authenticatable
    {
        use HasFactory;

        protected $table = 'add_members'; // Define the table name

        protected $fillable = [
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
            'phone_number', // Mobile Number
            'work_number', // Work Number
            'home_number', // Home Number
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
            return 'member_id'; // 💡 Tell Laravel to use 'member_id' instead of 'email'
        }
        public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'membership_full_type', 'id');
    }


    // Relationship with ParentsMultipleDistrict
    public function parentMultipleDistrict()
    {
        return $this->belongsTo(ParentsMultipleDistrict::class, 'parent_multiple_district', 'id');
    }


    // Relationship with District
    public function parentDistrict()
    {
        return $this->belongsTo(District::class, 'parent_district', 'id');
    }

    // Relationship with Chapter (for Account Name)
    public function account()
    {
        return $this->belongsTo(Chapter::class, 'account_name', 'id');
    }

    }
    