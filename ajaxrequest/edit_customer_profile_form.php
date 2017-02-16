<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");

$organization = mysql_real_escape_string($_POST['organization']);
$queryArr=mysql_query("SELECT A.id as callingdataid, A.First_Name as First_Name, 
                      A.Last_Name as Last_Name, A.Company_Name as Company_Name, 
                      A.Phone as phone, A.Mobile as mobile, A.email as email,
                      A.Country as Country, A.State as State, A.District_id as District_id, 
                      A.City as City, A.Area as Area, A.Pin_code as Pin_code, A.Address as Address, 
                      B.LeadGenBranchId as LeadGenBranchId, A.data_source as data_source, 
                      B.np_device_amt as np_device_amt, B.telecaller_id as telecaller_id,
                      B.np_device_rent as np_device_rent, 
                      B.r_installation_charge as r_installation_charge, 
                      B.rent_payment_mode as rent_payment_mode, B.customer_type as customer_type, 
                      B.cust_id as  cust_id, B.confirmation_date as confirmation_date
                      FROM tblcallingdata as A 
                      Inner Join tbl_customer_master as B 
                      On A.id = B.callingdata_id 
                      WHERE B.cust_id = ".$organization);
$result=mysql_fetch_assoc($queryArr);	
?>
<div class="col-md-12" id="dvMsg"></div>
<form name="contact" method="post" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='callingdata_id' id='callingdata_id' value="<?php echo $result['callingdataid']; ?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>First Name <i>*</i></span>
                      <input name="first_name" id="first_name" style="width: 100%" value="<?php echo $result['First_Name']; ?>" class="form-control" type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Last Name <i>*</i></span>
                      <input name="last_name" id="last_name" style="width: 100%"  value="<?php  echo $result['Last_Name']; ?>" class="form-control" type="text" /> 
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Company Name <i>*</i></span>
                      <input name="company" id="company" style="width: 100%"  value="<?php echo $result['Company_Name']; ?>"  class="form-control" type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Phone <i>*</i></span>
                      <input name="phone" id="phone" style="width: 100%"  value="<?php echo $result['phone']; ?>" class="form-control" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Mobile <i>*</i></span>
                      <input name="mobile" id="mobile" style="width: 100%"  value="<?php echo $result['mobile']; ?>" class="form-control" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Email <i>*</i></span>
                      <input name="email" id="email" style="width: 100%"  value="<?php echo $result['email']; ?>" class="form-control" type="text" /> 
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Country <i>*</i></span>
                      <select name="country" id="country" class="form-control drop_down select2" style="width: 100%" onChange="return CallState(this.value)">
                        <option value="">Select Country</option>
                        <?php $Country=mysql_query("select * from tblcountry");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>>
                        <?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <span id="Divstate">
                        <select id="state" class="form-control select2" style="width: 100%" onChange="return CallDistrict(this.value)">
                          <option value="">Select State</option>
                          <option value="<?php echo $result['State']; ?>" <?php if(isset($result['callingdataid']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>District <i>*</i></span>
                      <span id="divdistrict">
                        <select name="district" id="district" class="form-control drop_down select2" style="width: 100%" onChange="return CallCity(this.value)">
                          <option value="">Select District</option>
                          <option value="<?php echo $result['District_id']; ?>" <?php if(isset($result['callingdataid']) && $result['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_id']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>City <i>*</i></span>
                      <span id="divcity">
                        <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control select2" style="width: 100%" >
                          <option value="">Select City</option>
                          <option value="<?php echo $result['City']; ?>" <?php if(isset($result['callingdataid']) && $result['City']==$result['City']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['City']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Area <i>*</i></span>
                      <span id="divarea">
                        <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control select2" style="width: 100%">
                          <option value="">Select Area</option>
                           <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['callingdataid']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pincode <i>*</i></span>
                      <span id="divpincode">
                        <select name="pin_code" id="pin_code" class="form-control drop_down select2" style="width: 100%">
                          <option value="<?php echo $result['Pin_code']; ?>" ><?php if(isset($result['callingdataid'])) echo getpincode($result['Pin_code']); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Address <i>*</i></span>
                      <textarea id="Address" class="form-control " style="width: 100%"  name="Address" rows="2" ><?php echo $result['Address']; ?></textarea>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Branch <i>*</i></span>
                      <select name="branch" id="branch" class="form-control select2" style="width: 100%" >
                        <option value="">Select Branch</option>
                        <?php $Country=mysql_query("select * from tblbranch");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['callingdataid']) && $resultCountry['id']==$result['LeadGenBranchId']){ ?>selected<?php } ?>><?php echo getBranch(stripslashes(ucfirst($resultCountry['id']))); ?></option>
                          <?php } ?>    
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Telecaller Name <i>*</i></span>
                      <select name="telecaller" id="telecaller" class="form-control select2" style="width: 100%" >
                        <?php $Country=mysql_query("select * from tbluser");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['callingdataid']) && $resultCountry['id']==$result['telecaller_id']){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['id']))); ?></option>
                        <?php } ?>    
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Data Source <i>*</i></span>
                      <input type="text" name="datasource" style="width: 100%"  id="datasource" class="form-control"  value="<?php if(isset($result['callingdataid'])) echo $result['data_source']; ?>" />
                    </div> <!-- end custom_form -->
                    
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Device Amt.<i>*</i></span>
                      <select name="deviceAmt" id="deviceAmt" class="form-control select2" style="width: 100%">
                        <option value="">Device Amount</option>
                        <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1 order by plan_rate");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Rent Amt.<i>*</i></span>
                      <select name="deviceRent" id="deviceRent" class="form-control drop_down select2" style="width: 100%" >
                        <option value="">Device Rent</option>
                        <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2 order by plan_rate");           
                          while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Installation Charges<i>*</i></span>
                      <select name="installationChrg" id="installationChrg" class="form-control drop_down select2" style="width: 100%" >
                        <option value="">Installation Charges</option>
                        <?php $Country=mysql_query("select * from tblplan 
                                                    where productCategoryId = 4 
                                                    and planSubCategory = 3 
                                                    order by plan_rate");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Rent Frq.<i>*</i></span>
                      <select name="rentFrq" id="rentFrq" class="form-control drop_down select2" style="width: 100%" >
                        <option value="">Rent Frequency</option>
                        <?php $Country=mysql_query("select * from tbl_frequency");            
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['rent_payment_mode']) && $resultCountry['FrqId']==$result['rent_payment_mode']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Customer Type<i>*</i></span>
                      <select name="customerType" id="customerType" class="form-control select2" style="width: 100%" onChange="customerType()">
                        <option value="">Select</option>
                        <?php $Country=mysql_query("select * from tbl_customer_type");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type']) && $resultCountry['customer_type_id']==$result['customer_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Calling Date<i>*</i></span>
                      <input name="callingdate" id="callingdate" style="width: 100%"  class="form-control date" type="text" value="<?php if(isset($result['callingdataid'])) echo $result['confirmation_date']; ?>" />
                    </div> <!-- end custom_form -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type='button' name='save' class="btn btn-primary btn-sm" onclick="Update_CustomerDetails();" value="Submit"/>
                      <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>             
                      <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
                      onclick="window.location='manage_customer_payment_profile.php?token=<?php echo $token ?>'"/>
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>