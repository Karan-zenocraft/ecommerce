<?php
if ($_SERVER['HTTP_HOST'] == "localhost") {

    Yii::setAlias('@common_base', '/ecommerce/common/');

} else {

    Yii::setAlias('@common_base', '/ecommerce/common/');
}
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@root', realpath(dirname(__FILE__) . '/../../'));
Yii::setAlias('@htmlpath', realpath(dirname(__FILE__) . '/../../../'));

//START: site configuration
Yii::setAlias('site_title', 'Stable');
Yii::setAlias('site_footer', 'Stable');
//END: site configuration

//START: BACK-END message

//START: Admin users
Yii::setAlias('admin_user_change_password_msg', 'Your password has been changed successfully !');
Yii::setAlias('admin_user_forget_password_msg', 'E-Mail has been sent with new password successfully !');
//END: Admin user

//START: Email template message
Yii::setAlias('email_template_add_message', 'Template has been added successfully !');
Yii::setAlias('email_template_update_message', 'Template has been updated successfully !');
Yii::setAlias('email_template_delete_message', 'Template has been deleted successfully !');
//END: Email template message

//START: User message
Yii::setAlias('user_add_message', 'user has been added successfully !');
Yii::setAlias('user_update_message', 'user has been updated successfully !');
Yii::setAlias('user_delete_message', 'user has been deleted successfully !');
//END:  User message

//START: Categories message
Yii::setAlias('category_add_message', 'category has been added successfully !');
Yii::setAlias('category_update_message', 'category has been updated successfully !');
Yii::setAlias('category_delete_message', 'category has been deleted successfully !');
//END:  Categories message

//START: Products message
Yii::setAlias('product_add_message', 'product has been added successfully !');
Yii::setAlias('product_update_message', 'product has been updated successfully !');
Yii::setAlias('product_delete_message', 'product has been deleted successfully !');
//END:  Products message
//START: Sub Categories message
Yii::setAlias('subcategory_add_message', 'Sub Category has been added successfully !');
Yii::setAlias('subcategory_update_message', 'Sub Category has been updated successfully !');
Yii::setAlias('subcategory_delete_message', 'Sub Category has been deleted successfully !');
//END:  Sub Categories message

//START: Brands message
Yii::setAlias('brand_add_message', 'Brand has been added successfully !');
Yii::setAlias('brand_update_message', 'Brand has been updated successfully !');
Yii::setAlias('brand_delete_message', 'Brand has been deleted successfully !');
//END:  Brands message
