<?php

use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\ClubPositionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDirectoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerUploadController;
use App\Http\Controllers\AddChapterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\InternationalOfficerController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\AssignMemberController;
use App\Http\Controllers\MembershipAwardController;
use App\Http\Controllers\AssignImportController;
use App\Http\Controllers\MemberLoginController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\MemberLoungeController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\AdminMemberLoungeController;
use App\Http\Controllers\Admin\ApproveController;
use App\Http\Controllers\Admin\VisitorStatsController;
use App\Http\Controllers\CareerEnquiryController;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


//WebsiteController

Route::get('/index', [WebsiteController::class, 'index'])->name('index');

Route::get('/', [WebsiteController::class, 'showLandingPage'])->name('website.landingpage');

Route::get('/', [WebsiteController::class, 'showLandingPage'])->name('website.landingpage');
Route::get('/get-banners', [WebsiteController::class, 'getAdBanners'])->name('get.banners');
Route::get('/teamdg', [WebsiteController::class, 'dgteam'])->name('dgteam');
Route::get('/international_officers', [WebsiteController::class, 'intofficer'])->name('international_officers');

Route::get('/districtgovernor', [WebsiteController::class, 'districtgovernor'])->name('districtgovernor');
Route::get('/pastdistrictgovernor', [WebsiteController::class, 'pastdistrictgovernor'])->name('pastdistrictgovernor');
Route::get('/districtchairperson', [WebsiteController::class, 'districtchairperson'])->name('districtchairperson');
Route::get('/regionmember', [WebsiteController::class, 'regionmember'])->name('regionmember');
Route::get('/chapter', [WebsiteController::class, 'chapter'])->name('chapter');
Route::get('/career-enquiry', [WebsiteController::class, 'showCareerEnquiryForm'])->name('careerenquiry.form');
Route::post('/career-enquiry/submit', [WebsiteController::class, 'submitCareerEnquiry'])->name('careerenquiry.submit');
//banner clicks
Route::get('/track-click', [WebsiteController::class, 'trackBannerClick'])->name('track.banner.click');
//website visitors
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
    Route::get('/visitors', [VisitorStatsController::class, 'index'])->name('admin.visitors');
});
Route::get('/admin/visitor-export/csv', function () {
    $filename = 'visitors_' . now()->format('Ymd_His') . '.csv';
    $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename"];

    $callback = function () {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['IP', 'Country', 'Region', 'City', 'URL', 'Visited At']);

        foreach (App\Models\Visitor::all() as $visitor) {
            fputcsv($handle, [
                $visitor->ip_address,
                $visitor->country,
                $visitor->region,
                $visitor->city,
                $visitor->url,
                $visitor->created_at,
            ]);
        }
        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
})->middleware('admin.auth')->name('admin.visitors.export.csv');


//AdminAuthController
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


//AdminController
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
Route::post('/admin/store-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');
Route::post('/admin/storeRole', [AdminController::class, 'storeRole'])->name('admin.storeRole');
Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');


Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.registerForm');
Route::post('/admin/register', [AdminController::class, 'storeAdmin'])->name('admin.store');

// Admin banner click stats
Route::middleware('admin.auth')->group(function () {
    Route::get('/banner-clicks', [AdminController::class, 'viewBannerClicks'])->name('admin.banner.clicks');
    Route::get('/banner-clicks/export', [AdminController::class, 'exportBannerClicks'])->name('admin.banner.clicks.export');
});


Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/membership-enquiry', [WebsiteController::class, 'membershipForm'])->name('membership.form');
Route::post('/membership-enquiry', [WebsiteController::class, 'submitMembershipEnquiry'])->name('membership.enquiry');

Route::get('/donation', [WebsiteController::class, 'donationForm'])->name('donation.form');
Route::post('/donation', [WebsiteController::class, 'submitDonation'])->name('donation.submit');




// BannerUploadController
Route::get('/admin/banner-upload', [BannerUploadController::class, 'index'])->name('banner.upload.view');
Route::post('/upload-banner', [BannerUploadController::class, 'store'])->name('upload.banner');
Route::post('/upload-ad', [BannerUploadController::class, 'uploadAd'])->name('upload.ad');
Route::post('/upload/image1', [BannerUploadController::class, 'storeImage1'])->name('upload.image1');
Route::post('/upload/image2', [BannerUploadController::class, 'storeImage2'])->name('upload.image2');
Route::post('/upload/image3', [BannerUploadController::class, 'storeImage3'])->name('upload.image3');
//banner edit update delete
Route::get('/banner/{id}/edit', [BannerUploadController::class, 'edit'])->name('banner.edit');
Route::post('/banner/update/{id}', [BannerUploadController::class, 'update'])->name('banner.update');
Route::delete('/banner/delete/{id}', [BannerUploadController::class, 'destroy'])->name('banner.delete');
//bannenr name update
Route::post('/upload/name', [BannerUploadController::class, 'bannerupdate'])->name('bannername');
//banner end


Route::get('/banner-slider', [BannerUploadController::class, 'getBannerImages']);


//banner end

Route::get('/member-directory', [MemberDirectoryController::class, 'index'])->name('member.directory');
Route::get('get-governors/{districtId}', [MemberDirectoryController::class, 'getGovernorsByDistrict']);




//DistrictController
Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
Route::post('/districts', [DistrictController::class, 'store'])->name('districts.store');
Route::delete('/districts/{id}', [DistrictController::class, 'destroy'])->name('districts.destroy');


//AddChapterController
Route::get('/add-chapter', [AddChapterController::class, 'index'])->name('chapter.index');
Route::post('/add-chapter/store', [AddChapterController::class, 'store'])->name('chapter.store');




//InternationalOfficerController
Route::get('/international-officers', [InternationalOfficerController::class, 'index'])->name('international.officers.index');
Route::post('/international-officers', [InternationalOfficerController::class, 'store'])->name('international.officers.store');
Route::delete('/international-officers/{id}', [InternationalOfficerController::class, 'destroy'])->name('international.officers.destroy');

Route::post('/international-officers/store-governor', [InternationalOfficerController::class, 'storeGovernor'])
    ->name('international.officers.storeGovernor');
    
Route::get('/district-chairperson/form', [InternationalOfficerController::class, 'showDistrictChairpersonForm'])->name('districtchairperson.form');
Route::post('/district-chairperson/store', [InternationalOfficerController::class, 'addDistrictChairperson'])->name('districtchairperson.store');


Route::get('/regionmembers/add', [InternationalOfficerController::class, 'addRegionMember'])->name('regionmembers.add');
Route::post('/regionmembers/store', [InternationalOfficerController::class, 'storeRegionMember'])->name('regionmembers.store');

Route::prefix('international-officers')->group(function () {
    Route::get('/past-district-governors', [InternationalOfficerController::class, 'createPastDistrictGovernor'])->name('pastdistrictgovernors.create');
    Route::post('/past-district-governors/store', [InternationalOfficerController::class, 'storePastDistrictGovernor'])->name('pastdistrictgovernors.store');
});


    Route::post('/dg-team/store', [InternationalOfficerController::class, 'storeDgTeam'])->name('dg.team.store');
    Route::get('/add-chapter-member', [InternationalOfficerController::class, 'showAddChapterMemberForm'])->name('showAddChapterMemberForm');
Route::post('/add-chapter-member', [InternationalOfficerController::class, 'addChapterMember'])->name('addChapterMember');



//TeamController
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

Route::post('/team/store', [TeamController::class, 'store'])->name('team.store');

Route::get('/award', [AwardController::class, 'index'])->name('award.index');





//ADD Member controller(admin)

Route::get('/members/list', [MemberController::class, 'index'])->name('members.list');


Route::get('/admin/add-members', [MemberController::class, 'create'])->name('members.add'); // Show form
Route::post('/admin/add-members', [MemberController::class, 'store'])->name('members.store'); // Handle form submission
Route::get('/get-districts', [MemberController::class, 'getDistricts'])->name('get.districts');

Route::get('/members/check-member-id', [MemberController::class, 'checkMemberId'])->name('members.checkMemberId');


Route::get('/members/edit/{id}', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/update/{id}', [MemberController::class, 'update'])->name('members.update');

Route::delete('/members/delete/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
Route::get('/members/{id}', [MemberController::class, 'getMemberDetails']);

Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
Route::post('/settings/store', [SettingsController::class, 'store'])->name('admin.settings.store');
Route::post('/settings', [SettingsController::class, 'storedistrict'])->name('admin.settings.storedistrict');

// Route to store Account Names
Route::post('/settings/store-account-names', [SettingsController::class, 'storeAccountNames'])->name('admin.settings.storeAccountNames');

// Route to store Membership Types
Route::post('/settings/store-membership-types', [SettingsController::class, 'storeMembershipTypes'])->name('admin.settings.storeMembershipTypes');

Route::get('/birthdays-anniversary', [BirthdayController::class, 'index'])->name('admin.birthday');
Route::get('/celebrations', [BirthdayController::class, 'getCelebrations']);
Route::get('/get-celebrations', [BirthdayController::class, 'getCelebrations']);

//banner edit update delete
Route::get('/banner/{id}/edit', [BannerUploadController::class, 'edit'])->name('banner.edit');
Route::post('/banner/update/{id}', [BannerUploadController::class, 'update'])->name('banner.update');
Route::delete('/banner/delete/{id}', [BannerUploadController::class, 'destroy'])->name('banner.delete');

////////// bottom banner /////////
Route::post('/upload-bottom-banner', [BannerUploadController::class, 'uploadBottomBanner'])->name('upload.bottom.banner');

Route::get('/bottom-banners', [BannerUploadController::class, 'showBottomBanners'])->name('show.bottom.banners');

Route::delete('/delete-bottom-banner/{id}', [BannerUploadController::class, 'deleteBottomBanner'])->name('delete.bottom.banner');


Route::post('/store-bottom-banner', [BannerUploadController::class, 'storeBottomBanner'])->name('store.bottom.banner');
//banner end

//Events  by scm 10/03/2025

Route::prefix('admin')->group(function () {

    Route::get('/events', [EventController::class, 'index'])->name('event_index');
    Route::post('/addevents', [EventController::class, 'store'])->name('events_store');
    Route::get('/edit/{id}', [EventController::class, 'edit'])->name('event.edit');  // Edit page
Route::post('/update/{id}', [EventController::class, 'update'])->name('event.update'); // Form submit
  
});


Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
Route::delete('/completed-events/{id}', [EventController::class, 'deleteCompletedEvent'])->name('completed-events.delete');

//webevents
Route::get('/webevents', [WebsiteController::class, 'webevents'])->name('webevents');
Route::get('/member-gallery', [WebsiteController::class, 'gallery'])->name('member.gallery');
Route::get('/member-gallery/{event_id}', [WebsiteController::class, 'gallery'])->name('member.gallery.event');
Route::get('/webevents1', [WebsiteController::class, 'webevents1'])->name('webevents1');
Route::get('/gallery/{id}', [WebsiteController::class, 'show'])->name('gallery.show');


//awards
Route::get('/membership-awards', [MembershipAwardController::class, 'index'])->name('membership.awards.index');
Route::post('/membership-awards/store-award', [MembershipAwardController::class, 'storeAward'])->name('membership.awards.storeAward');
Route::post('/membership-awards/store-membership-award', [MembershipAwardController::class, 'storeMembershipAward'])->name('membership.awards.storeMembershipAward');
Route::delete('membership-awards/{id}', [MembershipAwardController::class, 'destroy'])->name('membership-awards.destroy');

Route::get('/teamdg', [WebsiteController::class, 'dgteam'])->name('dgteam');
Route::get('/international_officers', [WebsiteController::class, 'intofficer'])->name('international_officers');

Route::get('/districtgovernor', [WebsiteController::class, 'districtgovernor'])->name('districtgovernor');
Route::get('/pastdistrictgovernor', [WebsiteController::class, 'pastdistrictgovernor'])->name('pastdistrictgovernor');
Route::get('/districtchairperson', [WebsiteController::class, 'districtchairperson'])->name('districtchairperson');
Route::get('/regionmember', [WebsiteController::class, 'regionmember'])->name('regionmember');
Route::get('/chapter', [WebsiteController::class, 'chapter'])->name('chapter');

//AssignMemberController
Route::get('/assign-member', [AssignMemberController::class, 'index'])->name('assign.member');

Route::get('/assign-club', [AssignMemberController::class, 'clubindex'])->name('assign.club');
Route::get('/get-members-by-chapter/{id}', [AssignMemberController::class, 'getMembersByChapter'])->name('get.members.by.chapter');


Route::post('/search-member', [AssignMemberController::class, 'searchMember'])->name('search.member');

Route::post('/store-international-officer', [AssignMemberController::class, 'storeInternationalOfficer'])->name('store.international.officer');

Route::post('/assign-member', [AssignMemberController::class, 'store'])->name('assign.member.store');
Route::post('/store-district-governor', [AssignMemberController::class, 'storedistrictgovernor'])->name('store.district_governor');

Route::post('/store-dg-team', [AssignMemberController::class, 'storedg'])->name('dgteam.store');
Route::post('/assign-clubposition', [AssignMemberController::class, 'storeClubPosition'])->name('assign.clubposition');
Route::post('/assign-region-member', [AssignMemberController::class, 'storeRegionMember'])->name('assign.region.member');


Route::post('/store-past-governor', [AssignMemberController::class, 'storePastGovernor'])->name('store.past.governor');
Route::post('/assign-district-chairperson', [AssignMemberController::class, 'storeDistrictChairperson'])->name('assign.districtChairperson');
Route::get('/admin/remove-members', [AssignMemberController::class, 'remove'])->name('members.remove');


Route::get('/get-celebrations', [BirthdayController::class, 'getCelebrations']);
Route::get('/admin/birthday/future-week', [BirthdayController::class, 'showFutureWeekBirthdays'])->name('admin.birthday.future');


//import
Route::get('/members/import', [MemberController::class, 'showImportForm'])->name('members.import.form');
Route::post('/members/import', [MemberController::class, 'import'])->name('members.import');



Route::get('/admin/leftbanner', [BannerUploadController::class, 'showImages']);

Route::delete('delete-ad-image/{id}/{ad_type}', [BannerUploadController::class, 'deleteAdImage'])->name('delete.ad.image');

Route::delete('/delete-image1/{id}', [BannerUploadController::class, 'deleteImage1'])->name('delete.image1');

Route::delete('/delete-image2/{id}', [BannerUploadController::class, 'deleteImage2'])->name('delete.image2');
Route::delete('/delete-image3/{id}', [BannerUploadController::class, 'deleteImage3'])->name('delete.image3');


Route::get('/admin/settings', [SettingsController::class, 'add'])->name('admin.settings');

// Route for Add Setting Page
Route::get('/admin/settings/add', [SettingsController::class, 'add'])->name('admin.settings.add');

// Route for storing a setting
Route::post('/admin/settings/store', [SettingsController::class, 'store'])->name('admin.settings.store');

// Route for storing new district with a parent district
Route::post('/settings', [SettingsController::class, 'storedistrict'])->name('admin.settings.storedistrict');

// Routes for Account Names and Membership Types
Route::post('/settings/store-account-names', [SettingsController::class, 'storeAccountNames'])->name('admin.settings.storeAccountNames');
Route::post('/settings/store-membership-types', [SettingsController::class, 'storeMembershipTypes'])->name('admin.settings.storeMembershipTypes');

// Route for viewing settings
Route::get('/admin/settings/view', [SettingsController::class, 'view'])->name('admin.settings.view');

Route::delete('/settings/delete/parent-district/{id}', [SettingsController::class, 'destroyParentDistrict'])->name('settings.deleteParentDistrict');
//
Route::delete('/districts/{id}', [SettingsController::class, 'deleteDistrict'])->name('districts.delete');
Route::delete('/settings/chapter/{id}', [SettingsController::class, 'deleteChapter'])->name('admin.settings.deleteChapter');
Route::delete('/settings/membership/{id}', [SettingsController::class, 'deleteMembership'])->name('admin.settings.deleteMembership');
Route::delete('/districts/destroy/{id}', [SettingsController::class, 'destroyDistrict'])->name('districts.destroyDistrict');



Route::post('/store-completed-event', [EventController::class, 'storeCompletedEvent'])->name('store_completed_event');


Route::get('/fetch-banners', [WebsiteController::class, 'fetchBanners'])->name('fetchBanners');
/////////////////////////////////
Route::get('/admin/members', [BannerUploadController::class, 'showMembers'])->name('admin.members');
Route::post('/admin/members/add', [BannerUploadController::class, 'addMember'])->name('admin.addMember');
Route::delete('/admin/members/delete/{id}', [BannerUploadController::class, 'deleteMember'])->name('admin.deleteMember');
Route::get('/admin/members', [BannerUploadController::class, 'index'])->name('website.index');



Route::get('/import-international-officers', [AssignImportController::class, 'showImportForm'])->name('show.import.form');
Route::post('/import-international-officers', [AssignImportController::class, 'import'])->name('import.international.officers');
Route::post('/import/dg-team', [AssignImportController::class, 'importDGTeam'])->name('import.dg.team');

Route::post('/import-past-governors', [AssignImportController::class, 'importPastGovernors'])
    ->name('import.past.governors');
    Route::post('/import-district-chairpersons', [AssignImportController::class, 'importDistrictChairpersons'])->name('import.district.chairpersons');

    Route::post('/import/district-governors', [AssignImportController::class, 'importDistrictGovernors'])->name('import.district.governors');

    Route::post('/import/region-members', [AssignImportController::class, 'importRegionMembers'])->name('import.region.members');
    Route::post('/import/club-positions', [AssignImportController::class, 'importClubPositions'])->name('import.club.positions');




    Route::post('/admin/add-member', [BannerUploadController::class, 'addMember'])->name('admin.addMember');

Route::delete('/admin/delete-member/{id}', [BannerUploadController::class, 'deleteMember'])->name('admin.deleteMember');







//memberlogin controller
Route::get('member/login', [MemberLoginController::class, 'membershowLoginForm'])->name('member.login');
Route::post('member/login', [MemberLoginController::class, 'login']);
Route::get('member/logout', [MemberLoginController::class, 'logout'])->name('member.logout');

// Protected Route Example (Dashboard)
Route::middleware(['member.auth'])->group(function () {
    Route::middleware(['auth:member'])->group(function () {
        Route::get('member/dashboard', function () {
            return view('member.dashboard');
        })->name('member.dashboard');
    });



Route::middleware(['member.auth'])->group(function () {
    Route::get('member/edit', [MemberLoginController::class, 'edit'])->name('member.edit');
    Route::post('member/update', [MemberLoginController::class, 'update'])->name('member.update');
});

});


 // Member Lounge Routes
    Route::get('/member/lounge', [MemberLoungeController::class, 'index'])->name('member.lounge');
    Route::get('/member/details/{id}', [MemberLoungeController::class, 'show'])->name('member.details');





//admin (enquiry management)
Route::prefix('admin')->group(function () {
   Route::get('/enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries.index');


    Route::get('/donate', [EnquiryController::class, 'donateindex'])->name('admin.enquiries.donate');
    Route::get('/Career', [EnquiryController::class, 'donateCareer'])->name('admin.enquiries.Career');

});

Route::delete('/donations/{id}', [EnquiryController::class, 'destroy'])->name('donation.destroy');

Route::delete('/enquiries/{id}', [EnquiryController::class, 'destroyEnquiry'])->name('enquiry.destroy');



Route::post('/roles/store', [RoleManagementController::class, 'store'])->name('roles.store');





// Route to show the password update form
Route::get('/member/update-password', [PasswordController::class, 'showUpdatePasswordForm'])->name('member.updatePassword');

// Route to handle the password update form submission
Route::post('/member/update-password', [PasswordController::class, 'updatePassword'])->name('member.updatePassword.submit');


//admin side popup update
Route::post('/popup-banners/store', [PopupController::class, 'store'])->name('popup.store');
Route::delete('/popup/destroy/{id}', [PopupController::class, 'destroy'])->name('popup.destroy');

//admin approval
Route::get('/admin/approve-members', [ApproveController::class, 'index'])->name('admin.approve-members');
Route::post('/admin/approve-member/{id}', [ApproveController::class, 'approve'])->name('admin.approve-member');
Route::post('/admin/reject-member/{id}', [ApproveController::class, 'reject'])->name('admin.reject-member');

//adminmemberrole remove
Route::get('/admin/member-role-remove', [AssignMemberController::class, 'remove'])->name('members.remove');
Route::delete('/admin/member-role-data/{role}/{id}', [AssignMemberController::class, 'destroy'])->name('admin.member.role.delete');


//admin member lounge routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/member/lounge', [AdminMemberLoungeController::class, 'index'])->name('member.lounge');
    Route::get('/member/details/{id}', [AdminMemberLoungeController::class, 'show'])->name('member.details');
});
//career enquiry
Route::get('/admin/enquiry/career', [CareerEnquiryController::class, 'create'])->name('career.enquiry.page');

Route::post('/admin/enquiry/career/s', [CareerEnquiryController::class, 'store'])->name('career.enquiry');

Route::get('/admin/career-enquiry', [CareerEnquiryController::class, 'showForm'])->name('career.form');

Route::delete('/admin/career-enquiry/{id}', [CareerEnquiryController::class, 'destroy'])->name('career.enquiry.delete');
Route::get('/admin/career/{id}/edit', [CareerEnquiryController::class, 'edit'])->name('career.edit');
Route::post('/admin/career/{id}/update', [CareerEnquiryController::class, 'update'])->name('career.update');





// footer settings

Route::get('/admin/footer-settings', [HomepageController::class, 'footerSettings'])->name('footer.index');
Route::post('/admin/footer-settings/store', [HomepageController::class, 'store'])->name('footer.store');
Route::delete('/footer/{id}', [HomepageController::class, 'destroy'])->name('footer.delete');
// Route for displaying images and upload form
Route::get('/admin/homepage/pinimage', [HomepageController::class, 'index'])->name('admin.homepage.pinimage');

// Route for handling image upload (POST request)
Route::post('/admin/pinimage', [HomepageController::class, 'pinimagestore'])->name('pinimage.store');
Route::delete('/images/{id}', [HomepageController::class, 'pinimagedestroy'])->name('images.destroy');



/// landing page 

Route::post('/login-submit', [WebsiteController::class, 'login'])->name('login.submit');


