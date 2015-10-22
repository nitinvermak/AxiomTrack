-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 22, 2015 at 09:45 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pordcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `paymentcheque`
--

CREATE TABLE IF NOT EXISTS `paymentcheque` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ChequeNo` varchar(100) NOT NULL,
  `ChequeDate` datetime NOT NULL,
  `Bank` varchar(100) NOT NULL,
  `DepositDate` datetime NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethoddetailsmaster`
--

CREATE TABLE IF NOT EXISTS `paymentmethoddetailsmaster` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `CashAmount` decimal(10,0) NOT NULL,
  `ChequeID` int(11) NOT NULL,
  `OnlineTransferId` int(11) NOT NULL,
  `RecivedDate` datetime NOT NULL,
  `Remarks` varchar(250) NOT NULL,
  `RecievedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`PaymentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `paymentonlinetransfer`
--

CREATE TABLE IF NOT EXISTS `paymentonlinetransfer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `RefNo` varchar(100) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `phpjobscheduler`
--

CREATE TABLE IF NOT EXISTS `phpjobscheduler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scriptpath` varchar(255) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `time_interval` int(11) DEFAULT NULL,
  `fire_time` int(11) NOT NULL DEFAULT '0',
  `time_last_fired` int(11) DEFAULT NULL,
  `run_only_once` tinyint(1) NOT NULL DEFAULT '0',
  `currently_running` tinyint(1) NOT NULL DEFAULT '0',
  `paused` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fire_time` (`fire_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `phpjobscheduler_logs`
--

CREATE TABLE IF NOT EXISTS `phpjobscheduler_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_added` int(11) DEFAULT NULL,
  `script` varchar(128) DEFAULT NULL,
  `output` text,
  `execution_time` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaccessories`
--

CREATE TABLE IF NOT EXISTS `tblaccessories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblassign`
--

CREATE TABLE IF NOT EXISTS `tblassign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `callingcategory_id` int(11) NOT NULL,
  `callingdata_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `telecaller_id` int(11) NOT NULL,
  `telecaller_assign_status` int(11) NOT NULL,
  `assign_by` int(50) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=410 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbranch`
--

CREATE TABLE IF NOT EXISTS `tblbranch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(250) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Country` int(11) NOT NULL,
  `District_ID` int(11) NOT NULL,
  `Area` int(11) NOT NULL,
  `city` int(100) DEFAULT NULL,
  `State` int(100) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `contact_Person` varchar(100) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `branchtype` int(11) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbranchtype`
--

CREATE TABLE IF NOT EXISTS `tblbranchtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Branchtype` varchar(100) DEFAULT NULL,
  `Branchdetails` varchar(500) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcallingcategory`
--

CREATE TABLE IF NOT EXISTS `tblcallingcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcallingdata`
--

CREATE TABLE IF NOT EXISTS `tblcallingdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(100) DEFAULT NULL,
  `Last_Name` varchar(100) DEFAULT NULL,
  `Company_Name` varchar(200) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Area` int(50) DEFAULT NULL,
  `City` int(50) DEFAULT NULL,
  `District_id` int(11) NOT NULL,
  `State` int(11) DEFAULT NULL,
  `Pin_code` int(10) DEFAULT NULL,
  `Country` int(50) DEFAULT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `Mobile` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `data_source` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `calling_status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=420 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcallingstatus`
--

CREATE TABLE IF NOT EXISTS `tblcallingstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcity`
--

CREATE TABLE IF NOT EXISTS `tblcity` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `Area` varchar(4000) DEFAULT NULL,
  `pincode` varchar(8) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7857 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblconveyance`
--

CREATE TABLE IF NOT EXISTS `tblconveyance` (
  `conveyanceId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketId` int(11) DEFAULT NULL,
  `kmTravelled` varchar(45) DEFAULT NULL,
  `fare` varchar(45) DEFAULT NULL,
  `totalAmt` decimal(10,5) DEFAULT NULL,
  PRIMARY KEY (`conveyanceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcountry`
--

CREATE TABLE IF NOT EXISTS `tblcountry` (
  `Country_id` int(11) NOT NULL AUTO_INCREMENT,
  `Country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`Country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldatasource`
--

CREATE TABLE IF NOT EXISTS `tbldatasource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datasource` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldealer`
--

CREATE TABLE IF NOT EXISTS `tbldealer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(15) NOT NULL,
  `Last_Name` varchar(15) NOT NULL,
  `Company_Name` varchar(50) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Area` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Pin_code` int(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Phone` int(50) NOT NULL,
  `Mobile` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pan_no` varchar(50) NOT NULL,
  `tin_no` varchar(50) NOT NULL,
  `servicestax` varchar(50) NOT NULL,
  `others` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldevicecompany`
--

CREATE TABLE IF NOT EXISTS `tbldevicecompany` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldeviceid`
--

CREATE TABLE IF NOT EXISTS `tbldeviceid` (
  `device_id` int(11) NOT NULL,
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbldevicemodel`
--

CREATE TABLE IF NOT EXISTS `tbldevicemodel` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(100) NOT NULL,
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldriverdetails`
--

CREATE TABLE IF NOT EXISTS `tbldriverdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aplnt_fname` varchar(100) NOT NULL,
  `aplnt_lname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `pob` date NOT NULL,
  `sex` varchar(100) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `fathername` varchar(100) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `mobile` int(11) NOT NULL,
  `p_address` varchar(100) NOT NULL,
  `p_country` varchar(100) NOT NULL,
  `p_state` varchar(100) NOT NULL,
  `p_city` varchar(100) NOT NULL,
  `p_contact_no` int(11) NOT NULL,
  `p_pincode` int(11) NOT NULL,
  `p_frm_stay` date NOT NULL,
  `p_to_stay` date NOT NULL,
  `p_nature_of_loc` varchar(100) NOT NULL,
  `c_address` varchar(100) NOT NULL,
  `c_country` varchar(100) NOT NULL,
  `c_state` varchar(100) NOT NULL,
  `c_city` varchar(100) NOT NULL,
  `c_pincode` int(11) NOT NULL,
  `c_phone` int(11) NOT NULL,
  `c_from_stay` date NOT NULL,
  `c_to_stay` date NOT NULL,
  `c_nature_of_loc` varchar(100) NOT NULL,
  `issue_state` varchar(100) NOT NULL,
  `licence_no` varchar(100) NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `type_of_licence` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblesitmateperiod`
--

CREATE TABLE IF NOT EXISTS `tblesitmateperiod` (
  `intervalId` int(11) NOT NULL AUTO_INCREMENT,
  `IntervelYear` varchar(100) NOT NULL,
  `Intervalname` varchar(100) NOT NULL,
  `FrequnceyID` int(11) NOT NULL,
  `GeneratedStatus` varchar(100) NOT NULL,
  `GeneratedDate` varchar(100) NOT NULL,
  PRIMARY KEY (`intervalId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblinstallmentmaster`
--

CREATE TABLE IF NOT EXISTS `tblinstallmentmaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VehicleId` int(11) NOT NULL,
  `Installmentamount` int(11) NOT NULL,
  `InstFrequencyID` int(11) NOT NULL,
  `PaidInstalments` decimal(10,0) NOT NULL,
  `NoOfInstallment` int(11) NOT NULL,
  `downpaymentAmount` decimal(10,0) NOT NULL,
  `activeFlag` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblinsurancecmpny`
--

CREATE TABLE IF NOT EXISTS `tblinsurancecmpny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblmodel`
--

CREATE TABLE IF NOT EXISTS `tblmodel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accessories_id` varchar(500) NOT NULL,
  `company_id` int(100) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `imei_no` varchar(100) NOT NULL,
  `date_of_purchase` date NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `price` int(10) NOT NULL,
  `status` int(11) NOT NULL,
  `assignstatus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1687 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblmodulename`
--

CREATE TABLE IF NOT EXISTS `tblmodulename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblnatureoflocation`
--

CREATE TABLE IF NOT EXISTS `tblnatureoflocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nature_of_loc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblopt_fuel`
--

CREATE TABLE IF NOT EXISTS `tblopt_fuel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblpaymentrecived`
--

CREATE TABLE IF NOT EXISTS `tblpaymentrecived` (
  `PReceivedId` int(11) NOT NULL,
  `CustId` int(11) NOT NULL,
  `PaymentMode` varchar(100) NOT NULL,
  `Amt` decimal(10,0) NOT NULL,
  `BankName` varchar(255) NOT NULL,
  `ChequeDate` datetime NOT NULL,
  `ChequeNo` varchar(200) NOT NULL,
  `ReceivedDate` datetime NOT NULL,
  `ConfirmBy` int(11) NOT NULL,
  `ConfirmDate` datetime NOT NULL,
  `ConfirmationStatus` varchar(10) NOT NULL,
  `ReceivedBy` int(11) NOT NULL,
  `Remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblperiod`
--

CREATE TABLE IF NOT EXISTS `tblperiod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblplan`
--

CREATE TABLE IF NOT EXISTS `tblplan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(50) NOT NULL,
  `plan_description` varchar(1000) NOT NULL,
  `productCategoryId` int(11) NOT NULL,
  `planSubCategory` int(11) NOT NULL,
  `serviceprovider_id` int(11) NOT NULL,
  `plan_status` varchar(2) NOT NULL,
  `plan_rate` double NOT NULL,
  `created` date NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblplancategory`
--

CREATE TABLE IF NOT EXISTS `tblplancategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblplansubcategory`
--

CREATE TABLE IF NOT EXISTS `tblplansubcategory` (
  `planSubid` int(11) NOT NULL AUTO_INCREMENT,
  `planCategoryId` int(11) DEFAULT NULL,
  `plansubCategory` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`planSubid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblrqsttype`
--

CREATE TABLE IF NOT EXISTS `tblrqsttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `rqsttype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblserviceprovider`
--

CREATE TABLE IF NOT EXISTS `tblserviceprovider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceprovider` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsim`
--

CREATE TABLE IF NOT EXISTS `tblsim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `sim_no` varchar(20) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `state_id` int(11) NOT NULL,
  `plan_categoryid` int(11) NOT NULL,
  `date_of_purchase` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `branch_assign_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2017 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsimplan`
--

CREATE TABLE IF NOT EXISTS `tblsimplan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceprovider_id` int(11) NOT NULL,
  `plan_name` decimal(10,0) NOT NULL,
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblstate`
--

CREATE TABLE IF NOT EXISTS `tblstate` (
  `State_id` int(11) NOT NULL AUTO_INCREMENT,
  `State_name` varchar(255) NOT NULL,
  `Country_id` int(11) NOT NULL,
  PRIMARY KEY (`State_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblstatus`
--

CREATE TABLE IF NOT EXISTS `tblstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticket`
--

CREATE TABLE IF NOT EXISTS `tblticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_remark` text NOT NULL,
  `organization_id` int(11) NOT NULL,
  `organization_type` varchar(20) NOT NULL,
  `product` int(200) NOT NULL,
  `rqst_type` int(200) NOT NULL,
  `device_model_id` int(11) NOT NULL,
  `no_of_installation` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `appointment_date` datetime NOT NULL,
  `createddate` datetime NOT NULL,
  `close_date` datetime NOT NULL,
  `branch_assign_status` int(11) NOT NULL,
  `ticket_status` int(11) NOT NULL,
  `scheduleDate` datetime NOT NULL,
  `ticketId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=215 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltypeofvechile`
--

CREATE TABLE IF NOT EXISTS `tbltypeofvechile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_vechile` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(15) DEFAULT NULL,
  `First_Name` varchar(100) DEFAULT NULL,
  `Last_Name` varchar(100) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Contact_No` varchar(10) DEFAULT NULL,
  `emailid` varchar(100) DEFAULT NULL,
  `DOJ` date DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Area` varchar(50) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `Pin_code` varchar(7) DEFAULT NULL,
  `User_ID` varchar(10) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `DOR` datetime DEFAULT NULL,
  `User_Status` varchar(2) DEFAULT NULL,
  `Created_date` date DEFAULT NULL,
  `Modified_date` date DEFAULT NULL,
  `CreatedBY` int(11) DEFAULT NULL,
  `ModifiedBY` int(11) DEFAULT NULL,
  `User_Category` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblusercategory`
--

CREATE TABLE IF NOT EXISTS `tblusercategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Category` varchar(50) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Status` varchar(2) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `Modified` date DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblusercategorymodulemapping`
--

CREATE TABLE IF NOT EXISTS `tblusercategorymodulemapping` (
  `moduleId` int(11) NOT NULL,
  `usercategoryId` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblvechilecategory`
--

CREATE TABLE IF NOT EXISTS `tblvechilecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vechilecategory` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblvechilemodel`
--

CREATE TABLE IF NOT EXISTS `tblvechilemodel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vechile_model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblvehile`
--

CREATE TABLE IF NOT EXISTS `tblvehile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_of_vechile` int(11) NOT NULL,
  `opt_fuel_type` int(11) NOT NULL,
  `date_of_instal` date NOT NULL,
  `Owner_type` varchar(100) NOT NULL,
  `Owner_name` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_of_mfg` date NOT NULL,
  `engine_cc` varchar(100) NOT NULL,
  `engine_no` varchar(100) NOT NULL,
  `chassis_no` varchar(100) NOT NULL,
  `hp` varchar(100) NOT NULL,
  `prvs_insuranc_c_id` int(11) NOT NULL,
  `policy_no` varchar(100) NOT NULL,
  `policy_issue_d` date NOT NULL,
  `policy_ex_d` date NOT NULL,
  `permit_regis_no` varchar(100) NOT NULL,
  `reg_issue_date` date NOT NULL,
  `reg_ex_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_area_new`
--

CREATE TABLE IF NOT EXISTS `tbl_area_new` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `Area_name` varchar(100) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=154823 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign_customer_branch`
--

CREATE TABLE IF NOT EXISTS `tbl_assign_customer_branch` (
  `cust_id` int(11) NOT NULL,
  `service_branchId` int(11) NOT NULL,
  `service_area_manager` int(11) NOT NULL,
  `service_executive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city_new`
--

CREATE TABLE IF NOT EXISTS `tbl_city_new` (
  `City_id` int(11) NOT NULL AUTO_INCREMENT,
  `District_ID` int(11) NOT NULL,
  `City_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`City_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9855 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_branch`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_branch` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `contact_Person` varchar(100) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_master`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_master` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `calling_product` varchar(100) NOT NULL,
  `device_model_id` int(11) NOT NULL,
  `customer_type` int(11) NOT NULL,
  `np_device_amt` decimal(10,0) NOT NULL,
  `np_device_rent` decimal(10,0) NOT NULL,
  `rent_payment_mode` int(100) NOT NULL,
  `instalment_frequency_Id` int(11) NOT NULL,
  `no_of_installment` int(11) NOT NULL,
  `r_installation_charge` varchar(100) NOT NULL,
  `installment_amt` decimal(10,0) NOT NULL,
  `telecaller_id` int(11) NOT NULL,
  `LeadGenBranchId` int(11) NOT NULL,
  `confirmation_date` date NOT NULL,
  `callingdata_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `NoOfInstallment` int(11) NOT NULL,
  `activeStatus` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`cust_id`),
  UNIQUE KEY `cust_id` (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=210 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_type`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type` varchar(200) NOT NULL,
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_assign_branch`
--

CREATE TABLE IF NOT EXISTS `tbl_device_assign_branch` (
  `device_id` varchar(11) NOT NULL,
  `branch_id` varchar(11) NOT NULL,
  `assign_by` varchar(50) NOT NULL,
  `branch_confirmation_status` int(1) NOT NULL,
  `technician_assign_status` int(11) NOT NULL,
  `assigned_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_assign_technician`
--

CREATE TABLE IF NOT EXISTS `tbl_device_assign_technician` (
  `device_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_master`
--

CREATE TABLE IF NOT EXISTS `tbl_device_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accessories_id` varchar(500) NOT NULL,
  `company_id` int(100) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `imei_no` varchar(100) NOT NULL,
  `date_of_purchase` varchar(50) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `price` int(10) NOT NULL,
  `status` int(11) NOT NULL,
  `assignstatus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2058 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_type`
--

CREATE TABLE IF NOT EXISTS `tbl_device_type` (
  `DeviceTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceType` varchar(20) NOT NULL,
  PRIMARY KEY (`DeviceTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE IF NOT EXISTS `tbl_district` (
  `District_id` int(11) NOT NULL AUTO_INCREMENT,
  `State_id` int(11) NOT NULL,
  `District_name` varchar(200) NOT NULL,
  PRIMARY KEY (`District_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=632 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_frequency`
--

CREATE TABLE IF NOT EXISTS `tbl_frequency` (
  `FrqId` int(11) NOT NULL AUTO_INCREMENT,
  `FrqDescription` varchar(20) NOT NULL,
  PRIMARY KEY (`FrqId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gps_vehicle_master`
--

CREATE TABLE IF NOT EXISTS `tbl_gps_vehicle_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_Id` varchar(100) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `customer_branch` varchar(100) NOT NULL,
  `vehicle_no` varchar(100) NOT NULL,
  `vehicle_odometer` varchar(100) NOT NULL,
  `techinician_name` int(11) NOT NULL,
  `mobile_no` varchar(100) NOT NULL,
  `device_id` int(11) NOT NULL,
  `imei_no` varchar(100) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `server_details` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `installation_date` date NOT NULL,
  `paymentActiveFlag` varchar(10) DEFAULT NULL,
  `activeStatus` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1312 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gps_vehicle_payment_master`
--

CREATE TABLE IF NOT EXISTS `tbl_gps_vehicle_payment_master` (
  `planId` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL,
  `instalmentId` int(11) NOT NULL,
  `Vehicle_id` int(11) NOT NULL,
  `device_type` varchar(100) NOT NULL,
  `device_amt` decimal(10,0) NOT NULL,
  `device_rent_amt` decimal(10,0) NOT NULL,
  `installation_charges` decimal(10,0) NOT NULL,
  `RentalFrequencyId` int(11) NOT NULL,
  `PlanStartDate` datetime NOT NULL,
  `PlanendDate` datetime NOT NULL,
  `PlanactiveFlag` varchar(10) NOT NULL,
  `oneTimePaymentFlag` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`planId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_master`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_master` (
  `invoiceId` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) NOT NULL,
  `intervalId` int(11) NOT NULL,
  `generatedAmount` int(11) NOT NULL,
  `taxId` int(11) NOT NULL,
  `discountedAmount` int(11) NOT NULL,
  `paidAmount` int(11) NOT NULL,
  `invoiceFlag` varchar(1) NOT NULL,
  `paymentStatusFlag` varchar(1) NOT NULL,
  PRIMARY KEY (`invoiceId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_breakage`
--

CREATE TABLE IF NOT EXISTS `tbl_payment_breakage` (
  `breakageId` int(11) NOT NULL AUTO_INCREMENT,
  `invoiceId` int(11) NOT NULL,
  `vehicleId` int(11) NOT NULL,
  `typeOfPaymentId` varchar(2) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`breakageId`),
  KEY `invoiceId` (`invoiceId`,`vehicleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pincode`
--

CREATE TABLE IF NOT EXISTS `tbl_pincode` (
  `pincode_id` int(11) NOT NULL AUTO_INCREMENT,
  `Area_id` int(11) NOT NULL,
  `Pincode` varchar(20) NOT NULL,
  PRIMARY KEY (`pincode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90926 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sim_branch_assign`
--

CREATE TABLE IF NOT EXISTS `tbl_sim_branch_assign` (
  `sim_id` int(11) NOT NULL,
  `branch_id` varchar(11) NOT NULL,
  `assign_by` varchar(50) NOT NULL,
  `branch_confirmation_status` int(11) NOT NULL,
  `technician_assign_status` int(11) NOT NULL,
  `assigned_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sim_technician_assign`
--

CREATE TABLE IF NOT EXISTS `tbl_sim_technician_assign` (
  `sim_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_telecalling_status`
--

CREATE TABLE IF NOT EXISTS `tbl_telecalling_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `callingdata_id` int(11) NOT NULL,
  `device_model_id` int(11) NOT NULL,
  `calling_status` varchar(100) NOT NULL,
  `customer_type` int(11) NOT NULL,
  `downpaymentAmount` decimal(10,0) NOT NULL,
  `telecaller_id` int(11) NOT NULL,
  `no_of_vehicles` varchar(100) NOT NULL,
  `np_device_amt` int(11) NOT NULL,
  `np_device_rent` int(11) NOT NULL,
  `rent_payment_mode` varchar(100) NOT NULL,
  `r_installation_charge` int(11) NOT NULL,
  `calling_date` date NOT NULL,
  `follow_up_date` date NOT NULL,
  `not_interested_resason` varchar(100) NOT NULL,
  `remark_not_interested` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_assign_branch`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_assign_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `assign_by` int(11) NOT NULL,
  `branch_confirmation_status` int(15) NOT NULL,
  `technician_assign_status` int(15) NOT NULL,
  `assign_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_assign_technician`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_assign_technician` (
  `ticket_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticket_close`
--

CREATE TABLE IF NOT EXISTS `tbl_ticket_close` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `ticket_remark` varchar(20) NOT NULL,
  `closing_date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userloginmaster`
--

CREATE TABLE IF NOT EXISTS `tbl_userloginmaster` (
  `userLoginId` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `userDetailId` int(11) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `passsword` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userLoginId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
