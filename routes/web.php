<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/login', 'LoginController@getLogin');
Route::get('/get_lga_by_state/{state_id}', 'ActionController@getLgaByState');
Route::get('/get-user-by-usercode/{state_id}', 'ActionController@getUserByUserCode');
Route::get('/get_state_by_country/{country_id}', 'ActionController@getStateByCountry');
Route::get('/get_thread_messages_by_code/{code}', 'ActionController@getThreadMessageByCode');
Route::get('/get_support_messages_by_code/{code}', 'ActionController@getSupportThreadMessageByCode');
Route::post('/update-customer-profile', 'ActionController@postUpdateCustomerProfile');
Route::post('/create-customer-account', 'ActionController@postCreateCustomerAccount');
Route::get('/get-user-data', 'ActionController@getUserData');

Route::group([
    'middleware' => ['guest']
], function () {

    Route::get('/auth/login', 'Auth\LoginController@getLoginView');

    Route::get('/forgot-password', 'Auth\LoginController@getForgotPasswordView');

    Route::post('/auth/login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
    Route::post('/forgot-password', [ 'as' => 'login', 'uses' => 'Auth\LoginController@postResetPassword']);

});


Route::group([
    'middleware' => ['guest']
], function () {

    Route::post('/api/auth/login', 'APIController@postLoginApi');

});


Route::group([
    'middleware' => ['jwt.auth']
], function () {
    Route::post('/api/projects-list', 'APIController@getAllProjects');
    Route::post('/api/my-projects-list', 'APIController@getMyProjects');
    Route::post('/api/bid-project', 'APIController@postBidProject');
    Route::post('/api/create-new-project', 'APIController@postCreateNewProject');
    Route::post('/api/get-project', 'APIController@postGetProject');
    Route::post('/api/delete-project-bid', 'APIController@postDeleteProject');
    Route::post('/api/cancel-project', 'APIController@postCancelProject');
    Route::post('/api/assign-bid-win', 'APIController@postAssignProjectBinWin');
    Route::post('/api/cancel-project-assignment', 'APIController@postReAssignProjectBinWin');
    Route::post('/api/accept-project-assignment', 'APIController@postAcceptProjectBinWin');
    Route::post('/api/mark-project-completed', 'APIController@postMarkProjectCompleted');
    Route::post('/api/compose-project-message', 'APIController@postComposeMessage');
    Route::post('/api/message-thread-list', 'APIController@postGetAllMessageThreads');
    Route::post('/api/view-thread-messages', 'APIController@postGetThreadMessages');
    Route::post('/api/get-project-payment-details', 'APIController@postGetProjectPaymentDetails');
    Route::post('/api/get-user-details-by-code', 'APIController@postGetUserDetailsByUserCode');
    Route::post('/api/update-user-details', 'APIController@postUpdateUserDetails');
    Route::post('/api/get-user-image', 'APIController@postGetUserImage');



});



Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/auth/logout', 'Auth\LoginController@getLogout');
});

Route::group([
    'middleware' => ['preview_update_user']
], function () {
    Route::get('/', 'ActionController@getIndex');





    Route::get('/register-artisan', 'Auth\RegisterController@getRegisterArtisanStepOne');
    Route::get('/register-artisan-step-two', 'Auth\RegisterController@getRegisterArtisanStepTwo');
    Route::get('/register-artisan-step-three', 'Auth\RegisterController@getRegisterArtisanStepThree');
    Route::get('/register-artisan-step-four', 'Auth\RegisterController@getRegisterArtisanStepFour');
    Route::post('/register-artisan', 'Auth\RegisterController@postRegisterArtisanStepOne');
    Route::post('/register-artisan-step-two', 'Auth\RegisterController@postRegisterArtisanStepTwo');
    Route::post('/register-artisan-step-three', 'Auth\RegisterController@postRegisterArtisanStepThree');
    Route::post('/register-artisan-step-four', 'Auth\RegisterController@postRegisterArtisanStepFour');
    Route::get('/new-project-step-one/{projecturl?}', 'ProjectController@getNewTaskStepOne');
    Route::get('/new-project-step-two', 'ProjectController@getNewTaskStepTwo');
    Route::get('/new-project-step-three', 'ProjectController@getNewTaskStepThree');
    Route::get('/new-project-step-four', 'ProjectController@getNewTaskStepFour');
    Route::post('/new-project-step-one', 'ProjectController@postNewTaskStepOne');
    Route::post('/new-project-step-two', 'ProjectController@postNewTaskStepTwo');
    Route::post('/new-project-step-three', 'ProjectController@postNewTaskStepThree');
    Route::post('/new-project-step-four', 'ProjectController@postNewTaskStepFour');
    Route::get('/project-details/{project_url}', 'ProjectController@getTaskDetails');
    Route::get('/all-projects', 'ProjectController@getAllProjects');
    Route::post('/activate-account', 'Auth\LoginController@postActivateAccount');
    Route::post('/route/complete', 'TransactionController@postHandleProbasePayResponse');
    Route::post('/place-bid/{project_url}', 'ProjectController@postProjectBid');
    Route::get('/add-person-to-favorites/{user_code}', 'ProjectController@addPersonToFavorites');
    Route::get('/remove-person-from-favorites/{user_code}', 'ProjectController@removePersonFromFavorites');
    Route::get('/add-project-to-watchlist/{project_url}', 'ProjectController@addProjectToWatchlist');
    Route::get('/remove-project-from-watchlist/{project_url}', 'ProjectController@removeProjectFromWatchlist');
    Route::post('/send-project-message/{project_url}', 'ProjectController@sendProjectMessage');
    Route::post('/send-support-message/{project_url}', 'ProjectController@sendSupportMessage');
    Route::post('/cancel-project/{project_url}', 'ProjectController@cancelProject');
    Route::post('/mark-project-completed/{project_url}', 'ProjectController@markProjectCompleted');
    Route::get('/project-manage/manage-bid/{project_code}/{project_bid_code}', 'ProjectController@assignBidToProject');
    Route::get('/project-manage/manage-bid-accept-handle/{project_code}/{project_bid_code}', 'ProjectController@acceptHandleProjectBid');
    Route::post('/project-manage/release-funds/{project_code}/{project_bid_code}', 'ProjectController@releaseProjectBidFunds');
    Route::group([
        'middleware' => ['auth']
    ], function () {
        Route::get('/bid-on-project/{project_url}', 'ProjectController@getBidOnProject');
        Route::get('/admin/dashboard', 'Auth\LoginController@getDashboard');
        Route::get('/admin/projects', 'ProjectController@getProjectList');
        Route::get('/admin/all-projects', 'ProjectController@getAllProjectList');
        Route::get('/admin/transactions', 'TransactionController@getTransactionList');
        Route::get('/admin/wallet-transactions', 'TransactionController@getWalletTransactionList');
        Route::get('/admin/all-transactions', 'TransactionController@getAllTransactionList');
        Route::get('/admin/all-wallets', 'TransactionController@getWalletList');
        Route::get('/admin/all-wallet-transactions', 'TransactionController@getAllWalletTransactionList');
        Route::post('/admin/wallet-manage/request-wallet-debit', 'TransactionController@postRequestWalletDebit');
        Route::get('/admin/wallet-manage/{disable_enable}/{wallet_number}', 'TransactionController@getUpdateWalletStatus');
        Route::get('/admin/wallet-manage/confirm-payout/{transaction_ref}', 'TransactionController@confirmTransactionPayOut');
        Route::get('/admin/new-skill/{listId?}', 'ProjectController@getNewSkills');
        Route::get('/admin/delete-skill/{listId?}', 'ProjectController@getDeleteSkill');
        Route::post('/admin/new-skill/{listId?}', 'ProjectController@postNewSkills');
        Route::get('/admin/all-skills', 'ProjectController@getSkillList');
        Route::get('/admin/new-admin-user', 'UserController@getNewAdminUser');
        Route::get('/admin/all-users', 'UserController@getAllUsers');
        Route::get('/admin/user-manage/validate/{user_code}', 'UserController@getValidateUser');
        Route::get('/admin/messages', 'UserController@getMyMessages');
        Route::get('/admin/all-messages', 'UserController@getAllMessages');
        Route::get('/admin/support-tickets/{project_code?}', 'ProjectController@getSupportTickets');
        Route::post('/support-ticket/reply-message', 'ProjectController@postSendSupportTicketReply');
        Route::get('/admin/project-manage/cancel/{project_code}', 'ProjectController@adminCancelProject');
    });

    /*Clients*/
    Route::get('/register-client', 'Auth\RegisterController@getRegisterClientStepOne');
    Route::get('/register-client-step-two', 'Auth\RegisterController@getRegisterClientStepTwo');
    Route::get('/register-client-step-three', 'Auth\RegisterController@getRegisterClientStepThree');
    Route::post('/register-client', 'Auth\RegisterController@postRegisterClientStepOne');
    Route::post('/register-client-step-two', 'Auth\RegisterController@postRegisterClientStepTwo');
    Route::post('/register-client-step-three', 'Auth\RegisterController@postRegisterClientStepThree');

    Route::get('/test1/{plate}', 'ActionController@getTest');



    Route::get('/start-afresh', 'ActionController@startAfresh');
    Route::get('/payments/clear-shipping/{id}', 'ActionController@clearShipping');
    Route::get('/resend-otp/{payeeId}', 'ActionController@resendOtp');
    Route::get('/payments/insurance-road-tax-check', 'ActionController@getInsuranceRoadTaxCheck');
    Route::post('/payments/insurance-road-tax-check', 'ActionController@postInsuranceRoadTaxCheck');
    Route::get('/payments/otp/{data}', 'ActionController@getOTP');
    Route::post('/payments/otp/{data}', 'ActionController@postOTP');
    Route::get('/payments/insurance-road-tax-purchase/{responseData}', 'ActionController@getInsuranceRoadTaxPurchase');
    Route::get('/payments/purchase-insurance-tax/{data}', 'ActionController@getPurchaseInsuranceTax');
    Route::post('/payments/purchase-insurance-tax/{data}', 'ActionController@postPurchaseInsuranceTax');
    Route::get('/payments/purchase-other-taxes/{data}', 'ActionController@getPurchaseOtherTaxes');
    Route::post('/payments/purchase-other-taxes/{data}', 'ActionController@postPurchaseOtherTaxes');
    Route::get('/payments/review-purchase/{data}', 'ActionController@getReviewPurchase');
    Route::post('/payments/review-purchase/{data}', 'ActionController@postReviewPurchase');
    Route::post('/payments/add-shipping/{data}', 'ActionController@postAddShippng');
    Route::post('/payments/review-purchase-road-tax/{data}', 'ActionController@postReviewPurchaseRoadTax');
    Route::get('/payments/cart/remove/{item}', 'ActionController@removeCartItem');
    Route::get('/payments/route-success', 'ActionController@getRouteSuccess');
    Route::post('/payments/route-success', 'ActionController@postRouteSuccess');
    Route::get('/payments/display-receipt/{orderId}', 'ActionController@getReceipt');
    Route::get('/payments/display-receipt-pdf/{orderId}', 'ActionController@getPDFReceipt');
    Route::get('/payments/purchase-road-tax/view-breakdown/{data}', 'ActionController@getTaxBreakDown');
    Route::get('/payments/purchase-road-tax/view-breakdown-insurance', 'ActionController@getInsuranceBreakDown');
    Route::get('/cart/remove-insurance', 'ActionController@getRemoveInsurance');
    Route::get('/cart/remove-fitness-test', 'ActionController@getRemoveFitnessTest');

    Route::group([
        'middleware' => ['auth', 'cashcollectionshandler']
    ], function () {
        Route::post('/in-house/collections', 'ActionController@postInHouseCollections');
    });

    Route::get('/pages/{id}', 'ActionController@getWebPage');


    Route::group([
        'middleware' => ['auth']
    ], function () {
        //Route::get('/auth/logout', 'Auth\LoginController@getLogout');

        Route::get('/taxes/generate-certificate-step-one/{id}', 'ActionController@generateCertificateStepOne');
        Route::get('taxes/collect-certificate/{id}', 'ActionController@getCertificateOTP');
        Route::post('taxes/collect-certificate/{id}', 'ActionController@postCertificateOTP');
        Route::get('/dashboard', 'ActionController@getDashboard');

    });
    //Route::get('/taxes/generate-certificate-step-two/{id}', 'ActionController@generateCertificate');

    Route::group([
        'middleware' => ['auth', 'transactionhandler']
    ], function () {

        Route::get('/certificates/list', 'ActionController@getCertificateList');
        Route::get('/audit-trails/list', 'ActionController@getAuditTrailList');
        Route::get('/sms-usage/list', 'ActionController@getSmsUsageList');
        Route::get('/taxes/change-certificate-status/{certId}/{status}', 'ActionController@changeCertificateStatus');

        Route::get('/taxes/handle-transaction-step-one/{status}/{id}', 'ActionController@getHandleTransactionStepOne');
        Route::get('/taxes/handle-transaction/{status}/{id}', 'ActionController@getHandleTransactionOTP');
        Route::post('/taxes/handle-transaction/{status}/{id}', 'ActionController@postHandleTransactionOTP');
        Route::get('/taxes/{status}/{transaction_ref}', 'ActionController@changeTransactionStatus');

        Route::get('/workflows/items-list', 'ActionController@getListWorkflowItems');
    });


    Route::group([
        'middleware' => ['auth', 'vendor']
    ], function () {

        Route::get('/vendors/fund-vendor', 'ActionController@getFundVendor');
        Route::post('/vendors/fund-vendor', 'ActionController@postFundVendor');
    });

    Route::group([
        'middleware' => ['auth']
    ], function () {

        Route::get('/transactions/list', 'ActionController@getTransactionList');
        Route::get('/transaction-breakdown/list/{ref?}', 'ActionController@getTransactionBreakdownList');
        Route::get('/audit-trails/list', 'ActionController@getAuditTrailList');
        Route::get('/vendors/vendor-transactions', 'ActionController@getVendorTransactions');
        Route::get('/vendors/wallet-transactions', 'ActionController@getWalletTransactions');
    });


    Route::group([
        'middleware' => ['auth']
    ], function () {
        Route::get('/admin/my-transactions', 'ActionController@getMyTransactionList');
    });


    Route::group([
        'middleware' => ['auth', 'artisan']
    ], function () {
        Route::get('/admin/my-projects', 'ProjectController@getMyProjects');


    });

    Route::group([
        'middleware' => ['auth', 'client']
    ], function () {
        Route::get('/admin/my-project-list', 'ProjectController@getMyProjects');
    });

    Route::group([
        'middleware' => ['auth', 'admin_courier']
    ], function() {

        Route::get('/courier-services/view-delivery-pricing/{id}', 'ActionController@getViewDeliveryPricing');
        Route::get('/courier-services/view-delivery-items/{id}', 'ActionController@getViewDeliveryItems');
    });


    Route::group([
        'middleware' => ['auth', 'courier']
    ], function() {

        Route::get('/courier-services/add-delivery-pricing/{id}/{priceId?}', 'ActionController@addDeliveryPricing');
        Route::post('/courier-services/add-delivery-pricing/{id}', 'ActionController@postAddDeliveryPricing');
        Route::get('/courier-services/delivery-item-status-update/{status}/{firm_id}/{id}', 'ActionController@getUpdateDeliveryBillStatus');
    });
});