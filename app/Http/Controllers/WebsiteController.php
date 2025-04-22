<?php

namespace App\Http\Controllers;

use App\Models\AdImage1;
use App\Models\AdImage2;
use App\Models\Image2;
use App\Models\Image3;
use App\Models\RegionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\AdImages1;
use App\Models\Banner1000;
use App\Models\Banner10000;
use App\Models\Banner5000;
use App\Models\Image1;
use Illuminate\Support\Facades\View;
use App\Models\BottomBanner;
use App\Models\CareerEnquiry;
use App\Models\Donation;
use App\Models\MemberDetail;
use App\Models\MembershipEnquiry;
use App\Models\PastEvent;
use Carbon\Carbon;

use App\Models\BannerClick;


class WebsiteController extends Controller
{


    public function index()
    {
        $images1 = AdImage1::all(); // Fetch images from AdImage1 table
        $images2 = AdImage2::all(); // Fetch images from AdImage2 table
        $image1s = Image1::all(); // Fetch images from image1s table
        $image2s = Image2::all(); // Fetch images from image2s table
        $image3s = Image3::all();



        $startDate = Carbon::today();                     // Start from today (ignores current time)
        $endDate = Carbon::now()->addMonth();             // One month from today

        $events = Event::whereBetween('event_date', [$startDate, $endDate])
            ->orderBy('event_date', 'asc')
            ->get();

        $bottomBanners = BottomBanner::select('image', 'website_link')->get(); // Fetch image and link

        $members = MemberDetail::all(); // Fetch all members from the database

        return view('website.index', compact('images1', 'images2', 'image1s', 'image2s', 'image3s','events','bottomBanners','members'));
    }


    public function getAdBanners()
    {
        // Fetch the latest image from banner_10000
        $topBanner = DB::table('banner_10000')->latest()->value('image_path');

        // Convert the image path for public access (if necessary)
        $topBannerUrl = $topBanner ? asset('storage/app/public/' . basename($topBanner)) : null;

        return view('includes.banner', compact('topBannerUrl'));
    }


   public function dgteam()
    {
        $dgTeamMembers_current = DB::table('dg_team')
        ->join('add_members', 'dg_team.member_id', '=', 'add_members.id')
        ->where('dg_team.year', 'CurrentYear')
        ->whereIn('dg_team.position', [
            'District Governor',
            'Past District Governor',
            '1st Vice Governor',
            '2nd Vice Governor',
            'Cabinet Secretary',
            'Cabinet Treasurer'
        ])
        ->select(
            'dg_team.year',
            'dg_team.position',
            'add_members.first_name',
            'add_members.last_name',
            'add_members.profile_photo',
            'add_members.phone_number',
            'add_members.email_address',
            'add_members.member_id',
            'dg_team.updated_at'
        )
        ->orderByRaw("FIELD(dg_team.position, 'District Governor', 'Past District Governor', '1st Vice Governor', '2nd Vice Governor', 'Cabinet Secretary', 'Cabinet Treasurer')")
        ->orderBy('dg_team.updated_at', 'desc')
        ->get()
        ->unique('position') // Keep only the latest updated row for each position
    ->values();

        $dgTeamMembers_upcoming = DB::table('dg_team')
        ->join('add_members', 'dg_team.member_id', '=', 'add_members.id')
        ->where('dg_team.year', 'UpCommingYear')
        ->whereIn('dg_team.position', [
            'District Governor',
            'Past District Governor',
            '1st Vice Governor',
            '2nd Vice Governor',
            'Cabinet Secretary',
            'Cabinet Treasurer'
        ])
        ->select(
            'dg_team.year',
            'dg_team.position',
            'add_members.first_name',
            'add_members.last_name',
            'add_members.profile_photo',
            'add_members.phone_number',
            'add_members.email_address',
            'add_members.member_id',
            'dg_team.updated_at'
        )
        ->orderByRaw("FIELD(dg_team.position, 'District Governor', 'Past District Governor', '1st Vice Governor', '2nd Vice Governor', 'Cabinet Secretary', 'Cabinet Treasurer')")
        ->orderBy('dg_team.updated_at', 'desc')
        ->get()
        ->unique('position')
    ->values();




        return view('member.teamdg', compact('dgTeamMembers_current','dgTeamMembers_upcoming'));
    }




    public function intofficer()
    {
        $internationalOfficers = DB::table('internationalofficers')
            ->join('add_members', 'internationalofficers.member_id', '=', 'add_members.id')
            ->select(
                'internationalofficers.position',
                'internationalofficers.year',
                'add_members.first_name',
                'add_members.last_name',
                'add_members.profile_photo',
                'add_members.member_id',
                'add_members.phone_number',
                'add_members.email_address'
            )
            ->get();

        return view('member.internationalofficer', compact('internationalOfficers'));
    }



    public function pastdistrictgovernor()
    {
        $pastGovernors = DB::table('past_governors')
            ->join('add_members', 'past_governors.member_id', '=', 'add_members.id')
            ->select(
                'past_governors.position',
                'past_governors.year',
                'add_members.first_name',
                'add_members.last_name',
                'add_members.profile_photo',
                'add_members.member_id',
                'add_members.phone_number',
                 'add_members.email_address'
            )
            ->get();

        return view('member.pastdistrictgovernors', compact('pastGovernors'));
    }




    public function districtchairperson()
    {
        $districtChairpersons = DB::table('district_chairpersons')
            ->join('add_members', 'district_chairpersons.member_id', '=', 'add_members.id')
            ->select(
                'district_chairpersons.position',
                'district_chairpersons.year',
                'add_members.first_name',
                'add_members.last_name',
                'add_members.phone_number',
                'add_members.email_address',
                'add_members.profile_photo',
                'add_members.member_id'
            )
            ->get();

        return view('member.districtchairperson', compact('districtChairpersons'));
    }





    public function regionmember()
    {
        $regions = [
            'Region 1' => DB::table('region_members')
                ->join('add_members', 'region_members.member_id', '=', 'add_members.id')
                ->where('region_members.region', 'Region 1')
                ->select(
                    'region_members.position',
                    'region_members.year',
                    'add_members.first_name',
                    'add_members.last_name',
                    'add_members.phone_number',
                    'add_members.email_address',
                    'add_members.profile_photo',
                    'add_members.member_id'
                )
                ->get(),

            'Region 2' => DB::table('region_members')
                ->join('add_members', 'region_members.member_id', '=', 'add_members.id')
                ->where('region_members.region', 'Region 2')
                ->select(
                    'region_members.position',
                    'region_members.year',
                    'add_members.first_name',
                    'add_members.last_name',
                    'add_members.phone_number',
                    'add_members.email_address',
                    'add_members.profile_photo',
                    'add_members.member_id'
                )
                ->get(),

            'Region 3' => DB::table('region_members')
                ->join('add_members', 'region_members.member_id', '=', 'add_members.id')
                ->where('region_members.region', 'Region 3')
                ->select(
                    'region_members.position',
                    'region_members.year',
                    'add_members.first_name',
                    'add_members.last_name',
                    'add_members.phone_number',
                    'add_members.email_address',
                    'add_members.profile_photo',
                    'add_members.member_id'
                )
                ->get(),

            'Region 4' => DB::table('region_members')
                ->join('add_members', 'region_members.member_id', '=', 'add_members.id')
                ->where('region_members.region', 'Region 4')
                ->select(
                    'region_members.position',
                    'region_members.year',
                    'add_members.first_name',
                    'add_members.last_name',
                    'add_members.phone_number',
                    'add_members.email_address',
                    'add_members.profile_photo',
                    'add_members.member_id'
                )
                ->get(),
        ];

        return view('member.regionmember', compact('regions'));
    }




    public function chapter()
    {
        // Fetch all chapters
        $chapters = DB::table('chapters')->select('id', 'chapter_name')->get();

        // Fetch members with their positions and chapter details
        $members = DB::table('club_positions')
            ->join('add_members', 'club_positions.member_id', '=', 'add_members.id')
            ->select(
                'club_positions.position',
                'add_members.id as member_id',
                'add_members.first_name',
                'add_members.last_name',
                'add_members.phone_number',
                'add_members.email_address',
                'add_members.profile_photo',
                'add_members.member_id',
                'add_members.account_name' // This stores the chapter_id
            )
            ->get();

        return view('member.chapter', compact('chapters', 'members'));
    }

    public function webevents(Request $request)
    {
        $currentDate = Carbon::today();

        $completedEvents = Event::where('event_date', '<', $currentDate)
            ->orderBy('event_date', 'asc')
            ->with('pastEvents') // Load past event details correctly
            ->get()
            ->map(function ($event) {
                $pastEvent = $event->pastEvents->first(); // Get the first past event record if available
                $event->venue = $pastEvent->venue ?? 'N/A';
                $event->details = $pastEvent->details ?? 'N/A';
                $event->images = $pastEvent->images ?? [];
                return $event;
            });

        $upcomingEvents = Event::where('event_date', '>=', $currentDate)
            ->orderBy('event_date', 'asc')
            ->get();

        // Get the 'tab' parameter from the request, default to 'tab2' (Upcoming Events)
        $activeTab = $request->query('tab', 'tab2');

        return view('member.webevents', compact('completedEvents', 'upcomingEvents', 'activeTab'));
    }

    public function gallery()
    {
        $completedEvents = PastEvent::with('event')->get();

        foreach ($completedEvents as $event) {
            $event->event_date = optional($event->event)->event_date; // Fetching event_date from related events table
        }

        return view('member.gallery', compact('completedEvents'));
    }





    public function show($id)
{
    $event = PastEvent::findOrFail($id);

    // Decode images if stored as JSON
    if (!is_array($event->images)) {
        $event->images = json_decode($event->images, true);
    }

    return view('member.gallery_detail', compact('event'));
}




// Show Contact Page
public function contact()
{
    return view('member.contact');
}

public function membershipForm()
{
    return view('member.contactpartials.membership');
}

public function donationForm()
{
    return view('member.contactpartials.donation');
}

    // Handle Membership Enquiry Form Submission
    public function submitMembershipEnquiry(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required_if:preferred_contact,email|email|nullable',
            'phone' => 'required_if:preferred_contact,phone|string|max:15|nullable',
            'preferred_contact' => 'required|in:phone,email', // Changed from preferred_contact_method
            'preferred_time' => 'required|in:daytime,evening,either',
            'comment' => 'nullable|string',
        ]);

        // Save data to the database
        MembershipEnquiry::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'preferred_contact_method' => $request->preferred_contact, // Store as preferred_contact_method
            'preferred_time' => $request->preferred_time,
            'comment' => $request->comment,
        ]);

        return redirect()->route('membership.enquiry')->with('success', 'Membership enquiry submitted successfully!');
    }


  // Handle Donation Form Submission
  public function submitDonation(Request $request)
  {

      // Validate the request data
      $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|email',
          'phone' => 'required|string|max:15', // Assuming phone number is max 15 characters
          'location' => 'required|string|max:255', // Assuming location is a string with max 255 characters

          'message' => 'nullable|string',
      ]);

      // Save the donation data into the database
      Donation::create([
          'name' => $request->name,
          'email' => $request->email,
          'phone' => $request->phone,
          'location' => $request->location,

          'message' => $request->message,
      ]);

      // Redirect back with a success message
      return redirect()->route('donation.form')->with('success', 'Thank you for your donation!');
  }



 public function showCareerEnquiryForm() {

    $enquiries = CareerEnquiry::all();  // You can also use ->latest() to order by the latest entry
    return view('member.careerenquiry',compact('enquiries'));
}
public function submitCareerEnquiry(Request $request) {
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'position' => 'required|string',
        'experience' => 'nullable|string',
        'motivation' => 'required|string',
        'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'source' => 'nullable|string',
    ]);

    $resumePath = null;
    if ($request->hasFile('resume')) {
        $resumePath = $request->file('resume')->store('resumes', 'public');
    }

    CareerEnquiry::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'position' => $request->position,
        'experience' => $request->experience,
        'motivation' => $request->motivation,
        'resume' => $resumePath,
        'source' => $request->source,
    ]);

    return redirect()->back()->with('success', 'Your enquiry has been submitted successfully.');
}



public function trackBannerClick(Request $request)
{
    // Always fetch via query string
    $type = $request->query('type', 'popup');
    $url = $request->query('url');
    $image = $request->query('image');

    // Log all received values
    \Log::info('Track Click (popup)', compact('type', 'url', 'image'));

    if (empty($url) || empty($image)) {
        \Log::error('Missing tracking params', compact('url', 'image'));
        return abort(400, 'Missing URL or Image');
    }

    try {
        $click = BannerClick::firstOrCreate(
            [
                'banner_type' => $type,
                'image_path' => $image,
                'redirect_url' => $url,
            ],
            ['click_count' => 0]
        );

        $click->increment('click_count');

        \Log::info('Click recorded', ['id' => $click->id, 'count' => $click->click_count]);
    } catch (\Exception $e) {
        \Log::error('Failed to record click', ['error' => $e->getMessage()]);
    }

    return redirect()->away($url);
}


}
