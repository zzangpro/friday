<?
ob_start();

/**
* @ author		WEB2WEB
* @ date		12.07.04
* @ version		1.0.0
**/

###########################################################################
###								PHP ini 설정							###
###########################################################################
error_reporting (E_ALL & ~(E_STRICT|E_NOTICE));
ini_set ('display_errors', 'On');
@ini_set("session.use_trans_sid", 0);														# PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");															# 링크에 PHPSESSID가 따라다니는것을 무력화함
@ini_set("session.cookie_domain", "ppnewstoday.co.kr");
extract($_POST);
extract($_GET);
#define("OFFICE_IP",					"");												# 사무실 IP
#if($_SERVER['REMOTE_ADDR'] != OFFICE_IP) ini_set ('display_errors', 'Off');				# 에러 표시

###########################################################################
###								기본선언								###
###########################################################################
define("_WEB2WEB_", TRUE);
define("DIR_DOCROOT",				$_SERVER['DOCUMENT_ROOT']);								# 웹 루트(크론시 $_SERVER['DOCUMENT_ROOT']의 미확인 때문)
define("DIR_ROOT",					dirname(DIR_DOCROOT.'.php'));							# 서버 루트
define("WEB_ROOT",					'/');													# 웹 루트
define("DIR_INCLUDE",				DIR_ROOT.'/include/');									# 인클루드파일 경로
define("DIR_LIBRARIES",				DIR_INCLUDE.'libraries/');								# 라이브러리 파일 경로
define("DIR_MODELS",				DIR_INCLUDE.'models/');									# 모델 파일 경로
define("DIR_HELPERS",				DIR_INCLUDE.'helpers/');								# 헬퍼 파일 경로
define("DIR_CONFIG",				DIR_INCLUDE.'config/');									# 설정 파일 경로
define("DIR_FONTS",					DIR_INCLUDE.'fonts/');									# 폰트 파일 경로
define("DIR_FILE",					dirname($_SERVER['SCRIPT_NAME']));						# 현재파일의 폴더명
define("DIR_KEYNAME",				basename(DIR_FILE,'.php'));								# 스킨, 모듈 폴더명
define("DIR_SKINROOT",				DIR_DOCROOT.'/skin/');									# 스킨ROOT 경로
define("DIR_SKINLAYOUT",			DIR_DOCROOT.'/skin/layout/');							# 스킨 layout 경로

//define("DIR_ENG_SKINROOT",			DIR_DOCROOT.'/eng/skin/');								# 영문 스킨ROOT 경로
//define("DIR_ENG_SKINLAYOUT",		DIR_DOCROOT.'/eng/skin/layout/');						# 영문 스킨 layout 경로

define("DIR_MASTER_SKINROOT",		DIR_DOCROOT.'/master/skin/');							# 관리자 스킨ROOT 경로
define("DIR_MASTER_SKINLAYOUT",		DIR_DOCROOT.'/master/skin/layout/');					# 관리자 스킨 layout 경로
define("WEB_DIR_ADMIN",				WEB_ROOT.'master/');									# 웹 관리자 경로
define("DIR_SKIN_BOARD",			DIR_SKINROOT.'board/');									# 게시판 스킨
define("DIR_SKIN",					DIR_DOCROOT.'/skin/main/'.DIR_KEYNAME.'/');				# 스킨파일 경로
define("DIR_ENG_SKIN",				DIR_DOCROOT.'/eng/skin/main/'.DIR_KEYNAME.'/');			# 영문 스킨파일 경로
define("DIR_SKIN_MASTER",			DIR_DOCROOT.'/skin/master/');							# ADMIN 스킨파일 경로
define("DIR_MODULE",				DIR_DOCROOT.'/module/'.DIR_KEYNAME.'/');				# 모듈파일 경로
define("DIR_DATA",					DIR_DOCROOT.'/data/');									# 업로드 파일경로
define("WEBDIR_DATA",				'/data/');												# 업로드 파일경로
define("DIR_ENG_INC",				DIR_DOCROOT.'/eng/inc/');								# html 인클루드 경로
define("DIR_INC",					DIR_DOCROOT.'/inc/');									# html 인클루드 경로
define("DIR_ADMIN",					DIR_DOCROOT.'/master/');								# 관리자 경로
define("DIR_EDITOR_File",			DIR_DOCROOT.'/FileData/ckfinder/');						# Editor 첨부파일 경로
define("DIR_PG_INICIS",				DIR_ROOT.'/pay/inicis');								# 이니시스(PG) 경로

/*
define("PG_MID",					"INIpayTest");
define("PG_KEY",					"SU5JTElURV9UUklQTEVERVNfS0VZU1RS");
define("PG_JS",						'https://stdpay.inicis.com/stdjs/INIStdPay.js');		# 이니시스 스크립트
*/

define("PG_MID",					"INIpayTest");
define("PG_KEY",					"SU5JTElURV9UUklQTEVERVNfS0VZU1RS");
define("PG_JS",						'https://stgstdpay.inicis.com/stdjs/INIStdPay.js');		# 이니시스 스크립트

define('URL', $_SERVER['HTTP_HOST']);
define('HTTP', 'http://'.URL);

define('FILE_URL',					WEB_ROOT . "FileData");
define('FILE_PATH',					DIR_DOCROOT . "/FileData");

define('NAVER_OAUTH_CALLBAK',		HTTP."/inc/naver/return.php");
define('KAKAO_OAUTH_CALLBACK',		HTTP."/inc/kakao/return.php");
define('GOOGLE_OAUTH_LOGIN',		HTTP."/inc/google/login.php");
define('GOOGLE_OAUTH_CALLBACK',		HTTP."/inc/google/return.php");


##피디언정보
define('Pedien_Host',				'210.127.209.108');
define('Pedien_ID',					'pediennews');
define('Pedien_PW',					'pedien@12#$');
define('Pedien_DB',					'pediennews');
define('Pedien_Port',				'3306');

##(자기)계정정보
define('FTP_IP',					'210.127.209.108');
define('FTP_ID',					'kor3pedien');
define('FTP_PW',					'210111!@#');
define('FTP_PORT',					'5001');

define('DB_IP',						'210.127.209.108');
define('DB_ID',						'kor3pedien');
define('DB_PW',						'210111!@#');
define('DB_NAME',					'kor3pedien');
define('DB_PORT',					'3306');

session_save_path(DIR_DOCROOT."/data/session");
session_start();

###########################################################################
###			PHPSESSID 일치 하지 않으면 세션 종료						###
###########################################################################

if(isset($_COOKIE['PHPSESSID'])){
	if($_COOKIE['PHPSESSID'] != session_id()){
		session_destroy();
		/* 현재 디렉토리의 다른 페이지로 리다이렉트 */
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'index.php';
		header("Location: http:#$host$uri/$extra");
		exit;
	}
}




###########################################################################
###							기본 인클루드								###
###########################################################################
include_once DIR_INCLUDE.'config.php';														# 각 변수 설정
include_once DIR_INCLUDE.'db_config.php';													# DB 설정
include_once DIR_HELPERS.'common.php';														# 공통 함수

$LB_Db['main'] = loadLibrary('database');													# DB 로드
$LB_Db['main']->connectDb($SITEINFO['database'], 'main');									# 자체 DB 연결


$MD_System = loadModel('system', $LB_Db['main']);											# SYSTEM 로드
$MD_Master = loadModel('master', $LB_Db['main']);											# MASTER 로드
$MD_Member = loadModel('member', $LB_Db['main']);											# MEMBER 로드
$MD_Board = loadModel('board', $LB_Db['main']);												# BOARD 로드
$MD_NEWS = loadModel('news', $LB_Db['main']);												#
$MD_DESIGN = loadModel('design', $LB_Db['main']);											#
?>