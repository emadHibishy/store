<?php
  function lang($text){
    $lang = [
      // login
      'ADMINLOGIN'=> 'ADMIN LOGIN',
      'EMAIL'     => 'Email',
      'PASSWORD'  => 'Password',
      'ERROR'     => 'Email or Password not correct',
      // navbar
      'HOME'      => 'Home',
      'CATEGORIES'=> 'Categories',
      'STATISTICS'=> 'Statistics',
      'PRODUCTS'  => 'Products',
      'USERS'     => 'Users',
      'COMMENTS'  => 'Comments',
      'PROFILE'   => 'Profile',
      'SETTING'   => 'Setting',
      'LOGOUT'    => 'Logout',
      'LOGIN'     => 'Login',
      'DASHBOARD' => 'Dashboard',
      // manage users
      'MANAGE'    => 'Manage ',
      'ID'        => '#ID',
      'RGSTRDATE' => 'Register Date',
      'CONTROL'   => 'Control',
      'ADDUSR'    => 'Add New User',
      'DELETE'    => 'Delete',
      'CANCEL'    => 'Cancel',
      'ACTIVATE'  => 'Activate',
      'ACTIVSUC'  => 'User Activated Successfully',
      'ACTIVFAIL' => 'Activate Failed ',
      // adduser
      'ADDUSER'   => 'Add User',
      'PASSCONF'  => 'Password Confirm',
      // edit
      'USER'     => 'User',
      'EDIT'      => 'Edit ',
      'USERNAME'  => 'Username',
      'FULLNAME'  => 'Full Name',
      'UPDATE'    => 'Update ',
      // update
      'UPDATEDATA'=> 'Update Data',
      'UPDSUCCESS'=> 'Updated Successfully',
      // insert
      'INSSUCCESS'=> 'User Added Successfully',
      'EMLEXST'   => 'Sorry, This Email Is Already Exist',
      'USREXST'   => 'Sorry, This User Is Already Exist',
      'NOTALLOWED'=> 'Sorry, You Are Not Allowed To Be Here',
      // delete
      'DLTSUC'    => ' Deleted Successfully',
      'DLTFAIL'   => 'Something Went Wrong, Try Again Later',
      'DELCONFIRM'=> 'Are You Sure You Want To Delete This ',
      'NOUSER'    => 'No User Found',
      // DASHBOARD
      'TOTAL'     => 'Total ',
      'PENDING'   => 'Pending Users',
      'ALLITEMS'  => 'All Items',
      'TODVISITS' => 'Today Visits',
      'NEWUSERS'  => 'New Users',
      'NEWITEMS'  => 'New Products',
      'NEWCOMMS'  => 'New Comments',
      // category
      'CATEGORY'  => 'Category',
      'ADDCAT'    => 'Add Category',
      'CATNAME'   => 'Category Name',
      'DESC'      => 'Description',
      'ORDER'     => 'Order',
      'VISIBILITY'=> 'Visibility',
      'VISIBLE'   => 'Visible',
      'HIDDEN'    => 'Hidden',
      'NONVISIBLE'=> 'Non Visible',
      'COMMENTS'  => 'Comments',
      'ALLOW'     => 'Allow',
      'DECLINE'   => 'Decline',
      'ADS'       => 'Ads',
      'CATADDED'  => 'Category Inserted Successfully',
      'CATEXST'   => 'This Category Is Already Exist',
      'NODATA'    => 'No Data Found',
      'NOCAT'     => 'No Category Found',
      'PARENT'    => 'Parent',
      // products
      'PRODUCT'   => 'Product',
      'ADD'   => 'Add ',
      'PRODNAME'  => 'Product Name',
      'PRICE'     => 'Price',
      'COUNTRY'   => 'Country',
      'NEW'       => 'New',
      'LIKENEW'   => 'Like New',
      'USED'      => 'Used',
      'OLD'       => 'Old',
      'STATUS'    => 'Status',
      'RATING'    => 'Rating',
      'PRODADDED' => 'Product Added Successfully',
      'DATE'      => 'Date',
      'APPROVE'   => 'Approve',
      'APPROVED'  => 'Approved Successfully',
      // comments
      'COMMENT'   => 'Comment'
    ];
    return $lang[$text];
  }
?>