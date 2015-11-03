<?php 

/*
Default Configuration file for Hydroserver-WebClient-PHP
Edit at your own risk
This file provides configuration for the database, for the default options on various pages.
Developed by : GIS LAB - CAES - ISU

Further Edits made at BYU

This file will be populated while deployment
*/

//MySql Database Configuration Settings

define("DATABASE_HOST", "worldwater.byu.edu"); //for example define("DATABASE_HOST", "your_database_host");
define("DATABASE_USERNAME", "WWO_Admin"); //for example define("DATABASE_USERNAME", "your_database_username");
define("DATABASE_NAME", "climate");  //for example define("DATABASE_NAME", "your_database_name");
define("DATABASE_PASSWORD", "isaiah4118"); //for example define("DATABASE_PASSWORD", "your_database_password");


//Cookie Settings - This is for Security!
$www = "worldwater.byu.edu"; // Please change this to your websites domain name. You may also use "localhost" for testing purposes on a local server.

//Default Variables for add_site.php
$default_datum="Unknown";
$default_spatial="Unknown";
$default_source="Brigham Young University";
$lang="en";

//Establish default values for MOSS data variables when adding a data value to a site(add_data_value.php)
$UTCOffset = "-7"; 
$UTCOffset2 = "7"; // Actually it is -7
$CensorCode ="nc";
$QualityControlLevelID = "0";
$ValueAccuracy ="NULL"; 
$OffsetValue ="NULL";
$OffsetTypeID ="NULL";
$QualifierID ="1";
$SampleID ="NULL";
$DerivedFromID ="NULL";

//Establish default values for new MOSS site when adding a new site to the database (add_site.php)
$LocalX ="NULL";
$LocalY ="NULL";
$LocalProjectionID ="NULL";
$PosAccuracy_m ="NULL";

//Establish default values for Variable Code when adding a new variable (add_variable.php)
$default_varcode="CMIP5"; //for example, for MOSS, it is IDCS- or IDCS-(somethinghere)-Avg


//Establish default values for source info when adding a new source to the database (add_source.php)
$ProfileVersion = "Unknown"; 

//Name of your blog/Website homepage..(This affects the "Back to home button"
$homename="BYU";

//Link of your blog/Website homepage..(This affects the "Back to home button"
$homelink="worldwater.byu.edu";

//Name of your organization
$orgname="Brigham Young University";

//Name of your software version
$HSLversion="Version 2.0";

if(file_exists("../snotel/headerConfig.php"))
{
	include("../snotel/headerConfig.php");
}

//Type of Installation Being Run!
$singleInstall = "No"; //Please Specify either "Yes" or "No". By default this is set to "Yes" unless this is an install on worldwater servers. 
