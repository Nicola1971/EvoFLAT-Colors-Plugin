<?php
/*
### ManagerColors Plugin for Evolution CMS 1.3 ###
Customize Default EVO Manager theme colors
Written By Nicola Lambathakis http://www.tattoocms.it/
Version 3.2 RC
Events: OnManagerLoginFormPrerender,OnManagerMainFrameHeaderHTMLBlock,OnManagerTopPrerender

Default configuration:
- 
&plgVisibility=Run for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Run only for this role:;string;;;(role id) &ThisUser=Run only for this user:;string;;;(username) &PrimaryColor=Main Theme Color:;string;#990000;;Theme Primary Color (mandatory) &NavBgColor= Top Nav Background color:;string;;;(optional) &NavLinkColor= Top Nav link color :;string;#e5eef5;;(optional) &NavLinkHColor= Top Nav link hover color:;string;#fff;;(optional) &NavDropBgHColor= Top Nav dropdown hover bg color:;string;;;(optional) &TLinkColor=Tree Menu Links Color:;string;;;Published resources and ElementsInTree element names (optional) &TDarkLinkColor=Dark Tree Menu Links Color:;string;;;Published resources and ElementsInTree element names (optional) &CustomNavStyle=Custom Navigation and Tree styles chunk:;string;;;chunk name &MainLinkColor=Main Links Color:;string;;;(optional) &CustomMainStyle=Custom Main Frame styles chunk:;string;;;chunk name  &LoginBgColor= Login Page Background color:;string;#499bea;;overwrite both dark and light backgrounds (optional) &LoginBgImage= Login Page Background image:;string;;;ie: ../assets/images/login/rainbow.jpg (optional) &coollogin=Semi-Transparent login form:;menu;yes,no;no;;Custom login form with alpha background &ShowLoginLogo=Show Login Logo:;menu;show,hide;show;;Hide EVO logo in login page &CustomLogoPath=Custom Logo path:;string;;;enter the url of your company logo &CustomLoginStyle=Custom Login styles chunk:;string;;;chunk name
*/
/**
events: OnManagerLoginFormPrerender,OnManagerMainFrameHeaderHTMLBlock,OnManagerTopPrerender
config:
-  

**/
$plgVisibility = isset($plgVisibility) ? $plgVisibility : 'All';

// get manager role
$internalKey = $modx->getLoginUserID();
$sid = $modx->sid;
$role = $_SESSION['mgrRole'];
$user = $_SESSION['mgrShortname'];
// show widget only to Admin role 1
if(($role!=1) AND ($plgVisibility == 'AdminOnly')) {}
// show widget to all manager users excluded Admin role 1
else if(($role==1) AND ($plgVisibility == 'AdminExcluded')) {}
// show widget only to "this" role id
else if(($role!=$ThisRole) AND ($plgVisibility == 'ThisRoleOnly')) {}
// show widget only to "this" username
else if(($user!=$ThisUser) AND ($plgVisibility == 'ThisUserOnly')) {}
else {

global $modx;
$output = "";
$e = &$modx->Event;

//Colors */
$PrimaryColor = isset($PrimaryColor) ? $PrimaryColor : '';
$TreeLinksC = isset($TreeLinksC) ? $TreeLinksC : '';
$LoginBgColor = isset($LoginBgColor) ? $LoginBgColor : '';
$LoginBgImage = isset($LoginBgImage) ? $LoginBgImage : '';
$NavBgColor = isset($NavBgColor) ? $NavBgColor : $PrimaryColor;
$NavDropBgHColor = isset($NavDropBgHColor) ? $NavDropBgHColor : $PrimaryColor;


/*****************login*************/
$sitename = $modx->getPlaceholder('site_name');
if($e->name == 'OnManagerLoginFormPrerender') {

if ($LoginBgColor !== '') {
$LoginBg = ' 
body{background-color: '.$LoginBgColor.';}
body.dark div.page{background-color: '.$LoginBgColor.';}
'; 
}
else {
$LoginBg = ' 
body{background-color: '.$MainBgColor.';}
body.dark div.page{background-color: '.$MainBgDarkColor.';}
';   
}
if ($LoginBgImage !== '') {
$LoginBgI = ' 
body{background: url("'.$LoginBgImage.'") no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;}
      
body.dark div.page{background: url("'.$LoginBgImage.'") no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;}
'; 
}
else {
$LoginBgI = '';
}
if ($CustomLogoPath !== '') {
$logocustom = '<a class="logo" href="../" title="'.$sitename.'">
					<img src="'.$CustomLogoPath.'" alt="'.$sitename.'" id="logocustom" />
				</a>';
}
if ($coollogin == 'yes') {
$coolloginFrm ='
.loginbox {
    color: #FFF;
    text-shadow:1px 1px 1px rgba(255, 255, 255, 0.4);
    background-color: rgba(255, 255, 255, 0.5)!important;}
    -moz-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.8);
    -webkit-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.8);
    box-shadow: 0px 3x 6px rgba(0, 0, 0, 0.8);
    }
#FMP-email_label { color: #FFF!important;}
.text-muted, #FMP-email_label { color: #fff !important; 
    text-shadow:1px 1px 1px rgba(0,0,0,0.8);}
#FMP-email_button, #submitButton {
	cursor: pointer;
	color: #FFF;
	padding: 8px 16px;
	margin:0 0 10px 10px;
    border-radius: 3px;
    width:100%;
}
#submitButton {
	padding: 8px 16px;
    border-radius: 3px;
    width:100%;
}
#FMP-email_button {
	border: 1px solid #499bea;
	background: #499bea;
}
   #FMP-email_button:hover {
	border: 1px solid #2683dd;
	background: #2683dd;
}
';


}
if ($ShowLoginLogo == 'hide') {
$logodisplay = 'img#logo {display:none;}';    
}

$logincssOutput = '
<!-----mancolor LoginFormPrerender--!>
<style>
'.$coolloginFrm.'
'.$LoginBg.'
'.$LoginBgI.'
'.$logodisplay.'
'.$animatedlogin.'
'.$modx->getChunk(''.$CustomLoginStyle.'').'

</style>
  '.$logocustom.'
<!----- end mancolor--!>  
';
}

/***************Top Frame (nav)  ******************/
if($e->name == 'OnManagerTopPrerender') {
//top frame - Nav bar

if (empty($TLinkColor)) {
$TreeLinksColor = $PrimaryColor;
}
else {
$TreeLinksColor = $TLinkColor;
    }
if (empty($TDarkLinkColor)) {
$DarkTreeLinksColor = $TreeLinksColor;
}
else {
$DarkTreeLinksColor = $TDarkLinkColor;
    }
if (empty($NavBgColor)) {
$mainMenuColor = $PrimaryColor;
}
else {
$mainMenuColor = $NavBgColor;
    }
$topcssOutput = '
<!-----mancolor TopPrerender--!>
<style>
html {
  --main-color: '.$PrimaryColor.'!important;
  --default-grey: #383f48;
  --medium-grey: #3c434e;
  --dark-grey: #272c33;
/* menu */
  --main-menu-color: '.$NavBgColor.'!important;
/* tree */
  --item-tree-color: '.$TreeLinksColor.';
  --dark-item-tree-color: #1792fd;
 }
</style>
<!-----end mancolor--!>
';

}
/***************Main frame******************/
if($e->name == 'OnManagerMainFrameHeaderHTMLBlock') {
if (empty($MainLinkColor)) {
$ALinksColor = $PrimaryColor;
}
else {
$ALinksColor = $MainLinkColor;
    }
//main frame - boxes and tabs
$maincssOutput = '
<!-----mancolor MainFrameHeaderHTMLBlock --!>
<style>
html {
  --main-color: '.$PrimaryColor.'!important;
  --default-grey: #383f48;
  --medium-grey: #3c434e;
  --dark-grey: #272c33;
/* menu */
  --main-menu-color: '.$PrimaryColor.'!important;
/* tree */
  --item-tree-color: '.$TreeLinksColor.';
  --dark-item-tree-color: '.$DarkTreeLinksColor.';
/* tabs */
  --selected-tabs-color:'.$PrimaryColor.'!important;
  --selected-tabs-txt-color: #fff;
  --dark-selected-tabs-color: '.$PrimaryColor.'!important;
  --dark-selected-tabs-txt-color: #fff; 
 }

'.$modx->getChunk(''.$CustomMainStyle.'').'
</style>
<!-----end mancolor--!>
';
}

$manager_theme = $modx->config['manager_theme'];
if($manager_theme == "EvoFLAT") {
$output .= $logincssOutput.$maincssOutput.$topcssOutput.$colorform;
}
$e->output($output);
return;
}
?>