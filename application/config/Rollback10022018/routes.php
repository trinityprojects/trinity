<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*
$route['default_controller'] = 'triuneAuth/loginView';
$route['auth/login'] = 'triuneAuth/loginControl';
$route['auth/register'] = 'triuneAuth/registrationView';
$route['auth/checkUser'] = 'triuneAuth/checkUserName';
$route['auth/create'] = 'triuneAuth/createToken';
$route['auth/forgot'] = 'triuneAuth/forgotPassword';
$route['auth/hello'] = 'triuneAuth/index';
$route['main'] = 'triuneAuth/mainView';
$route['main/jobRequest'] = 'triuneMain/jobRequest';
$route['bamjrs/create'] = 'triuneJRS/BAMCreateRequest';
$route['bamjrs/getCreateConfirmation'] = 'triuneJRS/BAMCreateRequestConfirmation';
$route['bamjrs/getCreatedRequest'] = 'triuneJRS/BAMCreatedRequest';
$route['bamjrs/getMyRequestList'] = 'triuneJRS/BAMMyRequestList';
$route['bamjrs/getNewRequestList'] = 'triuneJRS/BAMNewRequestList';
$route['bamjrs/getNewRequestVerification'] = 'triuneJRS/BAMNewRequestVerification';

$route['main/humanResource'] = 'triuneHRIS/HRISView';


$route['getLocationCode'] = 'triuneData/getLocationCode'; 
$route['getFloor'] = 'triuneData/getFloor'; 
$route['getRoomNumber'] = 'triuneData/getRoomNumber'; 
$route['getBAMJRSMyRequestList'] = 'triuneData/getBAMJRSMyRequestList'; 
$route['getBAMJRSRequestList'] = 'triuneData/getBAMJRSRequestList'; 

$route['setRequestBAM'] = 'triuneData/setRequestBAM'; 
$route['updateRequestBAM'] = 'triuneData/updateBAMRequestStatus'; 
$route['insertRequestBAM'] = 'triuneData/insertRequestBAM'; 

$route['uploadFile'] = 'triuneFile/uploadFile'; 
*/
$route['default_controller'] = 'trinityAuth/signInView';
$route['user-acct/sign-in'] = 'trinityAuth/signInView';
$route['user-acct/sign-up'] = 'trinityAuth/signUpView';
$route['user-acct/check-user'] = 'trinityAuth/checkUserName';
$route['user-acct/create-account'] = 'trinityAuth/createAccount';
$route['user-acct/forgot-password'] = 'trinityAuth/forgotPassword';
$route['user-acct/sign-up-success'] = 'trinityAuth/signUpSuccess';
$route['user-acct/sign-in-process'] = 'trinityAuth/loginControl';
$route['logout'] = 'trinityAuth/signInView';
$route['user-acct/consentformstudent'] = 'trinityAuth/consentFormStudent';
$route['user-acct/consentformemployee'] = 'trinityAuth/consentFormEmployee';




$route['main'] = 'trinityMain/mainView';
$route['Building/building'] = 'trinityMain/sideMenu';

$route['TBAMIMS/requestCreate'] = 'trinityBuilding/tBAMIMSCreateRequest';
$route['TBAMIMS/setCreateRequestConfirmation'] = 'trinityBuilding/tBAMIMSCreateRequestConfirmation';
$route['TBAMIMS/showCreatedRequest'] = 'trinityBuilding/tBAMIMSCreatedRequest';
$route['TBAMIMS/myRequest'] = 'trinityBuilding/tBAMIMSMyRequestList';
$route['TBAMIMS/showNewRequestVerification'] = 'trinityBuilding/tBAMIMSRequestVerification';
$route['TBAMIMS/allRequest'] = 'trinityBuilding/tBAMIMSAllRequestList';


$route['TBAMIMS/newRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/openRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/approvedRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/estimatedRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/setRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/wIPRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/returnedRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/closedRequest'] = 'trinityBuilding/tBAMIMSRequestList';
$route['TBAMIMS/completedRequest'] = 'trinityBuilding/tBAMIMSRequestList';

$route['TBAMIMS/showMaterialsList'] = 'trinityBuilding/tBAMIMSMaterialsList';
$route['TBAMIMS/showRequestStatusList'] = 'trinityBuilding/tBAMIMSRequestStatuList';
$route['TBAMIMS/showUploadedFiles'] = 'trinityBuilding/tBAMIMSShowUploadedFiles';
$route['TBAMIMS/deleteUploadedFiles'] = 'trinityBuilding/tBAMIMSDeleteUploadedFiles';

$route['TBAMIMS/showWorkerList'] = 'trinityBuilding/tBAMIMSWorkerList';
$route['TBAMIMS/showJobOrderTBAMIMS'] = 'trinityBuilding/tBAMIMSJobOrder';
$route['TBAMIMS/showJobOrderEvaluation'] = 'trinityBuilding/tBAMIMSJobOrderEvaluation';
$route['TBAMIMS/jobOrderQueue'] = 'trinityBuilding/tBAMIMSJobOrderList';
$route['TBAMIMS/showJobOrderDetails'] = 'trinityBuilding/tBAMIMSJobOrderDetails';

$route['TBAMIMS/location'] = 'trinityBuilding/tBAMIMSLocationList';
$route['TBAMIMS/rooms'] = 'trinityBuilding/tBAMIMSRoomsList';


$route['getLocationCodeTBAMIMS'] = 'trinityDataBuilding/getLocationCodeTBAMIMS'; 
$route['getFloorTBAMIMS'] = 'trinityDataBuilding/getFloorTBAMIMS'; 
$route['getRoomNumberTBAMIMS'] = 'trinityDataBuilding/getRoomNumberTBAMIMS'; 
$route['validateRequestTBAMIMS'] = 'trinityDataBuilding/validateRequestTBAMIMS'; 
$route['insertRequestTBAMIMS'] = 'trinityDataBuilding/insertRequestTBAMIMS'; 
$route['getMyRequestListTBAMIMS'] = 'trinityDataBuilding/getMyRequestListTBAMIMS'; 
$route['getRequestListTBAMIMS'] = 'trinityDataBuilding/getRequestListTBAMIMS'; 
$route['insertMaterialsTBAMIMS'] = 'trinityDataBuilding/insertMaterialsTBAMIMS'; 
$route['updateRequestTBAMIMS'] = 'trinityDataBuilding/updateRequestTBAMIMS'; 
$route['insertJobOrderTBAMIMS'] = 'trinityDataBuilding/insertJobOrderTBAMIMS'; 
$route['getAllJobOrderListTBAMIMS'] = 'trinityDataBuilding/getAllJobOrderListTBAMIMS'; 
$route['getAllRequestListTBAMIMS'] = 'trinityDataBuilding/getAllRequestListTBAMIMS'; 
$route['closeRequestTBAMIMS'] = 'trinityDataBuilding/closeRequestTBAMIMS'; 
$route['returnRequestTBAMIMS'] = 'trinityDataBuilding/returnRequestTBAMIMS'; 
$route['updateRequestMultipleStatusTBAMIMS'] = 'trinityDataBuilding/updateRequestMultipleStatusTBAMIMS'; 
$route['insertLocationTBAMIMS'] = 'trinityDataBuilding/insertLocationTBAMIMS'; 
$route['updateLocationTBAMIMS'] = 'trinityDataBuilding/updateLocationTBAMIMS'; 
$route['insertRoomsTBAMIMS'] = 'trinityDataBuilding/insertRoomsTBAMIMS'; 
$route['updateRoomTBAMIMS'] = 'trinityDataBuilding/updateRoomTBAMIMS'; 
$route['updateJobOrderTBAMIMS'] = 'trinityDataBuilding/updateJobOrderTBAMIMS'; 




$route['uploadFileTBAMIMS'] = 'trinityFileBuilding/uploadFileTBAMIMS'; 
$route['uploadFile'] = 'trinityFile/uploadFile'; 


$route['updateRequestBAM'] = 'triuneData/updateBAMRequestStatus'; 



$route['InfoTech/infotech'] = 'trinityMain/sideMenu';
$route['ICTJRS/requestCreate'] = 'trinityInfoTech/iCTJRSCreateRequest';
$route['ICTJRS/setCreateRequestConfirmation'] = 'trinityInfoTech/iCTJRSCreateRequestConfirmation';
$route['ICTJRS/showCreatedRequest'] = 'trinityInfoTech/iCTJRSCreatedRequest';
$route['ICTJRS/completedRequest'] = 'trinityInfoTech/completedRequest';



$route['validateRequestICTJRS'] = 'trinityDataInfoTech/validateRequestICTJRS'; 
$route['insertRequestICTJRS'] = 'trinityDataInfoTech/insertRequestICTJRS'; 







$route['QUEUESYS/customerQueue'] = 'trinityInfoTechQueueSys/queueSysCreateCustomerQueue';
//$route['customerQueue'] = 'trinityInfoTechQueueSys/queueSysCreateCustomerQueue';


$route['QUEUESYS/showCreatedQueueNumber'] = 'trinityInfoTechQueueSys/queueSysCreatedQueueNumber';
$route['showCreatedQueueNumber'] = 'trinityInfoTechQueueSys/queueSysCreatedQueueNumber';


$route['QUEUESYS/serverOperator'] = 'trinityInfoTechQueueSys/queueSysServerOperator';
$route['QUEUESYS/displayCurrentQueue'] = 'trinityInfoTechQueueSys/displayCurrentQueueQueueSys'; 
$route['QUEUESYS/viewerQueue'] = 'trinityInfoTechQueueSys/queueSysViewQueueQueueSys'; 
$route['QUEUESYS/notifyOperator'] = 'trinityInfoTechQueueSys/queueSysNotifyOperator';
$route['QUEUESYS/operatorQueue'] = 'trinityInfoTechQueueSys/queueSysONotifyOperatorQueueSys'; 



$route['setCustomerNumberQUEUESYS'] = 'trinityDataInfoTechQueueSys/insertCustomerNumberQueueSys'; 
$route['QUEUESYS/setCustomerNumberQUEUESYS'] = 'trinityDataInfoTechQueueSys/insertCustomerNumberQueueSys'; 


$route['callCustomerNumberQUEUESYS'] = 'trinityDataInfoTechQueueSys/callCustomerNumberQueueSys'; 
$route['finishQueueNumberQUEUESYS'] = 'trinityDataInfoTechQueueSys/finishQueueNumberQueueSys'; 
$route['viewViewerQueue'] = 'trinityDataInfoTechQueueSys/viewViewerQueueQueueSys';
$route['updateStatusViewerQueue'] = 'trinityDataInfoTechQueueSys/updateStatusViewerQueueQueueSys';
$route['notifyOperatorQUEUESYS'] = 'trinityDataInfoTechQueueSys/notifyOperatorQueueSys'; 
$route['viewNotifyOperatorQueue'] = 'trinityDataInfoTechQueueSys/viewNotifyOperatorQueueQueueSys';
$route['updateStatusViewerQueueOperator'] = 'trinityDataInfoTechQueueSys/updateStatusViewerQueueQueueSysOperator';



$route['QUEUESYS/viewViewerQueue'] = 'trinityDataInfoTechQueueSys/viewViewerQueueQueueSys';
$route['QUEUESYS/updateStatusViewerQueue'] = 'trinityDataInfoTechQueueSys/updateStatusViewerQueueQueueSys';

$route['QUEUESYS/viewNotifyOperatorQueue'] = 'trinityDataInfoTechQueueSys/viewNotifyOperatorQueueQueueSys';
$route['QUEUESYS/updateStatusViewerQueueOperator'] = 'trinityDataInfoTechQueueSys/updateStatusViewerQueueQueueSysOperator';



$route['test/pdf'] = 'triuneMain/viewPDF';

$route['Purchasing/purchasing'] = 'trinityMain/sideMenu';
$route['ASRS/requestCreate'] = 'trinityPurchasing/aSRSCreateRequest';
$route['ASRS/setCreateRequestConfirmation'] = 'trinityPurchasing/aSRSCreateRequestConfirmation';
$route['ASRS/showCreatedRequest'] = 'trinityPurchasing/aSRSCreatedRequest';
$route['ASRS/showUploadedFiles'] = 'trinityPurchasing/aSRSShowUploadedFiles';
$route['ASRS/deleteUploadedFiles'] = 'trinityPurchasing/aSRSDeleteUploadedFiles';
$route['ASRS/myRequest'] = 'trinityPurchasing/aSRSMyRequestList';
$route['ASRS/showRequestItemsASRS'] = 'trinityPurchasing/aSRSRequestItems';
$route['ASRS/showRequestDetails'] = 'trinityPurchasing/aSRSRequestDetails';
$route['ASRS/showSupplierNames'] = 'trinityPurchasing/aSRSSupplierNames';
$route['ASRS/showBiddingPreparation'] = 'trinityPurchasing/aSRSBiddingPreparation';
$route['ASRS/showPBACMember'] = 'trinityPurchasing/showPBACMember';


$route['ASRS/newRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/unitApprovalRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/submittedlRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/unitReviewRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/estimatedRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/inProgressRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/returnedRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/completedRequest'] = 'trinityPurchasing/aSRSRequestList';
$route['ASRS/closedRequest'] = 'trinityPurchasing/aSRSRequestList';


$route['validateRequestASRS'] = 'trinityDataPurchasing/validateRequestASRS'; 
$route['insertRequestASRS'] = 'trinityDataPurchasing/insertRequestASRS'; 
$route['insertRequestItemsASRS'] = 'trinityDataPurchasing/insertRequestItemsASRS'; 
$route['validateRequestItemsASRS'] = 'trinityDataPurchasing/validateRequestItemsASRS'; 
$route['deleteRequestItemsASRS'] = 'trinityDataPurchasing/deleteRequestItemsASRS'; 
$route['getRequestListASRS'] = 'trinityDataPurchasing/getRequestListASRS'; 
$route['getMyRequestListASRS'] = 'trinityDataPurchasing/getMyRequestListASRS'; 
$route['updateRequestASRS'] = 'trinityDataPurchasing/updateRequestASRS'; 
$route['validateSupplierNameASRS'] = 'trinityDataPurchasing/validateSupplierNameASRS'; 
$route['insertSupplierNameASRS'] = 'trinityDataPurchasing/insertSupplierNameASRS'; 
$route['deleteSupplierNamesASRS'] = 'trinityDataPurchasing/deleteSupplierNamesASRS'; 
$route['validatePBACMemberASRS'] = 'trinityDataPurchasing/validatePBACMemberASRS'; 
$route['insertPBACMemberASRS'] = 'trinityDataPurchasing/insertPBACMemberASRS'; 
$route['deletePBACMemberASRS'] = 'trinityDataPurchasing/deletePBACMemberASRS'; 



$route['getSupplyUnits'] = 'trinityDataReference/getSupplyUnits'; 
$route['getAssetGroup'] = 'trinityDataReference/getAssetGroup'; 
$route['getSuppliers'] = 'trinityDataReference/getSuppliers'; 
$route['getOrgUnit'] = 'trinityDataReference/getOrgUnit'; 
$route['getRequestType'] = 'trinityDataReference/getRequestType'; 
$route['getDepartmentK12'] = 'trinityDataReference/getDepartmentK12'; 
$route['getFacultyListK12'] = 'trinityDataReference/getFacultyListK12'; 
$route['getEmployeeDesignation'] = 'trinityDataReference/getEmployeeDesignation'; 
$route['getCourseInformationLevelActiveK12'] = 'trinityDataReference/getCourseInformationLevelActiveK12'; 
$route['getGradeComponentReferenceK12'] = 'trinityDataReference/getGradeComponentReferenceK12'; 
$route['getSubjectComponentSH'] = 'trinityDataReference/getSubjectComponentSH'; 
$route['getSubjectComponentK12'] = 'trinityDataReference/getSubjectComponentK12'; 
$route['getCurriculumCoursesREGISTRAR'] = 'trinityDataReference/getCurriculumCoursesREGISTRAR'; 
$route['getCurriculumYearREGISTRAR'] = 'trinityDataReference/getCurriculumYearREGISTRAR'; 
$route['getCurriculumDetailsREGISTRAR'] = 'trinityDataReference/getCurriculumDetailsREGISTRAR'; 
$route['getPrefixNameTHRIMS'] = 'trinityDataReference/getPrefixNameTHRIMS'; 
$route['getGenderTHRIMS'] = 'trinityDataReference/getGenderTHRIMS'; 
$route['getCivilStatusTHRIMS'] = 'trinityDataReference/getCivilStatusTHRIMS'; 
$route['getBloodTypeTHRIMS'] = 'trinityDataReference/getBloodTypeTHRIMS'; 
$route['getReligionTHRIMS'] = 'trinityDataReference/getReligionTHRIMS'; 
$route['getCitizenshipTHRIMS'] = 'trinityDataReference/getCitizenshipTHRIMS'; 
$route['getBarangayTHRIMS'] = 'trinityDataReference/getBarangayTHRIMS'; 
$route['getTownTHRIMS'] = 'trinityDataReference/getTownTHRIMS'; 
$route['getCityTHRIMS'] = 'trinityDataReference/getCityTHRIMS'; 
$route['getBirthPlaceTHRIMS'] = 'trinityDataReference/getBirthPlaceTHRIMS'; 
$route['getCountry'] = 'trinityDataReference/getCountry'; 
$route['getProvincialBarangayTHRIMS'] = 'trinityDataReference/getProvincialBarangayTHRIMS'; 
$route['getProvincialTownTHRIMS'] = 'trinityDataReference/getProvincialTownTHRIMS'; 
$route['getProvincialCityTHRIMS'] = 'trinityDataReference/getProvincialCityTHRIMS'; 
$route['getJobTitleTHRIMS'] = 'trinityDataReference/getJobTitleTHRIMS'; 
$route['getEmployeeDepartmentTHRIMS'] = 'trinityDataReference/getEmployeeDepartmentTHRIMS'; 
$route['getPositionClassTHRIMS'] = 'trinityDataReference/getPositionClassTHRIMS'; 
$route['getJobStatusTHRIMS'] = 'trinityDataReference/getJobStatusTHRIMS'; 
$route['getReportsListEmployeeTHRIMS'] = 'trinityDataReference/getReportsListEmployeeTHRIMS'; 
$route['getEmployeeListTHRIMS'] = 'trinityDataReference/getEmployeeListTHRIMS'; 
$route['getGender'] = 'trinityDataReference/getGender'; 
$route['getLocationTBAMIMS'] = 'trinityDataReference/getLocationTBAMIMS'; 
$route['getLocationTypeTBAMIMS'] = 'trinityDataReference/getLocationTypeTBAMIMS'; 
$route['getRoomTypeTBAMIMS'] = 'trinityDataReference/getRoomTypeTBAMIMS'; 
$route['getRoomsTBAMIMS'] = 'trinityDataReference/getRoomsTBAMIMS'; 



$route['K12/k12'] = 'trinityMain/sideMenu';



$route['EGIS/officerSetup'] = 'trinityEGIS/officerSetupEGIS';
$route['EGIS/facultyAssignment'] = 'trinityEGIS/facultyAssignmentEGIS';
$route['EGIS/transmutationTable'] = 'trinityEGIS/transmutationTableEGIS';
$route['EGIS/scoreSheet'] = 'trinityEGIS/scoreSheetEGIS';
$route['EGIS/showScoreScheetDetails'] = 'trinityEGIS/showScoreScheetDetailsEGIS';
$route['EGIS/adviserAssignment'] = 'trinityEGIS/adviserAssignmentEGIS';
$route['EGIS/gradeComponent'] = 'trinityEGIS/gradeComponentEGIS';
$route['EGIS/subjectDepartment'] = 'trinityEGIS/subjectDepartmentEGIS';
$route['EGIS/gradeDescriptor'] = 'trinityEGIS/gradeDescriptorEGIS';
$route['EGIS/scoreSheetJH'] = 'trinityEGIS/scoreSheetJHEGIS';
$route['EGIS/scoreSheetSH'] = 'trinityEGIS/scoreSheetSHEGIS';
$route['EGIS/showScoreScheetSHDetails'] = 'trinityEGIS/showScoreScheetSHDetailsEGIS';
$route['EGIS/showSubjectGradesSummaryEGIS'] = 'trinityEGIS/showSubjectGradesSummaryEGIS';
$route['EGIS/attendance'] = 'trinityEGIS/attendanceEGIS';
$route['EGIS/schoolDays'] = 'trinityEGIS/schoolDaysEGIS';
$route['EGIS/traits'] = 'trinityEGIS/traitsEGIS';
$route['EGIS/gradesRequest'] = 'trinityEGIS/gradesRequestEGIS';
$route['EGIS/classCard'] = 'trinityEGIS/classCardEGIS';
$route['EGIS/showClassCardDetails'] = 'trinityEGIS/showClassCardDetailsEGIS';
$route['EGIS/allowGradesRequest'] = 'trinityEGIS/allowGradesRequestEGIS';
$route['EGIS/unpostGrades'] = 'trinityEGIS/unpostGradesEGIS';
$route['EGIS/ranking'] = 'trinityEGIS/rankingEGIS';
$route['EGIS/showRankingBySectionEGIS'] = 'trinityEGIS/showRankingBySectionEGIS';
$route['EGIS/showRankingByYearLevelEGIS'] = 'trinityEGIS/showRankingByYearLevelEGIS';


$route['getOfficersEGIS'] = 'trinityDataEGIS/getOfficersEGIS'; 
$route['insertOfficerRecordsEGIS'] = 'trinityDataEGIS/insertOfficerRecordsEGIS'; 
$route['deleteOfficerRecordsEGIS'] = 'trinityDataEGIS/deleteOfficerRecordsEGIS'; 
$route['getSectionElementaryEGIS'] = 'trinityDataEGIS/getSectionElementaryEGIS'; 
$route['updateSectionElementaryEGIS'] = 'trinityDataEGIS/updateSectionElementaryEGIS'; 
$route['getSectionJuniorHighEGIS'] = 'trinityDataEGIS/getSectionJuniorHighEGIS'; 
$route['updateSectionJuniorHighEGIS'] = 'trinityDataEGIS/updateSectionJuniorHighEGIS'; 
$route['getMyElementarySectionsEGIS'] = 'trinityDataEGIS/getMyElementarySectionsEGIS'; 
$route['getMySectionScoreSheet1EGIS'] = 'trinityDataEGIS/getMySectionScoreSheet1EGIS'; 
$route['updateScoreSheetFirstGradingEGIS'] = 'trinityDataEGIS/updateScoreSheetFirstGradingEGIS'; 
$route['getMySectionScoreSheet2EGIS'] = 'trinityDataEGIS/getMySectionScoreSheet2EGIS'; 
$route['updateScoreSheetSecondGradingEGIS'] = 'trinityDataEGIS/updateScoreSheetSecondGradingEGIS'; 
$route['getTransmutationEGIS'] = 'trinityDataEGIS/getTransmutationEGIS'; 
$route['insertTrasmutationEGIS'] = 'trinityDataEGIS/insertTrasmutationEGIS'; 
$route['updateTrasmutationEGIS'] = 'trinityDataEGIS/updateTrasmutationEGIS'; 
$route['getAssignedAdvisersEGIS'] = 'trinityDataEGIS/getAssignedAdvisersEGIS'; 
$route['updateAdviserAssignmentEGIS'] = 'trinityDataEGIS/updateAdviserAssignmentEGIS'; 
$route['getGradeComponentEGIS'] = 'trinityDataEGIS/getGradeComponentEGIS'; 
$route['insertGradeComponentEGIS'] = 'trinityDataEGIS/insertGradeComponentEGIS'; 
$route['deleteGradeComponentEGIS'] = 'trinityDataEGIS/deleteGradeComponentEGIS'; 
$route['updateGradingComponentEGIS'] = 'trinityDataEGIS/updateGradingComponentEGIS'; 
$route['getSubjectElementaryEGIS'] = 'trinityDataEGIS/getSubjectElementaryEGIS'; 
$route['updateSubjectDepartmentEGIS'] = 'trinityDataEGIS/updateSubjectDepartmentEGIS'; 
$route['getSubjectJuniorHighEGIS'] = 'trinityDataEGIS/getSubjectJuniorHighEGIS'; 
$route['updateSubjectDepartmentJHEGIS'] = 'trinityDataEGIS/updateSubjectDepartmentJHEGIS'; 
$route['getGradeDescriptorEGIS'] = 'trinityDataEGIS/getGradeDescriptorEGIS'; 
$route['insertGradeDescriptorEGIS'] = 'trinityDataEGIS/insertGradeDescriptorEGIS'; 
$route['updateGradeDescriptorEGIS'] = 'trinityDataEGIS/updateGradeDescriptorEGIS'; 
$route['deleteGradeDescriptorEGIS'] = 'trinityDataEGIS/deleteGradeDescriptorEGIS'; 
$route['deleteTrasmutationEGIS'] = 'trinityDataEGIS/deleteTrasmutationEGIS'; 
$route['getSectionSeniorHighSemAEGIS'] = 'trinityDataEGIS/getSectionSeniorHighSemAEGIS'; 
$route['getSectionSeniorHighSemBEGIS'] = 'trinityDataEGIS/getSectionSeniorHighSemBEGIS'; 
$route['updateSectionSeniorHighEGIS'] = 'trinityDataEGIS/updateSectionSeniorHighEGIS'; 
$route['getGradeComponentSHEGIS'] = 'trinityDataEGIS/getGradeComponentSHEGIS'; 
$route['insertGradeComponentSHEGIS'] = 'trinityDataEGIS/insertGradeComponentSHEGIS'; 
$route['deleteGradeComponentSHEGIS'] = 'trinityDataEGIS/deleteGradeComponentSHEGIS'; 
$route['updateGradingComponentSHEGIS'] = 'trinityDataEGIS/updateGradingComponentSHEGIS'; 
$route['getSubjectSeniorHighEGIS'] = 'trinityDataEGIS/getSubjectSeniorHighEGIS'; 
$route['updateSubjectComponentSHEGIS'] = 'trinityDataEGIS/updateSubjectComponentSHEGIS'; 
$route['getMyJuniorHighSectionsEGIS'] = 'trinityDataEGIS/getMyJuniorHighSectionsEGIS'; 
$route['getMySeniorHighSectionsEGIS'] = 'trinityDataEGIS/getMySeniorHighSectionsEGIS'; 
$route['getMySectionScoreSheet1EGISExcel'] = 'trinityDataEGIS/getMySectionScoreSheet1EGISExcel'; 
$route['updateScoreSheet1EGISExcel'] = 'trinityDataEGIS/updateScoreSheet1EGISExcel'; 
$route['getMySectionScoreSheet1TitleEGISExcel'] = 'trinityDataEGIS/getMySectionScoreSheet1TitleEGISExcel'; 
$route['updateScoreSheet1TitleEGISExcel'] = 'trinityDataEGIS/updateScoreSheet1TitleEGISExcel'; 
$route['getAttendanceSectionEGIS'] = 'trinityDataEGIS/getAttendanceSectionEGIS'; 
$route['getSchoolDaysEGISExcel'] = 'trinityDataEGIS/getSchoolDaysEGISExcel'; 
$route['updateSchoolDaysEGISExcel'] = 'trinityDataEGIS/updateSchoolDaysEGISExcel'; 
$route['getMyAdviseeScoreSheet1AttendanceEGISExcel'] = 'trinityDataEGIS/getMyAdviseeScoreSheet1AttendanceEGISExcel'; 
$route['updateScoreSheet1AttendanceEGISExcel'] = 'trinityDataEGIS/updateScoreSheet1AttendanceEGISExcel'; 
$route['getTraitsSetupEGISExcel'] = 'trinityDataEGIS/getTraitsSetupEGISExcel'; 
$route['getMyAdviseeScoreSheet1TraitsEGISExcel'] = 'trinityDataEGIS/getMyAdviseeScoreSheet1TraitsEGISExcel'; 
$route['updateScoreSheet1TraitsEGISExcel'] = 'trinityDataEGIS/updateScoreSheet1TraitsEGISExcel'; 
$route['postSubjectGradesSummaryEGIS'] = 'trinityDataEGIS/postSubjectGradesSummaryEGIS';
$route['getMySectionScoreSheet1StatusEGISExcel'] = 'trinityDataEGIS/getMySectionScoreSheet1StatusEGISExcel';
$route['getStudentSubjectsEGIS'] = 'trinityDataEGIS/getStudentSubjectsEGIS';
$route['processGradesRequestEGIS'] = 'trinityDataEGIS/processGradesRequestEGIS';
$route['getEnrolledK12StudentsEGIS'] = 'trinityDataEGIS/getEnrolledK12StudentsEGIS';
$route['getGradesRequestFlagEGIS'] = 'trinityDataEGIS/getGradesRequestFlagEGIS';
$route['updateAllowStatusEGIS'] = 'trinityDataEGIS/updateAllowStatusEGIS';
$route['getGradesPostingEGIS'] = 'trinityDataEGIS/getGradesPostingEGIS';
$route['updateGradesPostingsEGIS'] = 'trinityDataEGIS/updateGradesPostingsEGIS';
$route['getYearLevelEGIS'] = 'trinityDataEGIS/getYearLevelEGIS';


$route['K12Records/sectioning'] = 'trinityK12Records/sectioningK12Records';
$route['K12Records/showStudentsListSH'] = 'trinityK12Records/showStudentsListSHK12Records';
$route['K12Records/showStudentsListJH'] = 'trinityK12Records/showStudentsListJHK12Records';


$route['getSeniorHighCourseListK12Records'] = 'trinityDataK12Records/getSeniorHighCourseListK12Records'; 
$route['getSeniorHighStudentsListK12Records'] = 'trinityDataK12Records/getSeniorHighStudentsListK12Records'; 
$route['getSectionByCourseSHK12Records'] = 'trinityDataK12Records/getSectionByCourseSHK12Records'; 
$route['updateSectioningSeniorHighK12Records'] = 'trinityDataK12Records/updateSectioningSeniorHighK12Records'; 

$route['getJuniorHighCourseListK12Records'] = 'trinityDataK12Records/getJuniorHighCourseListK12Records'; 
$route['getJuniorHighStudentsListK12Records'] = 'trinityDataK12Records/getJuniorHighStudentsListK12Records'; 
$route['updateSectioningJuniorHighK12Records'] = 'trinityDataK12Records/updateSectioningJuniorHighK12Records'; 
$route['getSectionByLevelJHK12Records'] = 'trinityDataK12Records/getSectionByLevelJHK12Records'; 


$route['Term/term'] = 'trinityMain/modalForm';
$route['updateSessionTerm'] = 'trinityMain/setSessionTerm';



$route['HR/hr'] = 'trinityMain/sideMenu';
$route['THRIMS/employeeProfile'] = 'trinityTHRIMS/employeeProfileTHRIMS';
$route['THRIMS/showEmployeeProfileDetails'] = 'trinityTHRIMS/showEmployeeProfileDetailsTHRIMS';
$route['THRIMS/employeeRecords'] = 'trinityTHRIMS/showEmployeeRecordsTHRIMS';
$route['THRIMS/showReportsDetails'] = 'trinityTHRIMS/showReportsDetailsTHRIMS';
$route['THRIMS/gender'] = 'trinityTHRIMS/showGenderTHRIMS';



$route['getAllEmployeeListTHRIMS'] = 'trinityDataTHRIMS/getAllEmployeeListTHRIMS'; 
$route['updateRecordTHRIMS'] = 'trinityDataTHRIMS/updateRecordTHRIMS'; 
$route['insertEmployeeCareerAssignmentsTHRIMS'] = 'trinityDataTHRIMS/insertEmployeeCareerAssignmentsTHRIMS'; 
$route['getEmploymentCareerAssignmentsTHRIMS'] = 'trinityDataTHRIMS/getEmploymentCareerAssignmentsTHRIMS'; 
$route['deleteEmployeeCareerAssignmentsTHRIMS'] = 'trinityDataTHRIMS/deleteEmployeeCareerAssignmentsTHRIMS'; 
$route['updateEmployeeCareerAssignmentsTHRIMS'] = 'trinityDataTHRIMS/updateEmployeeCareerAssignmentsTHRIMS'; 
$route['insertChildrenTHRIMS'] = 'trinityDataTHRIMS/insertChildrenTHRIMS'; 
$route['deleteChildrenTHRIMS'] = 'trinityDataTHRIMS/deleteChildrenTHRIMS'; 
$route['updateChildrenTHRIMS'] = 'trinityDataTHRIMS/updateChildrenTHRIMS'; 
$route['getChildrenTHRIMS'] = 'trinityDataTHRIMS/getChildrenTHRIMS'; 
$route['insertGenderTHRIMS'] = 'trinityDataTHRIMS/insertGenderTHRIMS'; 
$route['updateGenderTHRIMS'] = 'trinityDataTHRIMS/updateGenderTHRIMS'; 
$route['deleteGenderTHRIMS'] = 'trinityDataTHRIMS/deleteGenderTHRIMS'; 



$route['REGISTRAR/registrar'] = 'trinityMain/sideMenu';
$route['REGISTRAR/curriculumSetup'] = 'trinityREGISTRAR/curriculumSetupREGISTRAR';
$route['REGSISTRAR/showCurriculumDetails'] = 'trinityREGISTRAR/showCurriculumDetailsREGISTRAR';
$route['REGISTRAR/studentList'] = 'trinityREGISTRAR/studentListREGISTRAR';

$route['getAllStudentsListREGISTRAR'] = 'trinityDataRegistrar/getAllStudentListREGISTRAR'; 



$route['StudentPortal/studentPortal'] = 'trinityMain/sideMenu';


$route['Privileges/privileges'] = 'trinityMain/sideMenu';





$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


