<?php
  function lang($text){
    $lang = [
      // login
      'ADMINLOGIN'=> 'تسجيل دخول الأدمن',
      'EMAIL'     => 'البريد الإلكترونى',
      'PASSWORD'  => 'كلمة المرور',
      'ERROR'     => 'البريد الإلكترونى أو كلمة المرور غير صحيح',
      // navbar
      'HOME'      => 'الصفحة الرئيسية',
      'CATEGORIES'=> 'الأقسام',
      'STATISTICS'=> 'الإحصائيات',
      'USERS'     => 'المستخدمين',
      'PROFILE'   => 'الحساب',
      'SETTING'   => 'الإعدادات',
      'LOGOUT'    => 'تسجيل الخروج',
      'LOGIN'     => 'تسجيل الدخول',
      'DASHBOARD' => 'لوحة التحكم',
      // manage users
      'MANAGE'    => 'إدارة المستخدمين',
      'ID'        => '#الرقم',
      'RGSTRDATE' => 'تاريخ التسجيل',
      'CONTROL'   => 'التحكم',
      'ADDUSR'    => 'إضافة مستخدم جديد',
      'DELETE'    => 'حذف المستخدم',
      'CANCEL'    =>  'إلغاء',
      'ACTIVATE'  => 'تفعيل',
      'ACTIVSUC'  => 'تم تفعيل المستخدم',
      'ACTIVFAIL' => 'حدث خطأ أثناء التفعيل',
      // adduser
      'ADDUSER'   => 'إضافة مستخدم',
      'PASSCONF'  => 'تأكيد كلمة المرور',
      // edit
      'USERS'     => 'المستخدمين',
      'EDIT'      => 'تعديل بيانات المستخدم',
      'USERNAME'  => 'اسم المستخدم',
      'FULLNAME'  => 'الاسم بالكامل',
      'UPDATE'    => 'تحديث',
      // update
      'UPDATEDATA'=> 'تحديث البيانات',
      'UPDSUCCESS'=> 'تم تحديث البيانات بنجاح',
      // insert
      'INSSUCCESS'=> 'تم إضافة المستخدم بنجاح',
      'EMLEXST'   => 'عفواً هذا البريد الإلكترونى موجود من قبل',
      'USREXST'   => 'عفواً هذا المستخدم موجود من قبل',
      'NOTALLOWED'=> 'عفواً ليس لديك الصلاحية للتواجد فى هذه الصفحة',
      // delete
      'DLTSUC'    => 'تم حذف المستخدم بنجاح',
      'DLTFAIL'   => 'حدث خطأ أرجوك أعد المحاولة لاحقا',
      'DELCONFIRM'=> 'هل انت متأكد أنك تريد حذف هذا المستخدم',
      'NOUSER'    => 'هذا المستخدم غير موجود',
      // DASHBOARD
      'ALLUSERS'  => 'عدد المستخدمين',
      'PENDING'   => 'عدد المستخدمين غير المفعلين',
      'ALLITEMS'  => 'عدد العناصر',
      'TODVISITS' => 'عدد زيارات اليوم'
    ];
    return $lang[$text];
  }
?>