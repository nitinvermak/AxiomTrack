<?
/*
filename:array.inc.php
this file is used to define all alert messages
*/
@extract($_POST);
$ARR_MSG['Record has been successfully deleted']="Record has been successfully deleted.";
$ARR_MSG['Plan has been successfully addeded']="Plan has been successfully added";
$ARR_MSG['Plan has been successfully updated']="Plan has been successfully updated";
$ARR_MSG['Plan has been successfully closed']="Plan has been successfully Closed";
$ARR_MSG['Plan has been successfully opened']="Plan has been successfully Activated";
$ARR_MSG['Plan exists as deleted']= $plan_title." is already exist but you have deactivated it!! Do you want to activate it again?";
$ARR_MSG['Plan exists']="Oops Sorry!!! Please see here this Activity already exists!";
$ARR_MSG['Plan opened'] = $plan_title." is Activated";
$ARR_MSG['Plan Edit error'] = "Another Activity exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Plan Completion date error'] = "Completion date can't be less than start date and more than current date";
$ARR_MSG['Record Deleted Successfully'] = "Record Deleted Successfully";


$ARR_MSG['location has been successfully updated']="Location has been successfully updated";
$ARR_MSG['Location addeded']="Location has been successfully addeded";
$ARR_MSG['Location updated']="Location has been successfully updated";
$ARR_MSG['Location exists']="Oops Sorry!!! Please see here this Location already exists!";
$ARR_MSG['Location exists as deleted']= $site_name." is already exist but you have deleted it!! Do you want to add it again?";
$ARR_MSG['Location opened'] = $site_name." is again added";
$ARR_MSG['Location Edit error'] = "Another Location exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Location delete error'] = "Sorry you can't delete this Location. Alreday is Occupied by some resources.";
$ARR_MSG['Location deleted'] = "Location has been successfully deleted";

//$ARR_MSG['You have successfully registered']="You have successfully registered.We will activate your profile within 24 hours.";
$ARR_MSG['You have successfully registered']="New Employee Registered successfully! Will be activated within 24 Hours.";
$ARR_MSG['Password and confirm password has been not matched']="Password and confirm password has been not matched";

$ARR_MSG['This user name or email id has been already exist']="This user name or email id has ben already exist";
$ARR_MSG['Please fill the following astrick mark fields']="Please fill the following astrick (*) mark fields";
$ARR_MSG['Please fill a Valid Email Id']="Please Enter a Valid Email Id";
$ARR_MSG['User Name should be alphanumeric']="User Name should be alphanumeric";
$ARR_MSG['Please Enter a valid phone Number']="Please Enter a valid phone Number";
$ARR_MSG['Please Enter a valid Name']="Please check the first name and last name entered";
$ARR_MSG['Please Enter a valid Mobile Number']="Please Enter a valid Mobile Number followed by country code";
$ARR_MSG['Please Enter a valid Zip Code']="Please Enter a valid Zip Code";
$ARR_MSG['Please Enter a valid Fax Number']="Please Enter a valid Fax Number";

$ARR_MSG['Employee exists']="Oops Sorry!!! Please see here this Employee already exists!";
$ARR_MSG['Employee exists as deleted']= "An Employee With This username or Email Id already exist but not as an deactive user!! Do you want to Activate it again?";
$ARR_MSG['Employee activated'] = "Employee Account is activated now";
$ARR_MSG['Multiple record exists'] = "Sorry!! Entered Email Id and username exists for two different Employees, Please change it";
$ARR_MSG['Emp Edit error'] = "Another Employee exists in the list who has the same email id. Please Choose any other email id to edit!!";
$ARR_MSG['Emp delete error'] = "Some Activities assigned to this Employee. Can't Delete!!";
$ARR_MSG['Record has been Activated'] = "The Employee has been Activated.";
$ARR_MSG['Record has been De-activated'] = "The Employee has been De-activated.";
$ARR_MSG['One should be filled'] = "Please Enter Either Username or Emailid to Recover Your password";
$ARR_MSG['Please Make Sure'] = "We are not able to found your details, Please contact to System Admin";
$ARR_MSG['Password sent Successfully'] ="Your password sent Successfully to your mail account";
$ARR_MSG['Problem in Sending Password'] ="There is some problem in sending password to your mail account please try after some time.";



$ARR_MSG['Record has been successfully updated']="Record has been successfully updated";
$ARR_MSG['Record has been successfully addeded']="Record has been successfully addeded";

$ARR_MSG['This plan has been already assigned in this location']="This plan has been already assigned in this location";
$ARR_MSG['This employee has been already exist in other location']="This employee has been already exist in another location";

$ARR_MSG['Risk has been successfully addeded']="Risk has been successfully addeded";
$ARR_MSG['Risk has been successfully Updated']="Risk has been successfully Updated";

$ARR_MSG['Invalid user name or password']="Invalid user name or password";
$ARR_MSG['You have not authorised for this action']="You are not authorised for this action";

$ARR_MSG['Circle has been successfully addeded']="Circle has been successfully addeded";
$ARR_MSG['Circle has been successfully updated']="Circle has been successfully updated";

$ARR_MSG['Region has been successfully updated']="Region has been successfully updated";

$ARR_MSG['LOB addeded']="LOB has been successfully addeded";
$ARR_MSG['LOB updated']="LOB has been successfully updated";
$ARR_MSG['LOB exists']="Oops Sorry!!! Please see here this LOB already exists!";
$ARR_MSG['LOB exists as deleted']= $lob_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['LOB opened'] = $lob_name." is Activated";
$ARR_MSG['LOB Edit error'] = "Another LOB exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['LOB delete error'] = "Sorry you can't delete this LOB. Alreday is Occupied by some resources.";
$ARR_MSG['LOB deleted'] = "LOB has been successfully deleted";


$ARR_MSG['Region addeded']="Region has been successfully addeded";
$ARR_MSG['Region updated']="Region has been successfully updated";
$ARR_MSG['Region exists']="Oops Sorry!!! Please see here this Region already exists!";
$ARR_MSG['Region exists as deleted']= $region_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['Region opened'] = $region_name." is Activated";
$ARR_MSG['Region Edit error'] = "Another Region exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Region delete error'] = "Sorry you can't delete this Region. Alreday is Occupied by some resources.";
$ARR_MSG['Region deleted'] = "Region has been successfully deleted";

$ARR_MSG['State addeded']="State has been successfully addeded";
$ARR_MSG['State updated']="State has been successfully updated";
$ARR_MSG['State exists']="Oops Sorry!!! Please see here this State already exists!";
$ARR_MSG['State exists as deleted']= $state_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['State opened'] = $state_name." is Activated";
$ARR_MSG['State Edit error'] = "Another State exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['State delete error'] = "Sorry you can't delete this State. Alreday is Occupied by some resources.";
$ARR_MSG['State deleted'] = "State has been successfully deleted";

$ARR_MSG['Designation addeded']="Designation has been successfully addeded";
$ARR_MSG['Designation updated']="Designation has been successfully updated";
$ARR_MSG['Designation exists']="Oops Sorry!!! Please see here this Designation already exists!";
$ARR_MSG['Designation exists as deleted']= $desig_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['Designation opened'] = $desig_name." is Activated";
$ARR_MSG['Designation Edit error'] = "Another Designation exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Designation delete error'] = "Sorry you can't delete this Designation. Alreday is Occupied by some resources.";
$ARR_MSG['Designation deleted'] = "Designation has been successfully deleted";

$ARR_MSG['Group addeded']="Group has been successfully addeded";
$ARR_MSG['Group updated']="Group has been successfully updated";
$ARR_MSG['Group exists']="Oops Sorry!!! Please see here this Group already exists!";
$ARR_MSG['Group exists as deleted']= $group_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['Group opened'] = $group_name." is Activated";
$ARR_MSG['Group Edit error'] = "Another Group exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Group delete error'] = "Sorry you can't delete this Group. Alreday is Occupied by some resources or Default Group.";
$ARR_MSG['Group deleted'] = "Group has been successfully deleted";

$ARR_MSG['Delay addeded']="Reason has been successfully addeded";
$ARR_MSG['Delay updated']="Reason has been successfully updated";
$ARR_MSG['Delay exists']="Oops Sorry!!! Please see here this Reason already exists!";
$ARR_MSG['Delay exists as deleted']= $delay_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['Delay opened'] = $delay_name." is Activated";
$ARR_MSG['Delay Edit error'] = "Another Delay Reaoson exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Delay delete error'] = "Sorry you can't delete this Reason. Alreday is Occupied by some resources.";
$ARR_MSG['Delay deleted'] = "Reason has been successfully deleted";

$ARR_MSG['Circle addeded']="Circle has been successfully addeded";
$ARR_MSG['Circle updated']="Circle has been successfully updated";
$ARR_MSG['Circle exists']="Oops Sorry!!! Please see here this Circle already exists!";
$ARR_MSG['Circle exists as deleted']= $circle_name." is already exist but you have close it!! Do you want to Open it again?";
$ARR_MSG['Circle opened'] = $circle_name." is Activated";
$ARR_MSG['Circle Edit error'] = "Another Circle exists By this Name. Please Choose any other name to edit!!";
$ARR_MSG['Circle delete error'] = "Sorry you can't delete this Circle. Alreday is Occupied by some resources.";
$ARR_MSG['Circle deleted'] = "Circle has been successfully deleted";

$ARR_MSG['Message addeded']="Message has been successfully addeded";
$ARR_MSG['Message updated']="Message has been successfully updated";
$ARR_MSG['Message exists']="Oops Sorry!!! Please see here this Message already Exists with given Subject!!";
$ARR_MSG['Message exists as deleted']= "A Message with this subject(".$subject.") is already exist but you have deleted it!! Do you want to put it on Message Board it again?";
$ARR_MSG['Message opened'] = "A Message with this subject(".$subject.") is Activated";
$ARR_MSG['Message Edit error'] = "Another Message exists By this Subject. Please Choose any other name to edit!!";
$ARR_MSG['fill all the fields'] = "Please fill the following astrick (*) mark fields";

$ARR_MSG['Message deleted'] = "Message has been successfully deleted";

$ARR_MSG['Status has been successfully addeded']="Status has been successfully addeded";
$ARR_MSG['Status has been successfully addeded']="Status has been successfully addeded";

$ARR_MSG['Permission has been successfully assigned']="Permission has been successfully assigned";


$ARR_MSG['Status has been successfully addeded']="Status has been successfully addeded";
$ARR_MSG['Status has been successfully updated']="Status has been successfully updated";

$ARR_MSG['Group has been successfully addeded']="Group has been successfully addeded";
$ARR_MSG['Group has been successfully updated']="Group has been successfully updated";


$ARR_MSG['Please Enter Version Number of file.']="Please Enter Version Number of file.";
$ARR_MSG['Please Enter a numeric Version Number of file.']="Please Enter a numeric Version Number of file.";
$ARR_MSG['Version Number should be greater that from Previous one.']="Version Number should be greater that from Previous one.";
$ARR_MSG['Please choose any file to upload.']="Please choose any file to upload.";
$ARR_MSG['Sorry!!!! File Couldn\'t be uploaded, Please try again.']="Sorry!!!! File Couldn't be uploaded, Please try again.";
$ARR_MSG['File Successfully Uploaded']="File Successfully Uploaded";
$ARR_MSG['Sorry!! Circle field in the file should be selected one.']="Sorry!! Circle field in the file should be selected one.";
$ARR_MSG['Sorry!! You can upload asset register for your circle only.']="Sorry!! You can upload asset register for your circle only.";


$ARR_MSG['Please Insert title of the Document']="Please Insert title of the Document";
$ARR_MSG['Please select any file to upload']="Please select any file to upload";
$ARR_MSG['File Successfully Uploaded']="File Successfully Uploaded";
$ARR_MSG['Please Enter title for Issue']="Please Enter title for Issue";
$ARR_MSG['Please Select some contacts from Address Book']="Please Select some contacts from Address Book";
$ARR_MSG['Please Select any date']="Please Select any date";
$ARR_MSG['Issue added successfully']="Issue added successfully";

$ARR_MSG['Mail sent Successfully']="Mail sent Successfully";
$ARR_MSG['Mail sent ERROR']="Sorry but the email could not be sent. Please try again!";
$ARR_MSG['not editable group']="This Group can't be edit or delete";

$ARR_MSG['Blank Search']="There is no keyword for Search";

$ARR_MSG['Response Send successfully']="Response Send successfully";



$ARR_MSG['Meeting Details Added Successfully']="Meeting Details Added Successfully";
$ARR_MSG['Sorry!!!! File Couldn\'t be uploaded, and Meeting details are not added Please try again.']="Sorry!!!! File Couldn\'t be uploaded, and Meeting details are not added Please try again.";
$ARR_MSG['Meeting Details Updated Successfully']="Meeting Details Updated Successfully";
$ARR_MSG['Meeting Details Deleted Successfully']="Meeting Details Deleted Successfully";

$ARR_MSG['Internal Audit Details Added Successfully']="Internal Audit Details Added Successfully";
$ARR_MSG['Internal Audit Details Updated Successfully']="Internal Audit Details Updated Successfully";
$ARR_MSG['Internal Audit Details Deleted Successfully']="Internal Audit Details Deleted Successfully";

$ARR_MSG['Surviellance Audit Details Added Successfully']="Surviellance Audit Details Added Successfully";
$ARR_MSG['Surviellance Audit Details Updated Successfully']="Surviellance Audit Details Updated Successfully";
$ARR_MSG['Surviellance Audit Details Deleted Successfully']="Surviellance Audit Details Deleted Successfully";

$ARR_MSG['Employee Details Saved Successfully']="Employee Details Saved for Circle Organization Structure";
$ARR_MSG['Employee Code Already has Assigned'] = 'Employee Code Already has Assigned either for Circle Organization or for PMO Organization';
$ARR_MSG['Details updated Successfully'] = "Details updated Successfully";
$ARR_MSG['Details deleted Successfully'] = "Details deleted Successfully";
$ARR_MSG['You can\'t edit a deleted record'] = "You can't edit a deleted record";
$ARR_MSG['This Record is already Deleted'] ="This Record is already Deleted";

$ARR_MSG['Employee PMO  Details Saved Successfully']="Employee Details Saved for PMO Organization Structure";
//$ARR_MSG['Milestone Exceeded']="You have added ".find_total_percentage_activity()." of activity, Now it is exceeding from 100%";


$ARR_MSG['Employee code already assigned.']="Employee code already assigned";


$ARR_MSG['Please Enter your Existing Password']="Please Enter your Existing Password";
$ARR_MSG['Please Enter your New Password']="Please Enter your New Password";
$ARR_MSG['Your Confirm Password does not match']="Your Confirm Password does not match";
$ARR_MSG['Password Successfully Changed']="Password Successfully Changed";
$ARR_MSG['Wrong Old password!!!']="Wrong Old password!!!";


$ARR_MSG['Deliverable Uploaded']="Your Deliverable Saved Successfully";
$ARR_MSG['Deliverable Upload Error']="There is some problem while saving deliverable, Please Try Again";
$ARR_MSG['Please select Deliverable']="Please select Deliverable Type";
$ARR_MSG['Please select Circle']="Please select Circle";

$ARR_MSG['RTP Deatails saved'] = "RTP Deatails Saved Successfully";
$ARR_MSG['RTP Details updated'] = "RTP Details Updated";
$ARR_MSG['Clause Number already assigned'] = "Clause Number already assigned";

$ARR_MSG['All Number fields should be Numeric']="All Number fields should be Numeric";
$ARR_MSG['Please Enter a valid Contact Number']="Contact Number should be a Mobile Number followed by country code";
$ARR_MSG['BSI Observation details saved successfully']="BSI Observation details saved successfully";
$ARR_MSG['BSI Observation details updated successfully']="BSI Observation details updated successfully";

$ARR_MSG['Internal Audit Observation added successfully']="Internal Audit Observation added successfully";
$ARR_MSG['NC Ref No Already Assigned']="NC Ref No Already Assigned ";
$ARR_MSG['Internal Audit Observation updated successfully']="Internal Audit Observation updated successfully ";

$ARR_MSG['admin delete error']= "This is the super admin, Can't be deleted";
$ARR_MSG['admin edit error']= "This is the super admin, Can't be edited";
$ARR_MSG['admin deactive error']= "This is the super admin, Can't be de-activate";
$ARR_MSG['self action error'] = "You can't edit,delete,activate,deactivate urself";
$ARR_MSG['Proper formate of Asset Register'] = "Please Upload a Proper formated Asset Register.";
$ARR_MSG['Please fill all required fields'] = "Please fill all required fields. Try Again.";
$ARR_MSG['Invalid Mobile Number']  = "Mobile number is not valid, Please try again with a valid mobile number.";
$ARR_MSG['All details saved successfully'] = "All details saved successfully";
$ARR_MSG['Please select deliverable type'] = "Please select any deliverable type to search";
?>