<?php

return [
    'dashboard' => 'Donor Dashboard',
    'greeting' => 'Hello, :name! 👋',
    'sub_greeting' => 'Let\'s help reduce food waste today!',
    'btn_create' => '+ Donate Food',
    'stat_active' => 'Active Donations',
    'stat_active_desc' => 'Ready for pickup',
    'stat_req' => 'Incoming Requests',
    'stat_req_desc' => 'Needs response',
    'stat_claim' => 'Completed Claims',
    'stat_claim_desc' => 'Distributed',
    'stat_complete' => 'Completed Donations',
    'stat_complete_desc' => 'Distributed',
    
    // Tabs
    'tab_active' => 'Active',
    'tab_req' => 'Requests',
    'tab_process' => 'In Process',
    'tab_history' => 'History',
    
    // Active Tab
    'empty_active' => 'No active donations yet. Donate now!',
    'th_food' => 'Food Name',
    'th_qty' => 'Available Qty',
    'th_time' => 'Pickup Time',
    'th_exp' => 'Expiration Date',
    'th_action' => 'Action',
    'status_expired' => 'Expired',
    'status_expired_badge' => 'Expired',
    
    // Modal Delete
    'modal_del_title' => 'Delete Food',
    'modal_del_body' => 'Are you sure you want to delete <strong>:name</strong>? Deleted data cannot be restored.',
    'btn_cancel' => 'Cancel',
    'btn_delete' => 'Yes, Delete',
    
    // Requests Tab
    'empty_req' => 'No incoming requests at the moment.',
    'th_receiver' => 'Receiver',
    'th_req_food' => 'Requested Food',
    'th_req_qty' => 'Requested Qty',
    'th_msg' => 'Message',
    'badge_left' => 'Left: :count',
    'btn_accept' => 'Accept',
    'btn_reject' => 'Reject',
    
    // Modal Reject
    'modal_rej_title' => 'Reject Request',
    'modal_rej_body' => 'Are you sure you want to reject request from <strong class="text-dark">:name</strong>?',
    'label_reason' => 'Select Rejection Reason:',
    'reason_default' => '-- Select Reason --',
    'reason_1' => 'Already taken by someone else',
    'reason_2' => 'Location is too far',
    'reason_3' => 'Pickup time does not match',
    'reason_4' => 'Food stock is empty',
    'reason_5' => 'Other',
    'btn_submit_reject' => 'Reject Request',
    
    // Process Tab
    'empty_process' => 'No donations currently in process.',
    'alert_process' => 'Items here are waiting to be picked up by the receiver. You cannot edit data, but you can cancel if urgent.',
    'th_qty_simple' => 'Qty',
    'btn_confirm' => 'Confirm',
    'btn_cancel_process' => 'Cancel',
    
    // Modal Verify
    'modal_ver_title' => 'Confirm Donation Completion',
    'modal_ver_body' => 'Enter the 4-digit code shown by <strong>:name</strong>:',
    'btn_verify' => 'Confirm',
    
    // Modal Cancel Process
    'modal_cancel_title' => 'Cancel Process',
    'modal_cancel_body' => 'Are you sure you want to cancel the donation process for <strong>:name</strong>?',
    'btn_yes_cancel' => 'Yes, Cancel',
    
    // History Tab
    'subtab_claim' => 'Claim History',
    'subtab_item' => 'Donation History',
    'empty_hist_claim' => 'No receiver transaction history yet.',
    'th_date_done' => 'Completion Date',
    'th_status' => 'Status',
    'status_completed' => 'Completed',
    'status_rejected' => 'Rejected',
    'status_cancelled' => 'Cancelled',
    'empty_hist_item' => 'No food stock history yet.',
    'th_final_status' => 'Final Status',
    'status_donated' => 'Donated',
    
    // Create Page
    'create_title' => 'Create New Donation',
    'create_subtitle' => 'Fill in the details of the food you want to share.',
    'form_title' => 'Food Information Form',
    'label_photo' => 'Food Photo',
    'label_click_upload' => 'Click to upload photo',
    'label_name' => 'Food Name',
    'ph_name' => 'Ex: Chocolate Filled Bread',
    'label_category' => 'Category',
    'select_default' => '-- Select --',
    'label_qty' => 'Quantity',
    'unit_qty' => 'Portions',
    'title_pickup' => 'Pickup Details',
    'label_exp' => 'Expiration',
    'label_time' => 'Pickup Time',
    'ph_time' => 'Ex: 15.00 - 18.00',
    'label_loc' => 'Pickup Location',
    'ph_loc' => 'Search on map or type address...',
    'btn_loc_me' => 'My Location',
    'help_map' => 'Marker automatically follows your location. Drag marker to adjust.',
    'label_desc' => 'Additional Description',
    'label_desc_opt' => '(Optional)',
    'ph_desc' => 'Explain food condition, halal/non-halal, or specific instructions...',
    'btn_back' => 'Back',
    'btn_upload' => 'Upload Donation',

    // JS Messages
    'js_searching' => 'Searching street name...',
    'js_detecting' => 'Detecting GPS location...',

    // Profile Page
    'verified_donor' => 'Verified Donor',
    'label_email' => 'Email',
    'label_phone' => 'Phone Number',
    'label_address' => 'Main Address',
    'join_since' => 'Joined Since',
    'btn_edit_profile' => 'Edit Profile',
    'recent_activity' => 'Recent Activity',
    'btn_view_all' => 'View All',
    'activity_empty' => 'No recent activity.',
    'status_active' => 'Active',
    'status_process' => 'Process',
    
    // Profile Edit Page
    'edit_title' => 'Edit Profile',
    'edit_subtitle' => 'Update your personal information and address.',
    'form_personal_title' => 'Personal Data Form',
    'account_info' => 'Account Information',
    'label_fullname' => 'Full Name',
    'label_phone_wa' => 'Phone Number / WhatsApp',
    'title_main_loc' => 'Main Location',
    'label_full_addr' => 'Full Address',
    'ph_addr_manual' => 'Search on map or type manually...',
    'help_drag_map' => 'Drag the red marker on the map to update the address automatically.',
    'btn_save_changes' => 'Save Changes',
];