<?php

use App\Http\Controllers\SGOperativeController;

Route::get('/', function () {
  return view('auth.login');
})->middleware('guest');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test_bj', function () {
  return view('test');
})->name('test');

// <span><a href="#" title="DESCRIPCION DE AYUDA"><i class="fas fa-question-circle"></i></a></span>


/*-----------------------------------------
MODULES ADMINISTRATIVE'S ROUTES
------------------------------------------*/

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/password', 'ProfileController@changePassword')->name('changePassword');

Route::post('/profile/garden/new', 'GardenController@newGarden')->name('garden.new')->middleware('role:ADMINISTRADOR|ADMINISTRADOR JARDIN|ADMINISTRADOR SISTEMA');
Route::post('/profile/garden/save', 'GardenController@updateGarden')->name('garden.update')->middleware('role:ADMINISTRADOR|ADMINISTRADOR JARDIN|ADMINISTRADOR SISTEMA');

Route::get('/registerAdmission', 'AdmissionmoduleController@registerTo')->name('registerAdmission');
Route::post('/saveauthAdmission', 'AdmissionmoduleController@registerAdmission')->name('saveauthAdmission');

Route::get('/aprovedAdmission', 'AdmissionmoduleController@aprovedTo')->name('aprovedAdmission');
Route::post('/updateAdmission', 'AdmissionmoduleController@updateAdmission')->name('updateAdmission');
Route::post('/saveaprovedAdmission', 'AdmissionmoduleController@saveaprovedAdmission')->name('saveaprovedAdmission');
Route::post('/deleteAdmission', 'AdmissionmoduleController@deleteAdmission')->name('deleteAdmission');

Route::get('/Admission', 'AdmissionmoduleController@filesTo')->name('filesAdmission');
Route::get('/filesAdmission', 'AdmissionmoduleController@filesTofiles')->name('admissionFiles');
Route::get('/filesAdmission/serderside', 'AdmissionmoduleController@filesServerSide')->name('serverSide');
Route::post('/migrationAdmission', 'AdmissionmoduleController@migrationAdmission')->name('migrationAdmission');
Route::post('/pdfAdmission', 'AdmissionmoduleController@pdfAdmission')->name('pdfAdmission');

Route::get('/formulario', 'AdmissionguestController@registerTo')->name('registerGuest');
Route::post('/saveAdmission', 'AdmissionguestController@saveAdmission')->name('saveAdmission');
Route::get('/listDocuments', 'AdmissionguestController@listDocumentsPdf')->name('list.documents.pdf');

//RUTAS DEL MODULO LOGISTICO
Route::group(['middleware' => ['role:ADMINISTRADOR|ADMINISTRADOR SISTEMA|ADMINISTRADOR JARDIN|LOGISTICO']], function () {

  //REGISTRO DE ASISTENCIAS
  Route::get('/logistic/assist-control/check-in', 'AssistancesController@checkinAssistences')->name('assistences.check-in');
  Route::post('/logistic/assist-control/check-in/save', 'AssistancesController@savecheckinAssistences')->name('check-in.save');
  Route::get('/logistic/assist-control/check-out', 'AssistancesController@checkoutAssistences')->name('assistences.check-out');
  Route::post('/logistic/assist-control/check-out/save', 'AssistancesController@savecheckoutAssistences')->name('check-out.save');
  Route::get('/logistic/assist-control/register', 'AssistancesController@registerAssistences')->name('assistences.register');
  Route::get('/logistic/assist-control/registerAssistencesIndex','AssistancesController@registerAssistencesIndex')->name('getAsistences');
  Route::post('/logistic/assist-control/pdf-assist', 'AssistancesController@pdfAssistences')->name('pdf.Assistences');
  Route::get('/logistic/assist-control/absence', 'AssistancesController@absenceAssistences')->name('assistences.absence');
  Route::post('/logistic/assist-control/pdf-absences', 'AssistancesController@pdfAbsences')->name('pdf.Absences');
  Route::post('/logistic/assist-control/email', 'AssistancesController@EmailAssitences')->name('MailSend');
  Route::get('/logistic/assist-control/graphics', 'AssistancesController@graphicsAssistences')->name('assistences.graphics');
  // rutas antiguas
  Route::get('/logistic/newsletters/assistances', 'AssistancesController@assistancesTo')->name('assistances');
  Route::get('/logistic/newsletters/assistances/get', 'AssistancesController@getAssistances')->name('assistances.get');
  Route::post('/logistic/newsletters/assistances/new', 'AssistancesController@newAssistances')->name('assistances.new');
  Route::post('/logistic/newsletters/assistances/save', 'AssistancesController@saveFinalAssistance')->name('assistances.final');
  Route::get('/logistic/newsletters/assistances/pdf', 'AssistancesController@pdfAssistances')->name('assistances.pdf');

  // MENU >> CRECIMIENTO Y DESARROLLO

  // PROFESIONALES DE LA SALUD
  Route::get('/logistic/increase/professionalsHealth', 'IncreaseController@professionalHealthTo')->name('professionalHealth');
  Route::post('/logistic/increase/professionalsHealth/save', 'IncreaseController@saveProfessionalhealth')->name('professionalHealth.save');
  Route::post('/logistic/increase/professionalsHealth/update', 'IncreaseController@updateProfessionalhealth')->name('professionalHealth.update');
  Route::post('/logistic/increase/professionalsHealth/delete', 'IncreaseController@deleteProfessionalhealth')->name('professionalHealth.delete');
  // OBSERVACIONES DE LA SALUD
  Route::get('/logistic/increase/observationsHealth', 'IncreaseController@observationHealthTo')->name('observationsHealth');
  Route::post('/logistic/increase/observationsHealth/save', 'IncreaseController@saveObservationhealth')->name('observationHealth.save');
  Route::post('/logistic/increase/observationsHealth/update', 'IncreaseController@updateObservationhealth')->name('observationHealth.update');
  Route::post('/logistic/increase/observationsHealth/delete', 'IncreaseController@deleteObservationhealth')->name('observationHealth.delete');
  // ESQUEMA DE VACUNACIONES
  Route::get('/logistic/increase/vaccination', 'IncreaseController@vaccinationTo')->name('vaccination');
  Route::post('/logistic/increase/vaccination/save', 'IncreaseController@saveVaccination')->name('vaccination.save');
  Route::post('/logistic/increase/vaccination/update', 'IncreaseController@updateVaccination')->name('vaccination.update');
  Route::post('/logistic/increase/vaccination/delete', 'IncreaseController@deleteVaccination')->name('vaccination.delete');
  // VALORACION PERIODICA
  Route::get('/logistic/increase/rating', 'IncreaseController@ratingsTo')->name('ratinPeriod');
  Route::post('/logistic/increase/rating/save', 'IncreaseController@newRatings')->name('ratingPeriod.new');
  Route::post('/logistic/increase/rating/update', 'IncreaseController@editRatings')->name('ratingPeriod.update');
  Route::post('/logistic/increase/rating/delete', 'IncreaseController@deleteRatings')->name('ratingPeriod.delete');
  Route::get('/logistic/increase/rating/pdf', 'IncreaseController@pdfRatings')->name('ratingPeriod.pdf');
  // ESTADISTICA
  Route::get('/logistic/increase/increaseStatistic', 'IncreaseController@statisticIncreaseTo')->name('increase.statistic');
  Route::get('/logistic/increase/rating/grafic', 'IncreaseController@graficRating')->name('rating.grafic');


  // AUTORIZACIONES ADICIONALES
  Route::get('/logistic/newsletters/additionals', 'AdditionalsController@additionalTo')->name('additionals');
  Route::post('/logistic/newsletters/additionals/new', 'AdditionalsController@newAdditional')->name('additional.new');

  // CONTROL DE ALIMENTACION
  Route::get('/logistic/newsletters/feedingscontrol', 'NewscontrolsController@feedingsControlTo')->name('feedings.control');
  Route::post('/logistic/newsletters/feedingscontrol/new', 'NewscontrolsController@newFeedings')->name('feedings.new');

  // CONTROL DE ESFINTERES
  Route::get('/logistic/newsletters/sphinctersControl', 'NewscontrolsController@sphinctersControlTo')->name('sphincters');
  Route::post('/logistic/newsletters/sphinctersControl/new', 'NewscontrolsController@newSphincters')->name('sphincters.new');

  // CONTROL DE ENFERMERIA
  Route::get('/logistic/newsletters/healthsControl', 'NewscontrolsController@healthsControlTo')->name('health.control');
  Route::post('/logistic/newsletters/healthsControl/new', 'NewscontrolsController@newHealths')->name('health.newControl');

  // CONTROL DE ENFERMERIA
  Route::get('/logistic/newsletters/reportDaily', 'NewscontrolsController@reportdailyTo')->name('reportDaily');
  Route::get('/logistic/newsletters/reportDaily/pdf', 'NewscontrolsController@reportdailyPdf')->name('reportDaily.pdf');

  // PROGRAMACION DE EVENTOS

  //CREACION - EVENTOS
  Route::get('/logistic/events/creation', 'EventsController@creationTo')->name('creation');
  Route::post('/logistic/events/creation/save', 'EventsController@creationSave')->name('creation.save');
  Route::post('/logistic/events/creation/update', 'EventsController@creationUpdate')->name('creation.update');
  Route::post('/logistic/events/creation/delete', 'EventsController@creationDelete')->name('creation.delete');

  // AGENDAMIENTO - EVENTOS
  Route::get('/logistic/events/diary', 'EventsController@diaryTo')->name('diary');
  Route::post('/logistic/events/diary/save', 'EventsController@diarySave')->name('diary.save');
  Route::post('/logistic/events/diary/update', 'EventsController@diaryUpdate')->name('diary.update');
  Route::post('/logistic/events/diary/delete', 'EventsController@diaryDelete')->name('diary.delete');

  // SEGUIMIENTO - EVENTOS
  Route::get('/logistic/events/follow', 'EventsController@followTo')->name('follow');
  Route::post('/logistic/events/follow/change', 'EventsController@followChange')->name('follow.change');
  Route::post('/logistic/events/follow/stop', 'EventsController@followStop')->name('follow.stop');

  // ESTADISTICA - EVENTOS
  Route::get('/logistic/events/grafic', 'StatisticsController@statisticEventsTo')->name('grafic');
  Route::get('/logistic/events/grafic/refresh', 'StatisticsController@getRefreshEvents')->name('grafic.refresh');

  // CUERPOS DE CIRCULARES
  Route::get('/logistic/circulars/bodycircular', 'CircularsController@bodycircularTo')->name('bodycircular');
  Route::post('/logistic/circulars/body/save', 'CircularsController@saveBody')->name('body.save');
  Route::post('/logistic/circulars/body/update', 'CircularsController@updateBody')->name('body.update');
  Route::post('/logistic/circulars/body/delete', 'CircularsController@deleteBody')->name('body.delete');
  //CIRCULARES
  Route::get('/logistic/circulars/academic', 'CircularsController@circularacademicTo')->name('circularacademic');
  Route::get('/logistic/circulars/academic/list', 'CircularsController@circularacademicToList')->name('circularacademic.list');
  Route::post('/logistic/circulars/academic/view', 'CircularsController@circularacademicToView')->name('circularacademic.view');
  Route::post('/logistic/circulars/academic/delete', 'CircularsController@circularacademicToDelete')->name('circularacademic.delete');
  Route::get('/logistic/circulars/academic/pdf', 'CircularsController@pdfCircularacademic')->name('circularacademic.pdf');
  Route::get('/logistic/circulars/administrative', 'CircularsController@circularadministrativeTo')->name('circularadministrative');
  Route::get('/logistic/circulars/administrative/list', 'CircularsController@circularadministrativeToList')->name('circularadministrative.list');
  Route::post('/logistic/circulars/administrative/view', 'CircularsController@circularadministrativeToView')->name('circularadministrative.view');
  Route::post('/logistic/circulars/administrative/delete', 'CircularsController@circularadministrativeToDelete')->name('circularadministrative.delete');
  Route::get('/logistic/circulars/administrative/pdf', 'CircularsController@pdfCircularadministrative')->name('circularadministrative.pdf');
  Route::get('/logistic/circulars/memo', 'CircularsController@circularmemoTo')->name('circularmemo');
  Route::get('/logistic/circulars/memo/list', 'CircularsController@circularmemoToList')->name('circularmemo.list');
  Route::post('/logistic/circulars/memo/view', 'CircularsController@circularmemoToView')->name('circularmemo.view');
  Route::post('/logistic/circulars/memo/delete', 'CircularsController@circularmemoToDelete')->name('circularmemo.delete');
  Route::get('/logistic/circulars/memo/pdf', 'CircularsController@pdfCircularmemo')->name('circularmemo.pdf');

  //AGENDA ESCOLAR
  Route::get('/logistic/school-schedule/greeting', 'ScheduleController@greetingTemplateTo')->name('greetingTemplate');
  Route::post('/logistic/school-schedule/greeting/save', 'ScheduleController@greetingSave')->name('greeting.save');
  Route::post('/logistic/school-schedule/greeting/update', 'ScheduleController@greetingEdit')->name('greeting.edit');
  Route::post('/logistic/school-schedule/greeting/delete', 'ScheduleController@greetingDelete')->name('greeting.delete');
  Route::get('/logistic/school-schedule/context', 'ScheduleController@contextTemplateTo')->name('contextTemplate');
  Route::post('/logistic/school-schedule/context/save', 'ScheduleController@contextSave')->name('context.save');
  Route::post('/logistic/school-schedule/context/update', 'ScheduleController@contextEdit')->name('context.edit');
  Route::post('/logistic/school-schedule/context/delete', 'ScheduleController@contextDelete')->name('context.delete');
  Route::get('/logistic/school-schedule/daily', 'ScheduleController@dailyInformationTo')->name('dailyInformation');
  Route::post('/logistic/school-schedule/daily/save', 'ScheduleController@dailyInformationToSave')->name('daily.save');
  Route::get('/logistic/school-schedule/file', 'ScheduleController@scheduleFileTo')->name('scheduleFile');
  Route::post('/logistic/school-schedule/file/delete', 'ScheduleController@dailyInformationToDelete')->name('file.destroy');
  Route::get('/logistic/school-schedule/emailers', 'ScheduleController@emailers')->name('Emailers');

  //INFORMES ESPECIALES
  Route::get('/reports/enrollments/list', 'ReportsController@listEnrollmentTo')->name('enrollments.list');
  Route::get('/reports/enrollments/list/excel', 'ReportsController@listExcel')->name('listStudentExcel');


  Route::get('/reports/enrollments/setting', 'ReportsController@settingReportTo')->name('setting.reports');
  Route::get('/reports/enrollments/setting/attendant', 'ReportsController@reportAttendantTo')->name('setting.reports.attendant');
  Route::get('/reports/enrollments/setting/excel', 'ReportsController@legalizationExcel')->name('legalizationExcel');


  Route::get('/reports/statistic/assistances', 'ReportsController@statisticAssistancesTo')->name('statistic.assitances');
  Route::get('/reports/statistic/increase', 'ReportsController@statisticIncreaseTo')->name('statistic.increase');
  Route::get('/reports/statistic/period', 'ReportsController@createStatistic')->name('statistic.period');


  Route::get('/reports/license/collaborators', 'ReportsController@createLicenseCollaborator')->name('license.collaborator');
  Route::get('/reports/license/students', 'ReportsController@createLicenseStudent')->name('license.student');
});

//RUTAS DEL MODULO ACADEMICO Y FINANCIERO
Route::group(['middleware' => ['role:ADMINISTRADOR|ADMINISTRADOR SISTEMA|ADMINISTRADOR JARDIN|ACADEMICO']], function () {

  Route::get('/academic/structure', 'AcademicoController@structureTo')->name('structure');

  Route::get('/academic/structure/gradeCourse', 'GradecoursesController@gradeCourseTo')->name('gradeCourse');
  Route::post('/academic/structure/gradeCourse/save', 'GradecoursesController@newGradeCourse')->name('gradeCourse.save');
  Route::get('/academic/structure/gradeCourse/edit', 'GradecoursesController@editGradeCourse')->name('gradeCourse.edit');
  Route::post('/academic/structure/gradeCourse/update', 'GradecoursesController@updateGradeCourse')->name('gradeCourse.update');
  Route::get('/academic/structure/gradeCourse/list', 'GradecoursesController@listGradeCourseTo')->name('listgradeCourse');
  Route::get('/academic/structure/gradeCourse/pdf', 'GradecoursesController@listGradeCoursePdf')->name('gradeCourse.pdf');
  Route::get('/academic/structure/gradeCourse/change', 'GradecoursesController@changeReload')->name('gradeCourse.change');

  Route::get('/academic/structure/activityspace', 'ActivityspacesController@activitySpaceTo')->name('activitySpace');
  Route::post('/academic/structure/activityspace/save', 'ActivityspacesController@newActivitySpace')->name('activitySpace.save');
  Route::post('/academic/structure/activityspace/update', 'ActivityspacesController@updateActivitySpace')->name('activitySpace.update');
  Route::post('/academic/structure/activityspace/delete', 'ActivityspacesController@deleteActivitySpace')->name('activitySpace.delete');

  Route::get('/academic/structure/activityclass', 'ActivityclassController@activityClassTo')->name('activityClass');
  Route::post('/academic/structure/activityclass/save', 'ActivityclassController@newActivityClass')->name('activityClass.save');
  Route::post('/academic/structure/activityclass/update', 'ActivityclassController@updateActivityClass')->name('activityClass.update');
  Route::post('/academic/structure/activityclass/delete', 'ActivityclassController@deleteActivityClass')->name('activityClass.delete');

  Route::get('/academic/programming/hoursweek', 'HourweeksController@hoursWeekTo')->name('hoursweek');
  Route::post('/academic/programming/hoursweek/delete', 'HourweeksController@deleteHoursWeek')->name('hourweek.delete');
  Route::get('/academic/programming/hoursweek/pdf', 'HourweeksController@pdfHoursWeek')->name('hourweek.pdf');

  Route::get('/academic/programming/academicperiod', 'AcademicperiodsController@academicPeriodTo')->name('academicperiod');
  Route::get('/academic/programming/academicperiod/new', 'AcademicperiodsController@newAcademicperiod')->name('academicperiod.new');
  Route::post('/academic/programming/academicperiod/save', 'AcademicperiodsController@saveAcademicperiod')->name('academicperiod.save');
  Route::post('/academic/programming/academicperiod/update', 'AcademicperiodsController@updateAcademicperiod')->name('academicperiod.update');
  Route::post('/academic/programming/academicperiod/delete', 'AcademicperiodsController@deleteAcademicperiod')->name('academicperiod.delete');

  // BASE DE ACTIVIDADES
  Route::get('/academic/programming/baseactivitys', 'AcademicoController@baseactivitysTo')->name('baseactivitys');
  Route::post('/academic/programming/baseactivitys/save', 'AcademicoController@saveBaseactivity')->name('baseactivitys.save');
  Route::post('/academic/programming/baseactivitys/update', 'AcademicoController@updateBaseactivity')->name('baseactivitys.update');
  Route::post('/academic/programming/baseactivitys/delete', 'AcademicoController@deleteBaseactivity')->name('baseactivitys.delete');

  Route::get('/academic/programming/planning', 'ChronologicalsController@planningTo')->name('planning');
  Route::post('/academic/programming/planning/new', 'ChronologicalsController@newPlanning')->name('planning.new');
  Route::get('/academic/programming/planning/pdf', 'ChronologicalsController@pdfPlanning')->name('planning.pdf');

  Route::get('/academic/evaluation/weeklyTracking', 'WeeklytrackingsController@weeklyTrackingTo')->name('weeklyTracking');
  Route::post('/academic/evaluation/weeklyTracking/new', 'WeeklytrackingsController@newWeekTracking')->name('weeklyTracking.new');
  Route::post('/academic/evaluation/weeklyTracking/save', 'WeeklytrackingsController@saveWeekTracking')->name('weeklyTracking.save');

  Route::get('/academic/evaluation/periodClosing', 'AcademicoController@periodClosingTo')->name('periodClosing');
  Route::post('/academic/evaluation/periodClosing/new', 'AcademicoController@savePeriodClosing')->name('periodClosing.new');

  // INFORMES DE PERIODO
  Route::get('/academic/evaluation/newsletters', 'BulletinsController@newslettersTo')->name('newsletters');
  Route::get('/academic/evaluation/newsletters/pdf', 'BulletinsController@newslettersPdf')->name('newsletters.pdf');

  // BOLETINES ESCOLARES
  Route::get('/academic/evaluation/bulletins', 'BulletinsController@bulletinTo')->name('bulletins');
  Route::get('/academic/evaluation/bulletins/pdf', 'BulletinsController@bulletinPdf')->name('bulletins.pdf');

  // FACTURACIONES
  Route::get('/financial/accounttants/facturations/general/save', 'GeneralController@generalSave')->name('general.save');
  Route::get('/financial/accounttants/facturations/general/numbers', 'GeneralController@generalNumbersSave')->name('general.numberinitial');

  Route::get('/financial/accounttants/facturations', 'FacturationsController@facturationTo')->name('facturations');
  Route::post('/financial/accounttants/facturations/new', 'FacturationsController@newFacturation')->name('facturation.new');
  Route::get('/financial/accounttants/facturations/all', 'FacturationsController@allFacturation')->name('facturation.all');
  Route::post('/financial/accounttants/facturations/edit', 'FacturationsController@editFacturation')->name('facturations.edit');

  Route::post('/financial/accounttants/facturations/approved', 'FacturationsController@approvedFacturation')->name('facturation.approved');
  Route::post('/financial/accounttants/facturations/denied', 'FacturationsController@deniedFacturation')->name('facturation.denied');
  Route::get('/financial/accounttants/facturations/pdf', 'FacturationsController@pdfFacturation')->name('facturation.pdf');
  Route::get('/financial/accounttants/facturations/email-pdf', 'FacturationsController@pdfFacturationEmail')->name('facturation.pdf-mail');
  Route::get('//financial/accounttants/facturations/xml', 'FacturationsController@xmlFacturation')->name('facturation.xml');

  Route::get('/financial/accounttants/facturations/defeated', 'FacturationsController@defeatedFacturation')->name('facturation.defeatedPdf');

  Route::get('/financial/accounttants/facturations/filterpdf', 'FacturationsController@pdfFilter')->name('facturation.filterpdf');
  Route::get('/financial/accounttants/facturations/accounts', 'FacturationsController@accountsPendingPdf')->name('facturation.accountsPendingPdf');

  //COMPROBANTES DEINGRESO
  Route::get('/financial/accounttants/entryvouchers', 'EntrysController@entryvoucherTo')->name('entryVouchers');
  Route::post('/financial/accounttants/entryvouchers/save', 'EntrysController@saveEntryvoucher')->name('entryVouchers.save');
  Route::get('/financial/accounttants/entryvouchers/pdf', 'EntrysController@pdfEntryvoucher')->name('entryVouchers.pdf');
  Route::get('/financial/accounttants/entryvouchers/excel', 'EntrysController@excelEntryvoucher')->name('entryVouchers.excel');
  Route::get('/financial/accounttants/entryvouchersfacturation/pdf', 'EntrysController@pdfEntryvoucherfacturation')->name('entryVouchersFacturation.pdf');

  //COMPROBANTES DE EGRESO
  Route::get('/financial/accounttants/agressvouchers', 'EgressController@egressvoucherTo')->name('egressVouchers');
  Route::post('/financial/accounttants/agressvouchers/save', 'EgressController@newEgressvoucher')->name('egressVouchers.save');
  Route::get('/financial/accounttants/agressvouchers/pdf', 'EgressController@pdfEgressvoucher')->name('egressVouchers.pdf');
  Route::get('/financial/accounttants/agressvouchers/excel', 'EgressController@excelEgressvoucher')->name('egressVouchers.excel');

  // FACTURAS ANULADAS
  Route::get('/financial/accounttants/canceled', 'CanceledController@canceledTo')->name('canceled');
  Route::get('/financial/accounttants/canceled/change', 'CanceledController@factureCanceled')->name('canceled.change');
  Route::get('/financial/accounttants/canceled/pdf', 'CanceledController@pdfCanceled')->name('canceled.pdf');
  Route::post('/financial/accounttants/canceled/pdf-all', 'CanceledController@factureCanceledall')->name('factureCanceled');

  //CONCILIACION DE SALDOS
  Route::get('/financial/accounttants/balances', 'ReportsController@balancesTo')->name('balances');

  // ESTADISTICAS DE DOCUMENTOS CONTABLES
  Route::get('/financial/accounttants/statistic/financial', 'StatisticsController@statisticSalesTo')->name('statistics.financial');
  Route::get('/financial/accounttants/statistic/financial/filter', 'StatisticsController@statisticSalesFilter')->name('statistics.financial.filter');

  //ESTADOS DE CUENTA
  Route::get('/financial/accounttants/accounts', 'AccountsController@accountsTo')->name('accounts');
  Route::get('/financial/accounttants/accounts/mount', 'AccountsController@getAccount')->name('accounts.get');
  Route::get('/financial/accounttants/accounts/items', 'AccountsController@getItemsConcepts')->name('accounts.items');
  Route::post('/financial/accounttants/accounts/change', 'AccountsController@getFormFacture')->name('accounts.factureTo');
  Route::get('/financial/accounttants/accounts/tramited', 'AccountsController@getFacturationtramited')->name('accounts.tramited');
  Route::get('/financial/accounttants/accounts/tramited/count', 'AccountsController@getFacturationtramitedcount')->name('accounts.tramited.count');

  /* ANALISIS DE PRESUPUESTO */

  // ESTRUCTURA DE COSTOS
  Route::get('/financial/analysis/coststructure', 'AccountsController@coststructureTo')->name('analysis.structure');
  Route::post('/financial/analysis/coststructure/new', 'AccountsController@newCoststructure')->name('analysis.newCoststructure');
  Route::post('/financial/analysis/coststructure/edit', 'AccountsController@editCoststructure')->name('analysis.editCoststructure');
  Route::post('/financial/analysis/coststructure/delete', 'AccountsController@deleteCoststructure')->name('analysis.deleteCoststructure');
  // DESCRIPCION DE COSTOS
  Route::get('/financial/analysis/costdescription', 'AccountsController@costdescriptionTo')->name('analysis.description');
  Route::post('/financial/analysis/costdescription/new', 'AccountsController@newCostdescription')->name('analysis.newCostdescription');
  Route::post('/financial/analysis/costdescription/edit', 'AccountsController@editCostdescription')->name('analysis.editCostdescription');
  Route::post('/financial/analysis/costdescription/delete', 'AccountsController@deleteCostdescription')->name('analysis.deleteCostdescription');
  // PRESUPUESTO ANUAL
  Route::get('/financial/analysis/budget', 'AnnualController@budgetTo')->name('analysis.budget');
  Route::post('/financial/analysis/budget/new', 'AnnualController@budgetSave')->name('budget.save');
  Route::post('/financial/analysis/budget/update', 'AnnualController@budgetUpdate')->name('budget.update');
  Route::post('/financial/analysis/budget/delete', 'AnnualController@budgetDelete')->name('budget.delete');
  // SEGUIMIENTO MENSUAL
  Route::get('/financial/analysis/follow', 'AccountsController@followMountTo')->name('analysis.follow');
  // INFORME DE CIERRE
  Route::get('/financial/analysis/report', 'AccountsController@reportCloseTo')->name('analysis.report');
  Route::get('/financial/analysis/report/excel', 'AccountsController@getReportcloseExcel')->name('analysis.reportclose.excel');
});

//RUTAS DEL MODULO COMERCIAL
Route::group(['middleware' => ['role:ADMINISTRADOR|ADMINISTRADOR SISTEMA|ADMINISTRADOR JARDIN|COMERCIAL']], function () {

  Route::get('/comercial', 'ComercialController@customerTo')->name('comercial');

  //CUSTOMERS AND SCHUDELINGS
  Route::get('/comercial/customers', 'CustomersController@index')->name('customers');
  Route::get('/comercial/customers/new', 'CustomersController@newCustomer')->name('customer.new');
  Route::post('/comercial/customers/save', 'CustomersController@saveCustomer')->name('customer.save');
  Route::get('/comercial/customers/edit/{id}', 'CustomersController@editCustomer')->name('customer.edit');
  Route::post('/comercial/customers/update/{id}', 'CustomersController@updateCustomer')->name('customer.update');
  Route::get('/comercial/customers/delete/{id}', 'CustomersController@deleteCustomer')->name('customer.delete');
  Route::get('/comercial/agenda', 'CustomersController@newAgenda')->name('newAgenda');
  Route::get('/comercial/agenda/scheduling/remember', 'CustomersController@rememberMail')->name('customer.remember');
  Route::get('/comercial/agenda/rescheduling', 'CustomersController@reschedulingCustomer')->name('customer.rescheduling');

  Route::get('/comercial/customers/scheduling/all', 'SchedulingsController@getScheduling')->name('scheduling.get');
  Route::post('/comercial/customers/scheduling/save', 'SchedulingsController@saveCustomerAndScheduling')->name('scheduling.save');
  Route::post('/comercial/customers/scheduling/saveAgenda', 'SchedulingsController@saveScheduling')->name('scheduling.only');
  Route::post('/comercial/customers/scheduling/savesameAgenda', 'SchedulingsController@reprogrammingScheduling')->name('scheduling.reprogramming');
  Route::post('/comercial/customers/scheduling/change', 'SchedulingsController@changeScheduling')->name('scheduling.change');
  Route::get('/comercial/customers/programming', 'SchedulingsController@index')->name('programming');
  Route::get('/comercial/customers/statistic', 'StatisticsController@statisticSchedulingTo')->name('statisticSchedulings');
  Route::get('/comercial/customers/statistic/otherYear/{year}', 'StatisticsController@getScheduling')->name('getOtheryear');
  Route::get('/comercial/customers/statistic/pending', 'StatisticsController@getPending')->name('scheduling.pending');
  Route::get('/comercial/customers/statistic/assisted', 'StatisticsController@getAssisted')->name('scheduling.assisted');
  Route::get('/comercial/customers/statistic/notAssisted', 'StatisticsController@getNotassisted')->name('scheduling.notassisted');
  Route::get('/comercial/customers/statistic/scheduling/pdf', 'StatisticsController@pdfScheduling')->name('schedulingPdf');

  //PROPOSAL
  Route::get('/comercial/proposals/customerproposal', 'ProposalsController@customerProposal')->name('customer_proposal');
  Route::get('/comercial/proposals/quotation', 'ProposalsController@quotationTo')->name('quotation');
  Route::post('/comercial/proposals/quotation/save', 'ProposalsController@saveQuotation')->name('quotation.save');
  Route::get('/comercial/proposals/tracing', 'ProposalsController@tracingTo')->name('tracing');
  Route::post('/comercial/proposals/binnacle', 'ProposalsController@saveBinnacle')->name('binnacle.save');
  Route::get('/comercial/proposals/files', 'ProposalsController@filesTo')->name('files');
  Route::get('/comercial/proposals/statistic', 'StatisticsController@statisticProposalTo')->name('statisticProposal');

  Route::get('/comercial/proposal/statistic/otherYear/{year}', 'StatisticsController@getProposals')->name('getProposal');
  Route::get('/comercial/proposal/statistic/approved', 'StatisticsController@getApproved')->name('proposal.approved');
  Route::get('/comercial/proposal/statistic/notapproved', 'StatisticsController@getNotapproved')->name('proposal.notapproved');
  Route::get('/comercial/proposal/statistic/scheduling/pdf', 'StatisticsController@pdfProposals')->name('proposalPdf');

  Route::post('/comercial/proposals/change', 'ProposalsController@changeStatusProposal')->name('aprovedToProposal');
  Route::post('/comercial/proposals/change/denied', 'ProposalsController@proposalDenied')->name('deniedToProposal');
  Route::get('tracing/pdf', 'ProposalsController@exportToPdf')->name('tracingsPdf');

  // ENROLLMENT DOCUMENTS
  Route::get('/comercial/enrollments', 'ComercialController@enrollmentTo')->name('enrollments');
  Route::get('/comercial/enrollments/documents', 'EnrollmentsController@documentsEnrollmentTo')->name('documentsEnrollment');
  Route::post('/comercial/enrollments/documents/new', 'EnrollmentsController@newDocumentsEnrollment')->name('newDocumentEnrollment');
  Route::post('/comercial/enrollments/documents/update', 'EnrollmentsController@updateDocumentsEnrollment')->name('updateDocumentEnrollment');
  Route::post('/comercial/enrollments/documents/delete', 'EnrollmentsController@deleteDocumentsEnrollment')->name('deleteDocumentEnrollment');
  Route::post('/comercial/enrollments/documents/updateForce', 'EnrollmentsController@updateConsolidatedEnrollmentWithoutDocuments')->name('saveConsolidatedWithoutDocuments');
  Route::get('/comercial/enrollments/documentsPending', 'EnrollmentsController@documentsPendingPdf')->name('getDocumentsPending');

  // ENROLLMENT CONSOLIDATED
  Route::get('/comercial/enrollments/consolidated', 'EnrollmentsController@consolidatedEnrollmentTo')->name('consolidatedEnrollment');
  Route::get('/comercial/enrollments/consolidated/new', 'EnrollmentsController@newConsolidatedEnrollment')->name('consolidatedEnrollment.new');
  Route::post('/comercial/enrollments/consolidated/save', 'EnrollmentsController@saveConsolidatedEnrollment')->name('consolidatedEnrollment.save');
  Route::post('/comercial/enrollments/consolidated/update', 'EnrollmentsController@updateConsolidatedEnrollment')->name('consolidatedEnrollment.update');

  // ENROLLMENT LEGALIZATION
  Route::get('/comercial/enrollments/legalization', 'EnrollmentsController@legalizationEnrollmentTo')->name('legalizationEnrollment');
  Route::post('/comercial/enrollments/legalization/new', 'EnrollmentsController@newlegalizationEnrollment')->name('legalizationEnrollment.new');
  Route::get('/comercial/enrollments/contract', 'EnrollmentsController@contractTo')->name('contracts');
  Route::get('/comercial/enrollments/contract/finish', 'EnrollmentsController@contractFinish')->name('contracts.finish');
  Route::get('/comercial/enrollments/contract/pdf', 'EnrollmentsController@contractPdf')->name('contractPdf');
  Route::get('/comercial/enrollments/certificates', 'EnrollmentsController@certificatesTo')->name('certificates');
  Route::get('/comercial/enrollments/certificates/pdf', 'EnrollmentsController@certificatesPdf')->name('certificatesPdf');
  Route::get('/comercial/enrollments/legalizationsfinished', 'EnrollmentsController@legalizationsfinishedTo')->name('legalizationsfinished');
  Route::get('/comercial/enrollments/legalizationsfinished/pdf', 'EnrollmentsController@legalizationsfinishedPdf')->name('legalizationsfinishedPdf');
});

//RUTAS DEL MODULO ADMINISTRATIVO
Route::group(['middleware' => ['role:ADMINISTRADOR|ADMINISTRADOR SISTEMA|ADMINISTRADOR JARDIN']], function () {


  Route::get('/administrative/database', 'AdministrativoController@databaseTo')->name('database');
  Route::get('/administrative/academic', 'AdministrativoController@academicTo')->name('academic');
  Route::get('/administrative/humans', 'AdministrativoController@humansTo')->name('humans');
  Route::get('/administrative/services', 'AdministrativoController@servicesTo')->name('services');

  //GENERAL
  Route::get('/administrative/general', 'GeneralController@generalTo')->name('general');

  //ADMISSIONS
  Route::get('/administrative/services/admissions', 'AdmissionsController@index')->name('admissions');
  Route::get('/administrative/services/admissions/new', 'AdmissionsController@newAdmission')->name('admission.new');
  Route::get('/administrative/services/admissions/edit/{id}', 'AdmissionsController@editAdmission')->name('admission.edit');
  Route::post('/administrative/services/admissions/update/{id}', 'AdmissionsController@updateAdmission')->name('admission.update');
  Route::get('/administrative/services/admissions/delete/{id}', 'AdmissionsController@deleteAdmission')->name('admission.delete');

  //JOURNEYS
  Route::get('/administrative/services/journeys', 'JourneysController@index')->name('journeys');
  Route::get('/administrative/services/journeys/new', 'JourneysController@newJourney')->name('journey.new');
  Route::post('/administrative/services/journeys/save', 'JourneysController@saveJourney')->name('journey.save');
  Route::get('/administrative/services/journeys/edit/{id}', 'JourneysController@editJourney')->name('journey.edit');
  Route::post('/administrative/services/journeys/update/{id}', 'JourneysController@updateJourney')->name('journey.update');
  Route::get('/administrative/services/journeys/delete/{id}', 'JourneysController@deleteJourney')->name('journey.delete');

  //FEEDING
  Route::get('/administrative/services/feedings', 'FeedingsController@index')->name('feedings');
  Route::get('/administrative/services/feedings/new', 'FeedingsController@newFeeding')->name('feeding.new');
  Route::post('/administrative/services/feedings/save', 'FeedingsController@saveFeeding')->name('feeding.save');
  Route::get('/administrative/services/feedings/edit/{id}', 'FeedingsController@editFeeding')->name('feeding.edit');
  Route::post('/administrative/services/feedings/update/{id}', 'FeedingsController@updateFeeding')->name('feeding.update');
  Route::get('/administrative/services/feedings/delete/{id}', 'FeedingsController@deleteFeeding')->name('feeding.delete');

  //UNIFORMS
  Route::get('/administrative/services/uniforms', 'UniformsController@index')->name('uniforms');
  Route::get('/administrative/services/uniforms/new', 'UniformsController@newUniform')->name('uniform.new');
  Route::post('/administrative/services/uniforms/save', 'UniformsController@saveUniform')->name('uniform.save');
  Route::get('/administrative/services/uniforms/edit/{id}', 'UniformsController@editUniform')->name('uniform.edit');
  Route::post('/administrative/services/uniforms/update/{id}', 'UniformsController@updateUniform')->name('uniform.update');
  Route::get('/administrative/services/uniforms/delete/{id}', 'UniformsController@deleteUniform')->name('uniform.delete');

  //SUPPLIES
  Route::get('/administrative/services/supplies', 'SuppliesController@index')->name('supplies');
  Route::get('/administrative/services/supplies/new', 'SuppliesController@newSupplie')->name('supplie.new');
  Route::post('/administrative/services/supplies/save', 'SuppliesController@saveSupplie')->name('supplie.save');
  Route::get('/administrative/services/supplies/edit/{id}', 'SuppliesController@editSupplie')->name('supplie.edit');
  Route::post('/administrative/services/supplies/update/{id}', 'SuppliesController@updateSupplie')->name('supplie.update');
  Route::get('/administrative/services/supplies/delete/{id}', 'SuppliesController@deleteSupplie')->name('supplie.delete');

  //EXTRACURRICULAR
  Route::get('/administrative/services/extracurriculars', 'ExtracurricularsController@index')->name('extracurriculars');
  Route::get('/administrative/services/extracurriculars/new', 'ExtracurricularsController@newExtracurricular')->name('extracurricular.new');
  Route::post('/administrative/services/extracurriculars/save', 'ExtracurricularsController@saveExtracurricular')->name('extracurricular.save');
  Route::get('/administrative/services/extracurriculars/edit/{id}', 'ExtracurricularsController@editExtracurricular')->name('extracurricular.edit');
  Route::post('/administrative/services/extracurriculars/update/{id}', 'ExtracurricularsController@updateExtracurricular')->name('extracurricular.update');
  Route::get('/administrative/services/extracurriculars/delete/{id}', 'ExtracurricularsController@deleteExtracurricular')->name('extracurricular.delete');

  //EXTRATIME
  Route::get('/administrative/services/extratimes', 'ExtratimesController@index')->name('extratimes');
  Route::get('/administrative/services/extratimes/new', 'ExtratimesController@newExtratime')->name('extratime.new');
  Route::post('/administrative/services/extratimes/save', 'ExtratimesController@saveExtratime')->name('extratime.save');
  Route::get('/administrative/services/extratimes/edit/{id}', 'ExtratimesController@editExtratime')->name('extratime.edit');
  Route::post('/administrative/services/extratimes/update/{id}', 'ExtratimesController@updateExtratime')->name('extratime.update');
  Route::get('/administrative/services/extratimes/delete/{id}', 'ExtratimesController@deleteExtratime')->name('extratime.delete');

  //TRANSPORT
  Route::get('/administrative/services/transports', 'TransportsController@index')->name('transports');
  Route::get('/administrative/services/transports/new', 'TransportsController@newTransport')->name('transport.new');
  Route::post('/administrative/services/transports/save', 'TransportsController@saveTransport')->name('transport.save');
  Route::get('/administrative/services/transports/edit/{id}', 'TransportsController@editTransport')->name('transport.edit');
  Route::post('/administrative/services/transports/update/{id}', 'TransportsController@updateTransport')->name('transport.update');
  Route::get('/administrative/services/transports/delete/{id}', 'TransportsController@deleteTransport')->name('transport.delete');

  //COLLABORATORS
  Route::get('/administrative/humans/collaborator', 'CollaboratorsController@index')->name('collaborators');
  Route::get('/administrative/humans/collaborator/new', 'CollaboratorsController@newCollaborator')->name('collaborator.new');
  Route::post('/administrative/humans/collaborator/save', 'CollaboratorsController@saveCollaborator')->name('collaborator.save');
  Route::get('/administrative/humans/collaborator/edit/{id}', 'CollaboratorsController@editCollaborator')->name('collaborator.edit');
  Route::post('/administrative/humans/collaborator/update/{id}', 'CollaboratorsController@updateCollaborator')->name('collaborator.update');
  Route::get('/administrative/humans/collaborator/details/{id}', 'CollaboratorsController@detailsCollaborator')->name('collaborator.details');
  Route::get('/administrative/humans/collaborator/delete/{id}', 'CollaboratorsController@deleteCollaborator')->name('collaborator.delete');

  //ATTENDANTS
  Route::get('/administrative/humans/attendant', 'AttendantsController@index')->name('attendants');
  Route::get('/administrative/humans/attendant/new', 'AttendantsController@newAttendant')->name('attendant.new');
  Route::post('/administrative/humans/attendant/save', 'AttendantsController@saveAttendant')->name('attendant.save');
  Route::get('/administrative/humans/attendant/edit/{id}', 'AttendantsController@editAttendant')->name('attendant.edit');
  Route::post('/administrative/humans/attendant/update/{id}', 'AttendantsController@updateAttendant')->name('attendant.update');
  Route::get('/administrative/humans/attendant/details/{id}', 'AttendantsController@detailsAttendant')->name('attendant.details');
  Route::get('/administrative/humans/attendant/delete/{id}', 'AttendantsController@deleteAttendant')->name('attendant.delete');
  Route::get('/administrative/humans/attendant/active/{id}', 'AttendantsController@activeAttendant')->name('attendant.active');
  Route::get('/administrative/humans/attendant/inactive/{id}', 'AttendantsController@inactiveAttendant')->name('attendant.inactive');

  //STUDENTS
  Route::get('/administrative/humans/student', 'StudentsController@index')->name('students');
  Route::get('/administrative/humans/student/new', 'StudentsController@newStudent')->name('student.new');
  Route::post('/administrative/humans/student/save', 'StudentsController@saveStudent')->name('student.save');
  Route::get('/administrative/humans/student/edit/{id}', 'StudentsController@editStudent')->name('student.edit');
  Route::post('/administrative/humans/student/update/{id}', 'StudentsController@updateStudent')->name('student.update');
  Route::get('/administrative/humans/student/details/{id}', 'StudentsController@detailsStudent')->name('student.details');
  Route::get('/administrative/humans/student/delete/{id}', 'StudentsController@deleteStudent')->name('student.delete');
  Route::get('/administrative/humans/student/active/{id}', 'StudentsController@activeStudent')->name('student.active');
  Route::get('/administrative/humans/student/inactive/{id}', 'StudentsController@inactiveStudent')->name('student.inactive');

  //PROVIDERS
  Route::get('/administrative/humans/provider', 'ProvidersController@index')->name('providers');
  Route::get('/administrative/humans/provider/new', 'ProvidersController@newProvider')->name('provider.new');
  Route::post('/administrative/humans/provider/save', 'ProvidersController@saveProvider')->name('provider.save');
  Route::get('/administrative/humans/provider/edit/{id}', 'ProvidersController@editProvider')->name('provider.edit');
  Route::post('/administrative/humans/provider/update/{id}', 'ProvidersController@updateProvider')->name('provider.update');
  Route::get('/administrative/humans/provider/details/{id}', 'ProvidersController@detailsProvider')->name('provider.details');
  Route::get('/administrative/humans/provider/delete/{id}', 'ProvidersController@deleteProvider')->name('provider.delete');

  //AUTHORIZED
  Route::get('/administrative/humans/authorized', 'AuthorizedController@index')->name('authorized');
  Route::get('/administrative/humans/authorized/new', 'AuthorizedController@newAuthorized')->name('authorized.new');
  Route::post('/administrative/humans/authorized/save', 'AuthorizedController@saveAuthorized')->name('authorized.save');
  Route::get('/administrative/humans/authorized/edit/{id}', 'AuthorizedController@editAuthorized')->name('authorized.edit');
  Route::post('/administrative/humans/authorized/update/{id}', 'AuthorizedController@updateAuthorized')->name('authorized.update');
  Route::get('/administrative/humans/authorized/details/{id}', 'AuthorizedController@detailsAuthorized')->name('authorized.details');
  Route::get('/administrative/humans/authorized/delete/{id}', 'AuthorizedController@deleteAuthorized')->name('authorized.delete');
  Route::get('/administrative/humans/authorized/active/{id}', 'AuthorizedController@activeAuthorized')->name('authorized.active');
  Route::get('/administrative/humans/authorized/inactive/{id}', 'AuthorizedController@inactiveAuthorized')->name('authorized.inactive');

  //COSOLIDE ACHIEVEMENT WITH AJAX REQUEST


  Route::get('/achievementAcademics', 'AdministrativoController@achievementTo')->name('achievementsAcademics');
  Route::get('subperiods', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $grade_id = key($objId);
      $period_from_grade = App\Models\Period::where('grade_id', '=', $grade_id)->get();
      return Response::json($period_from_grade);
    }
  });
  Route::get('subcourses', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $grade_id = key($objId);
      $course_from_grade = App\Models\Course::where('grade_id', '=', $grade_id)->get();
      return Response::json($course_from_grade);
    }
  })->name('subcourses');
  Route::get('subranges', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $dates_from_selected = App\Models\Period::where('id', '=', $objId['period'])
        ->where('grade_id', '=', $objId['grade'])->select('initialDate', 'finalDate')->get();
      return Response::json($dates_from_selected);
    }
  });
  Route::get('subachievements', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $intelligence_id = key($objId);
      $achievement_from_inteligence = App\Models\Intelligence::select('intelligences.*', 'achievements.id as achievementId', 'achievements.name')
        ->join('achievements', 'intelligences.id', '=', 'achievements.intelligence_id')
        ->where('intelligences.id', '=', $intelligence_id)
        ->get();
      return Response::json($achievement_from_inteligence);
    }
  });
  Route::get('subdescription', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $achievement_id = key($objId);
      $achievement_description = App\Models\Achievement::where('id', '=', $achievement_id)->select('description')->get();
      return Response::json($achievement_description);
    }
  });
  Route::post('/academic/achievement/new', 'AdministrativoController@newAchievementConsolide')->name('achievementConsolide.new');
  Route::get('/academic/achievement/view', 'AdministrativoController@achievementsAll')->name('consolidatedAchievements.all');
  Route::get('/academic/achievement/delete/{id}', 'AdministrativoController@deleteConsolidatedEchievement')->name('consolideAchievement.delete');
  Route::get('/academic/achievement/edit/{id}', 'AdministrativoController@editConsolidatedEchievement')->name('consolideAchievement.edit');

  //PERIODS
  Route::get('/academic/period', 'PeriodsController@index')->name('periods');
  Route::get('/academic/period/new', 'PeriodsController@newPeriod')->name('period.new');
  Route::get('/academic/period/edit/{id}', 'PeriodsController@editPeriod')->name('period.edit');
  Route::get('/academic/period/{id}', 'PeriodsController@updatePeriod')->name('period.save');
  Route::get('/academic/period/delete/{id}', 'PeriodsController@deletePeriod')->name('period.delete');

  //CITYS
  Route::get('/city', 'CitysController@index')->name('citys');
  Route::get('/city/new', 'CitysController@newCity')->name('city.new');
  Route::get('/city/edit/{id}', 'CitysController@editCity')->name('city.edit');
  Route::get('/city/{id}', 'CitysController@updateCity')->name('city.save');
  Route::get('/city/delete/{id}', 'CitysController@deleteCity')->name('city.delete');

  //LOCATIONS
  Route::get('/location', 'LocationsController@index')->name('locations');
  Route::get('/location/new', 'LocationsController@newLocation')->name('location.new');
  Route::get('/location/edit/{id}', 'LocationsController@editLocation')->name('location.edit');
  Route::get('/location/{id}', 'LocationsController@updateLocation')->name('location.save');
  Route::get('/location/delete/{id}', 'LocationsController@deleteLocation')->name('location.delete');

  //DISTRICTS
  Route::get('/district', 'DistrictsController@index')->name('districts');
  Route::get('/district/new', 'DistrictsController@newDistrict')->name('district.new');
  Route::get('/district/edit/{id}', 'DistrictsController@editDistrict')->name('district.edit');
  Route::get('/district/{id}', 'DistrictsController@updateDistrict')->name('district.save');
  Route::get('/district/delete/{id}', 'DistrictsController@deleteDistrict')->name('district.delete');

  Route::get('/sublocation', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $city_id = key($objId);
      $location_from_city = App\Models\Location::where('city_id', '=', $city_id)->get();
      return Response::json($location_from_city);
    }
  });

  Route::get('district/edit/sublocation', function () {
    if (Request::ajax()) {
      $objId = Request::input();
      $city_id = key($objId);
      $location_from_city = App\Models\Location::where('city_id', '=', $city_id)->get();
      return Response::json($location_from_city);
    }
  });

  //DOCUMENTS
  Route::get('/document', 'DocumentsController@index')->name('documents');
  Route::get('/document/new', 'DocumentsController@newDocument')->name('document.new');
  Route::get('/document/edit/{id}', 'DocumentsController@editDocument')->name('document.edit');
  Route::get('/document/{id}', 'DocumentsController@updateDocument')->name('document.save');
  Route::get('/document/delete/{id}', 'DocumentsController@deleteDocument')->name('document.delete');

  //BLOODTYPES
  Route::get('/bloodtype', 'BloodtypesController@index')->name('bloodtypes');
  Route::get('/bloodtype/new', 'BloodtypesController@newBloodtype')->name('bloodtype.new');
  Route::get('/bloodtype/edit/{id}', 'BloodtypesController@editBloodtype')->name('bloodtype.edit');
  Route::get('/bloodtype/{id}', 'BloodtypesController@updateBloodtype')->name('bloodtype.save');
  Route::get('/bloodtype/delete/{id}', 'BloodtypesController@deleteBloodtype')->name('bloodtype.delete');

  //PROFESSIONS
  Route::get('/profession', 'ProfessionsController@index')->name('professions');
  Route::get('/profession/new', 'ProfessionsController@newProfession')->name('profession.new');
  Route::get('/profession/edit/{id}', 'ProfessionsController@editProfession')->name('profession.edit');
  Route::get('/profession/{id}', 'ProfessionsController@updateProfession')->name('profession.save');
  Route::get('/profession/delete/{id}', 'ProfessionsController@deleteProfession')->name('profession.delete');

  //HEALTHS
  Route::get('/health', 'HealthsController@index')->name('healths');
  Route::get('/health/new', 'HealthsController@newHealth')->name('health.new');
  Route::get('/health/edit/{id}', 'HealthsController@editHealth')->name('health.edit');
  Route::get('/health/{id}', 'HealthsController@updateHealth')->name('health.save');
  Route::get('/health/delete/{id}', 'HealthsController@deleteHealth')->name('health.delete');

  //INTELLIGENCES
  Route::get('/intelligence', 'IntelligencesController@index')->name('intelligences');
  Route::get('/intelligence/new', 'IntelligencesController@newIntelligence')->name('intelligence.new');
  Route::get('/intelligence/edit/{id}', 'IntelligencesController@editIntelligence')->name('intelligence.edit');
  Route::get('/intelligence/{id}', 'IntelligencesController@updateIntelligence')->name('intelligence.save');
  Route::get('/intelligence/delete/{id}', 'IntelligencesController@deleteIntelligence')->name('intelligence.delete');

  //ACHIEVEMENTS
  Route::get('/achievement', 'AchievementsController@index')->name('achievements');
  Route::get('/achievement/new', 'AchievementsController@newAchievement')->name('achievement.new');
  Route::get('/achievement/edit/{id}', 'AchievementsController@editAchievement')->name('achievement.edit');
  Route::get('/achievement/{id}', 'AchievementsController@updateAchievement')->name('achievement.save');
  Route::get('/achievement/delete/{id}', 'AchievementsController@deleteAchievement')->name('achievement.delete');
  Route::post('/achievement/import/excel', 'AchievementsController@importExcelAchievement')->name('achievement.importExcel');

  //GRADES
  Route::get('/grade', 'GradesController@index')->name('grades');
  Route::get('/grade/new', 'GradesController@newGrade')->name('grade.new');
  Route::get('/grade/edit/{id}', 'GradesController@editGrade')->name('grade.edit');
  Route::get('/grade/{id}', 'GradesController@updateGrade')->name('grade.save');
  Route::get('/grade/delete/{id}', 'GradesController@deleteGrade')->name('grade.delete');

  //COURSES
  Route::get('/course', 'CoursesController@index')->name('courses');
  Route::get('/course/new', 'CoursesController@newCourse')->name('course.new');
  Route::get('/course/edit/{id}', 'CoursesController@editCourse')->name('course.edit');
  Route::get('/course/{id}', 'CoursesController@updateCourse')->name('course.save');
  Route::get('/course/delete/{id}', 'CoursesController@deleteCourse')->name('course.delete');

  // OBSERVACIONES
  Route::get('/observations', 'ObservationsController@observationsTo')->name('observations');
  Route::post('/observations/save', 'ObservationsController@newObservations')->name('observation.new');
  Route::post('/observations/update', 'ObservationsController@updateObservations')->name('observation.update');
  Route::post('/observations/delete', 'ObservationsController@deleteObservations')->name('observation.delete');


  //USERS
  Route::get('/user', 'UsersController@index')->name('users')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/user/new', 'UsersController@newUser')->name('user.new')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/user/add', 'UsersController@newsaveUser')->name('user.add')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/user/edit/{id}', 'UsersController@editUser')->name('user.edit')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/user/{id}', 'UsersController@updateUser')->name('user.save')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/user/delete/{id}', 'UsersController@deleteUser')->name('user.delete')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');

  //ROLES
  Route::get('/role', 'RolesController@index')->name('roles')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/role/new', 'RolesController@newRole')->name('role.new')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/role/edit/{id}', 'RolesController@editRole')->name('role.edit')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/role/{id}', 'RolesController@updateRole')->name('role.save')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/role/delete/{id}', 'RolesController@deleteRole')->name('role.delete')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');


  //PERMISSIONS
  Route::get('/permission', 'PermissionsController@index')->name('permissions')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/permission/new', 'PermissionsController@newPermission')->name('permission.new')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/permission/edit/{id}', 'PermissionsController@editPermission')->name('permission.edit')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/permission/{id}', 'PermissionsController@updatePermission')->name('permission.save')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
  Route::get('/permission/delete/{id}', 'PermissionsController@deletePermission')->name('permission.delete')->middleware('role:ADMINISTRADOR|ADMINISTRADOR SISTEMA');
});
